import nodemailer from "nodemailer";

// SMTP mailbox for the domain. Port 465 uses TLS from the start; other ports (587) upgrade with STARTTLS.
const port = Number(process.env.SMTP_PORT || 587);
const transport = process.env.SMTP_HOST
  ? nodemailer.createTransport({
      host: process.env.SMTP_HOST,
      port,
      secure: port === 465,
      auth: process.env.SMTP_USER ? { user: process.env.SMTP_USER, pass: process.env.SMTP_PASS } : undefined,
    })
  : null;
const from = process.env.EMAIL_FROM ?? "MeweMarket <hello@mewemarket.com>";

type Mail = { to: string; subject: string; heading: string; body: string; cta?: { label: string; url: string } };

function render({ heading, body, cta }: Mail) {
  const button = cta
    ? `<p style="margin:28px 0"><a href="${cta.url}" style="background:#6366f1;color:#fff;padding:12px 20px;border-radius:8px;text-decoration:none;font-weight:600">${cta.label}</a></p>
       <p style="color:#64748b;font-size:13px">Or paste this link into your browser:<br>${cta.url}</p>`
    : "";
  return `<div style="font-family:-apple-system,Segoe UI,Roboto,sans-serif;max-width:520px;margin:0 auto;padding:32px 16px;color:#0b0f19">
    <p style="font-weight:700;font-size:18px">MeweMarket</p>
    <h1 style="font-size:22px">${heading}</h1>
    <p style="line-height:1.6">${body}</p>${button}
  </div>`;
}

// Without SMTP settings (local dev) mail is logged instead of sent.
export async function sendMail(mail: Mail) {
  if (!transport) {
    console.log(`[mail] to=${mail.to} subject="${mail.subject}" ${mail.cta?.url ?? ""}`);
    return;
  }
  const text = `${mail.heading}\n\n${mail.body.replace(/<[^>]+>/g, "")}${mail.cta ? `\n\n${mail.cta.label}: ${mail.cta.url}` : ""}`;
  await transport.sendMail({ from, to: mail.to, subject: mail.subject, html: render(mail), text });
}
