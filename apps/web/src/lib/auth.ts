import { db, schema } from "@mewe/db";
import { currentPlan, startTrial } from "@mewe/core";
import { betterAuth } from "better-auth";
import { drizzleAdapter } from "better-auth/adapters/drizzle";
import { nextCookies } from "better-auth/next-js";
import { magicLink, organization, twoFactor } from "better-auth/plugins";
import Redis from "ioredis";
import { sendMail } from "./email";
import { ac, roles } from "./permissions";

const appUrl = process.env.APP_URL ?? "http://localhost:3000";
const redis = process.env.REDIS_URL ? new Redis(process.env.REDIS_URL, { lazyConnect: true }) : null;

const social: Parameters<typeof betterAuth>[0]["socialProviders"] = {};
if (process.env.GOOGLE_CLIENT_ID)
  social.google = { clientId: process.env.GOOGLE_CLIENT_ID, clientSecret: process.env.GOOGLE_CLIENT_SECRET! };
if (process.env.FACEBOOK_CLIENT_ID)
  social.facebook = { clientId: process.env.FACEBOOK_CLIENT_ID, clientSecret: process.env.FACEBOOK_CLIENT_SECRET! };
if (process.env.GITHUB_CLIENT_ID)
  social.github = { clientId: process.env.GITHUB_CLIENT_ID, clientSecret: process.env.GITHUB_CLIENT_SECRET! };

export const auth = betterAuth({
  appName: "MeweMarket",
  baseURL: appUrl,
  secret: process.env.AUTH_SECRET,
  database: drizzleAdapter(db, {
    provider: "pg",
    schema: {
      user: schema.users,
      session: schema.sessions,
      account: schema.accounts,
      verification: schema.verifications,
      organization: schema.workspaces,
      member: schema.members,
      invitation: schema.invitations,
      twoFactor: schema.twoFactors,
    },
  }),
  // Shared across PM2 cluster instances: rate limits and session cache.
  secondaryStorage: redis
    ? {
        get: (key) => redis.get(key),
        set: async (key, value, ttl) => {
          if (ttl) await redis.set(key, value, "EX", ttl);
          else await redis.set(key, value);
        },
        delete: async (key) => {
          await redis.del(key);
        },
        getAndDelete: (key) => redis.getdel(key),
        // TTL only on creation, per the SecondaryStorage contract.
        increment: async (key, ttl) => {
          const [[, count]] = (await redis.multi().incr(key).exec()) as [[null, number]];
          if (count === 1) await redis.expire(key, ttl);
          return count;
        },
      }
    : undefined,
  rateLimit: {
    enabled: true,
    window: 60,
    max: 100,
    customRules: { "/sign-in/*": { window: 60, max: 10 }, "/sign-up/*": { window: 60, max: 5 }, "/forget-password": { window: 300, max: 3 } },
  },
  user: {
    additionalFields: { role: { type: "string", defaultValue: "user", input: false } },
  },
  emailAndPassword: {
    enabled: true,
    minPasswordLength: 10,
    requireEmailVerification: true,
    sendResetPassword: async ({ user, url }) =>
      sendMail({
        to: user.email, subject: "Reset your MeweMarket password", heading: "Reset your password",
        body: "Someone asked to reset the password for this account. If that wasn't you, ignore this email.",
        cta: { label: "Choose a new password", url },
      }),
  },
  emailVerification: {
    sendOnSignUp: true,
    autoSignInAfterVerification: true,
    sendVerificationEmail: async ({ user, url }) =>
      sendMail({
        to: user.email, subject: "Verify your email", heading: `Welcome, ${user.name.split(" ")[0]}`,
        body: "Confirm your email address to finish setting up your MeweMarket account.",
        cta: { label: "Verify email", url },
      }),
  },
  socialProviders: social,
  session: { expiresIn: 60 * 60 * 24 * 30, updateAge: 60 * 60 * 24 },
  plugins: [
    organization({
      ac,
      roles,
      creatorRole: "owner",
      // Plan seat limit; -1 means unlimited.
      membershipLimit: async (_user, ws) => {
        const n = (await currentPlan(ws.id)).limits.users;
        return n < 0 ? 100_000 : n;
      },
      sendInvitationEmail: async ({ id, email, inviter, organization: ws }) =>
        sendMail({
          to: email, subject: `${inviter.user.name} invited you to ${ws.name}`, heading: `Join ${ws.name} on MeweMarket`,
          body: `${inviter.user.name} invited you to collaborate in the ${ws.name} workspace.`,
          cta: { label: "Accept invitation", url: `${appUrl}/invite/${id}` },
        }),
      organizationHooks: {
        afterCreateOrganization: async ({ organization: ws }) => startTrial(ws.id),
      },
    }),
    twoFactor({ issuer: "MeweMarket" }),
    magicLink({
      sendMagicLink: async ({ email, url }) =>
        sendMail({ to: email, subject: "Your MeweMarket sign-in link", heading: "Sign in to MeweMarket", body: "This link expires in 5 minutes.", cta: { label: "Sign in", url } }),
    }),
    nextCookies(),
  ],
});

export type Session = typeof auth.$Infer.Session;
