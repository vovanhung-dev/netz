<!-- <!doctype html>
<html>
<body>
  <p>Hi {{ $data['name'] }},</p>
  <p>Thanks for applying to our company. We’ve received your application for the position
    <strong>{{ $data['position'] ?? '-' }}</strong>.</p>
  <p>Our HR team will review your information and get back to you soon.</p>
  <p>Best regards,<br>HR Team</p>
</body>
</html> -->


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Application Received</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <style>
    /* Preheader (hidden) */
    .preheader{display:none!important;visibility:hidden;opacity:0;color:transparent;height:0;width:0;overflow:hidden;mso-hide:all;}
    /* Mobile */
    @media screen and (max-width:600px){
      .container{width:100%!important;padding:0 16px!important;}
      .content{padding:20px!important;}
    }
    /* Dark mode hint */
    @media (prefers-color-scheme: dark){
      body{background:#0b0f14!important;}
      .wrap{background:#0b0f14!important;}
      .card{background:#121a23!important;border-color:#1f2a37!important;}
      .text{color:#e5e7eb!important;}
      .muted{color:#9ca3af!important;}
      .btn{background:#2563eb!important;color:#ffffff!important;}
    }
  </style>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;">
  <!-- Preheader -->
  <div class="preheader">Thanks {{ $data['name'] }}, we’ve received your application for {{ $data['position'] ?? 'the role' }}.</div>

  <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" class="wrap" style="background:#f3f4f6;">
    <tr>
      <td align="center" style="padding:32px 16px;">
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" class="container" style="width:600px;max-width:100%;">
          <!-- Header -->
          <tr>
            <td align="center" style="padding-bottom:16px;">
              <a href="{{ config('app.url') }}" style="text-decoration:none;">
                <img src="{{ asset('../resources/js/src/assets/images/logo.png') }}" alt="{{ config('app.name') }}" width="120" style="display:block;border:0;max-width:120px;">
              </a>
            </td>
          </tr>

          <!-- Card -->
          <tr>
            <td class="card" style="background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
              <!-- Accent line -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr><td style="background:linear-gradient(90deg,#1d4ed8,#9333ea);height:4px;line-height:4px;font-size:0;">&nbsp;</td></tr>
              </table>

              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td class="content" style="padding:24px 28px;">
                    <p class="text" style="margin:0 0 12px;font:500 16px/1.7 ui-sans-serif,system-ui,Segoe UI,Roboto,Helvetica,Arial;color:#111827;">
                      Hi {{ $data['name'] }},
                    </p>

                    <h2 class="text" style="margin:0 0 12px;font:700 22px/1.4 ui-sans-serif,system-ui,Segoe UI,Roboto,Helvetica,Arial;color:#111827;">
                      Thanks for applying!
                    </h2>

                    <p class="text" style="margin:0 0 16px;font:500 15px/1.7 ui-sans-serif,system-ui,Segoe UI,Roboto,Helvetica,Arial;color:#111827;">
                      We’ve received your application for the position
                      <strong>{{ $data['position'] ?? '-' }}</strong>. Our HR team will review your information and get back to you soon.
                    </p>

                    <!-- Info block -->
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin:12px 0 18px;">
                      <tr>
                        <td style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;padding:12px 14px;">
                          <p class="muted" style="margin:0;font:600 12px/1.6 ui-sans-serif,system-ui;text-transform:uppercase;letter-spacing:.04em;color:#6b7280;">
                            Summary
                          </p>
                          <p class="text" style="margin:6px 0 0;font:500 14px/1.7 ui-sans-serif,system-ui;color:#111827;">
                            • Candidate: {{ $data['name'] }}<br>
                            • Role: {{ $data['position'] ?? '-' }}<br>
                            • Received: {{ now()->format('d/m/Y H:i') }}
                          </p>
                        </td>
                      </tr>
                    </table>

                    <!-- CTA (optional: portal_url) -->
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:6px 0 0;">
                      <tr>
                        <td>
                          <a href="{{ $data['portal_url'] ?? config('app.url') }}" target="_blank"
                             class="btn"
                             style="display:inline-block;background:#111827;color:#ffffff;text-decoration:none;font:600 14px/1 ui-sans-serif,system-ui;padding:12px 18px;border-radius:8px;">
                            Visit Careers Portal
                          </a>
                        </td>
                      </tr>
                    </table>

                    <!-- Divider -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0 16px;">
                      <tr><td style="height:1px;background:#e5e7eb;line-height:1px;font-size:0;">&nbsp;</td></tr>
                    </table>

                    <p class="muted" style="margin:0;font:500 13px/1.7 ui-sans-serif,system-ui;color:#6b7280;">
                      If you have any questions, reply to this email or contact us at
                      <a href="mailto:hr@{{ parse_url(config('app.url'), PHP_URL_HOST) ?: 'yourdomain.com' }}"
                         style="color:#1d4ed8;text-decoration:none;">HR</a>.
                    </p>

                    <p class="text" style="margin:14px 0 0;font:500 15px/1.7 ui-sans-serif,system-ui;color:#111827;">
                      Best regards,<br>
                      HR Team – {{ config('app.name') }}
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td align="center" style="padding:16px 8px;">
              <p class="muted" style="margin:0;font:500 12px/1.6 ui-sans-serif,system-ui;color:#6b7280;">
                This is an automated message. Please do not share sensitive information by email.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
