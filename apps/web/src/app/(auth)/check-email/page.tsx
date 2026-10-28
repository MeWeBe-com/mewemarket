import { TextLink } from "@/components/ui";

export default async function CheckEmailPage({ searchParams }: { searchParams: Promise<{ email?: string }> }) {
  const { email } = await searchParams;
  return (
    <div className="text-center">
      <h1 className="text-2xl font-bold">Check your email</h1>
      <p className="mt-3 text-[var(--muted)]">
        We sent a verification link to {email ? <strong className="text-[var(--fg)]">{email}</strong> : "your inbox"}.
        Click it to finish setting up your account.
      </p>
      <p className="mt-6 text-sm"><TextLink href="/sign-in">Back to sign in</TextLink></p>
    </div>
  );
}
