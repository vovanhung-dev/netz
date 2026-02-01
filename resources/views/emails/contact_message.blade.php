<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>New contact message</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <style>
    /* Preheader ẩn trong hộp thư đến */
    .preheader{display:none!important;visibility:hidden;opacity:0;color:transparent;height:0;width:0;overflow:hidden;mso-hide:all;}
    /* Mobile */
    @media screen and (max-width:600px){
      .container{width:100%!important;padding:0 16px!important;}
      .content{padding:20px!important;}
      .grid-2{display:block!important;}
      .col{display:block!important;width:100%!important;}
    }
    /* Dark mode gợi ý */
    @media (prefers-color-scheme: dark){
      body{background:#0b0f14!important;}
      .wrap{background:#0b0f14!important;}
      .card{background:#121a23!important;border-color:#1f2a37!important;}
      .text{color:#e5e7eb!important;}
      .muted{color:#9ca3af!important;}
      .btn{background:#2563eb!important;color:#ffffff!important;}
      .msgbox{background:#0e1620!important;border-color:#1f2a37!important;}
      .pill{background:#111827!important;border-color:#1f2a37!important;color:#e5e7eb!important;}
    }
  </style>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;">
  <!-- Preheader: hiện trong preview của hộp thư -->
  <div class="preheader">
    New message from {{ $m->name }} ({{ $m->email }}) — {{ $m->subject ?? 'No subject' }}
  </div>

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
                    <h2 class="text" style="margin:0 0 8px;font:700 20px/1.4 ui-sans-serif,system-ui,Segoe UI,Roboto,Helvetica,Arial;color:#111827;">
                      New contact message
                    </h2>
                    <p class="muted" style="margin:0 0 18px;font:500 13px/1.7 ui-sans-serif,system-ui;color:#6b7280;">
                      Received at {{ $m->created_at }}
                    </p>

                    <!-- Info grid -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" class="grid-2">
                      <tr>
                        <td class="col" width="50%" style="vertical-align:top;padding-right:10px;">
                          <p class="muted" style="margin:0 0 6px;font:600 12px/1.6 ui-sans-serif;letter-spacing:.04em;text-transform:uppercase;color:#6b7280;">Name</p>
                          <p class="text" style="margin:0 0 14px;font:500 15px/1.7 ui-sans-serif;color:#111827;">{{ $m->name }}</p>

                          <p class="muted" style="margin:0 0 6px;font:600 12px/1.6 ui-sans-serif;letter-spacing:.04em;text-transform:uppercase;color:#6b7280;">Email</p>
                          <p class="text" style="margin:0 0 14px;font:500 15px/1.7 ui-sans-serif;color:#111827;">
                            <a href="mailto:{{ $m->email }}" style="color:#1d4ed8;text-decoration:none;">{{ $m->email }}</a>
                          </p>
                        </td>
                        <td class="col" width="50%" style="vertical-align:top;padding-left:10px;">
                          @if($m->phone)
                          <p class="muted" style="margin:0 0 6px;font:600 12px/1.6 ui-sans-serif;letter-spacing:.04em;text-transform:uppercase;color:#6b7280;">Phone</p>
                          <p class="text" style="margin:0 0 14px;font:500 15px/1.7 ui-sans-serif;color:#111827;">
                            <a href="tel:{{ $m->phone }}" style="color:#111827;text-decoration:none;">{{ $m->phone }}</a>
                          </p>
                          @endif

                          @if($m->subject)
                          <p class="muted" style="margin:0 0 6px;font:600 12px/1.6 ui-sans-serif;letter-spacing:.04em;text-transform:uppercase;color:#6b7280;">Subject</p>
                          <p class="text pill" style="margin:0 0 14px;font:600 13px/1.6 ui-sans-serif;color:#111827;background:#f8fafc;border:1px solid #e5e7eb;border-radius:999px;display:inline-block;padding:6px 10px;">
                            {{ $m->subject }}
                          </p>
                          @endif
                        </td>
                      </tr>
                    </table>

                    <!-- Divider -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:6px 0 16px;">
                      <tr><td style="height:1px;background:#e5e7eb;line-height:1px;font-size:0;">&nbsp;</td></tr>
                    </table>

                    <!-- Message box -->
                    <p class="muted" style="margin:0 0 6px;font:600 12px/1.6 ui-sans-serif;letter-spacing:.04em;text-transform:uppercase;color:#6b7280;">Message</p>
                    <div class="msgbox" style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;padding:14px 16px;">
                      <!-- Giữ xuống dòng và khoảng trắng, vẫn escape nội dung -->
                      <div class="text" style="white-space:pre-wrap;word-wrap:break-word;font:500 15px/1.7 ui-sans-serif,system-ui;color:#111827;">
                        {{ $m->message }}
                      </div>
                    </div>

                    <!-- CTA -->
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:18px 0 0;">
                      <tr>
                        <td>
                          <a href="mailto:{{ $m->email }}" target="_blank"
                             class="btn"
                             style="display:inline-block;background:#111827;color:#ffffff;text-decoration:none;font:600 14px/1 ui-sans-serif,system-ui;padding:12px 18px;border-radius:8px;">
                            Reply to {{ $m->name }}
                          </a>
                        </td>
                        @if(!empty($m->admin_url))
                        <td style="width:12px;"></td>
                        <td>
                          <a href="{{ $m->admin_url }}" target="_blank"
                             class="btn"
                             style="display:inline-block;background:#1d4ed8;color:#ffffff;text-decoration:none;font:600 14px/1 ui-sans-serif,system-ui;padding:12px 18px;border-radius:8px;">
                            View in Admin
                          </a>
                        </td>
                        @endif
                      </tr>
                    </table>

                    <!-- Footer meta -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0 0;">
                      <tr><td style="height:1px;background:#e5e7eb;line-height:1px;font-size:0;">&nbsp;</td></tr>
                    </table>
                    <p class="muted" style="margin:10px 0 0;font:500 12px/1.7 ui-sans-serif,system-ui;color:#6b7280;">
                      IP: {{ $m->ip }} &nbsp;|&nbsp; Sent at: {{ $m->created_at }}
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Global footer -->
          <tr>
            <td align="center" style="padding:16px 8px;">
              <p class="muted" style="margin:0;font:500 12px/1.6 ui-sans-serif,system-ui;color:#6b7280;">
                Automated notification from {{ config('app.name') }}.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
