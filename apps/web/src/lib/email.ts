import { Resend } from "resend";

const resend = process.env.RESEND_API_KEY ? new Resend(process.env.RESEND_API_KEY) : null;
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

// Templates move to React Email in M12. Without an API key (local dev) mail is logged instead of sent.
export async function sendMail(mail: Mail) {
  if (!resend) {
    console.log(`[mail] to=${mail.to} subject="${mail.subject}" ${mail.cta?.url ?? ""}`);
    return;
  }
  const { error } = await resend.emails.send({ from, to: mail.to, subject: mail.subject, html: render(mail) });
  if (error) throw new Error(`Email failed: ${error.message}`);
}
