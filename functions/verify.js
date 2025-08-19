export async function onRequestPost(context) {
  try {
    const { query } = await context.request.json();

    // Fetch CSV file from your deployed Pages site
    const csvResp = await fetch("https://refund-portal.pages.dev/Investor%20Details.csv");
    if (!csvResp.ok) {
      throw new Error("Failed to load CSV file");
    }
    const csvData = await csvResp.text();

    const rows = csvData.split("\n").slice(1); // skip header
    let match = false;

    for (const row of rows) {
      const cols = row.split(",");
      const email = cols[3]?.trim();
      const telegram = cols[4]?.trim();
      if (query === email || query === telegram) {
        match = true;
        break;
      }
    }

    if (!match) {
      return new Response(JSON.stringify({ message: "No match found." }), {
        status: 404,
        headers: { "Content-Type": "application/json" },
      });
    }

    // Send email with SendGrid
    const SENDGRID_API_KEY = context.env.SENDGRID_API_KEY;
    const SENDGRID_FROM = "fkhan.codes@gmail.com"; // must be a verified sender in SendGrid
    const SENDGRID_TO = query.includes("@") ? query : "fallback@yourdomain.com";

    const mailData = {
      personalizations: [{ to: [{ email: SENDGRID_TO }] }],
      from: { email: SENDGRID_FROM },
      subject: "Action Required: Complete Your KYC Verification",
      content: [
        {
          type: "text/plain",
          value: `Dear Investor,

Your verification was successful. To complete the process, please proceed with KYC verification using Blockpass at the following link:

👉 https://verify-with.blockpass.org/?clientId=refund_portal_00d03

This step is required to finalize your registration.

Thank you,
Refund Portal Team`,
        },
        {
          type: "text/html",
          value: `<p>Dear Investor,</p>
                  <p>Your verification was successful. To complete the process, please proceed with KYC verification using Blockpass at the following link:</p>
                  <p><a href="https://verify-with.blockpass.org/?clientId=refund_portal_00d03" target="_blank">Complete KYC Verification</a></p>
                  <p>This step is required to finalize your registration.</p>
                  <p>Thank you,<br>Refund Portal Team</p>`,
        },
      ],
    };

    const sendResp = await fetch("https://api.sendgrid.com/v3/mail/send", {
      method: "POST",
      headers: {
        Authorization: `Bearer ${SENDGRID_API_KEY}`,
        "Content-Type": "application/json",
      },
      body: JSON.stringify(mailData),
    });

    if (sendResp.ok) {
      return new Response(JSON.stringify({ message: "Success! KYC email sent." }), {
        headers: { "Content-Type": "application/json" },
      });
    } else {
      return new Response(
        JSON.stringify({ message: "Match found but email failed." }),
        { status: 500, headers: { "Content-Type": "application/json" } }
      );
    }
  } catch (err) {
    return new Response(JSON.stringify({ message: "Error: " + err.message }), {
      status: 500,
      headers: { "Content-Type": "application/json" },
    });
  }
}

