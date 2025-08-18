export async function onRequestPost(context) {
  try {
    const { query } = await context.request.json();

    // Load your CSV (for simplicity, store in KV or hardcode sample data)
    // For production, upload CSV to KV or D1 database
    const csvData = `Wallet,Source,File Name,Email ID,Telegram ID
faiz,,,fkhan.codes@gmail.com,@faiz`;

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
    const SENDGRID_FROM = "fkhan.codes@gmail.com"; // change this
    const SENDGRID_TO = query.includes("@") ? query : "fallback@yourdomain.com";

    const mailData = {
      personalizations: [{ to: [{ email: SENDGRID_TO }] }],
      from: { email: SENDGRID_FROM },
      subject: "Verification Successful",
      content: [{ type: "text/plain", value: "Your verification was successful!" }],
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
      return new Response(JSON.stringify({ message: "Success! Email sent." }), {
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
