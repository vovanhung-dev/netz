<!-- <!doctype html>
<html>
<body>
  <h2>New Career Application</h2>
  <p><strong>Name:</strong> {{ $data['name'] }}</p>
  <p><strong>Email:</strong> {{ $data['email'] }}</p>
  <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
  <p><strong>Position:</strong> {{ $data['position'] ?? '-' }}</p>
  <p><strong>Address:</strong> {{ $data['address'] ?? '-' }}</p>
  <p>CV is attached to this email.</p>
</body>
</html> -->


<!doctype html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <title>Ứng tuyển mới</title>
    <meta name="x-apple-disable-message-reformatting">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- Preheader (ẩn) -->
    <style>
      .preheader { display:none!important; visibility:hidden; opacity:0; color:transparent; height:0; width:0; overflow:hidden; mso-hide:all; }
      /* Dark mode hint */
      @media (prefers-color-scheme: dark) {
        body { background:#0b0f14 !important; }
        .wrapper { background:#0b0f14 !important; }
        .card { background:#121a23 !important; border-color:#1f2a37 !important; }
        .text, .label { color:#e5e7eb !important; }
        .muted { color:#9ca3af !important; }
        .btn { background:#2563eb !important; color:#ffffff !important; }
      }
      /* Mobile */
      @media screen and (max-width:600px){
        .container { width:100% !important; padding:0 16px !important; }
        .grid-2 { display:block !important; }
        .col { width:100% !important; display:block !important; }
      }
    </style>
  </head>
  <body style="margin:0; padding:0; background:#f3f4f6;">
    <span class="preheader">Có đơn ứng tuyển mới từ {{ $data['name'] }} cho vị trí {{ $data['position'] ?? '—' }}.</span>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" style="background:#f3f4f6;">
      <tr>
        <td align="center" style="padding:32px 16px;">
          <!-- Container -->
          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" class="container" style="width:600px; max-width:100%;">
            <!-- Header -->
            <tr>
              <td align="center" style="padding-bottom:16px;">
                <a href="{{ config('app.url') }}" style="text-decoration:none;">
                  <!-- Đổi logo nếu cần -->
                  <img src="{{ asset('../resources/js/src/assets/images/logo.png') }}" alt="{{ config('app.name') }}" width="140" style="display:block; border:0; max-width:140px;">
                </a>
              </td>
            </tr>

            <!-- Card -->
            <tr>
              <td class="card" style="background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
                <!-- Hero stripe -->
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td style="background:linear-gradient(90deg,#1d4ed8,#9333ea); height:4px; line-height:4px; font-size:0;">&nbsp;</td>
                  </tr>
                </table>

                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                    <td style="padding:24px 28px 8px 28px;">
                      <h2 class="text" style="margin:0; font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; font-size:22px; line-height:1.4; color:#111827;">
                        Đơn Ứng Tuyển Mới
                      </h2>
                      <p class="muted" style="margin:4px 0 0; font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; font-size:14px; color:#6b7280;">
                        Thời gian: {{ now()->format('d/m/Y H:i') }}
                      </p>
                    </td>
                  </tr>

                  <tr>
                    <td style="padding:8px 28px 24px 28px;">
                      <!-- Grid 2 cols -->
                      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" class="grid-2">
                        <tr>
                          <td class="col" width="50%" style="padding-right:12px; vertical-align:top;">
                            <p class="label" style="margin:0 0 6px; font:600 12px/1.4 ui-sans-serif,system-ui; color:#6b7280; text-transform:uppercase; letter-spacing:.04em;">Họ và tên</p>
                            <p class="text"  style="margin:0 0 14px; font:500 16px/1.6 ui-sans-serif,system-ui; color:#111827;">{{ $data['name'] }}</p>

                            <p class="label" style="margin:0 0 6px; font:600 12px/1.4 ui-sans-serif,system-ui; color:#6b7280; text-transform:uppercase; letter-spacing:.04em;">Email</p>
                            <p class="text"  style="margin:0 0 14px; font:500 16px/1.6 ui-sans-serif,system-ui; color:#111827;">
                              <a href="mailto:{{ $data['email'] }}" style="color:#1d4ed8; text-decoration:none;">{{ $data['email'] }}</a>
                            </p>

                            <p class="label" style="margin:0 0 6px; font:600 12px/1.4 ui-sans-serif,system-ui; color:#6b7280; text-transform:uppercase; letter-spacing:.04em;">Điện thoại</p>
                            <p class="text"  style="margin:0 0 14px; font:500 16px/1.6 ui-sans-serif,system-ui; color:#111827;">
                              <a href="tel:{{ $data['phone'] }}" style="color:#111827; text-decoration:none;">{{ $data['phone'] }}</a>
                            </p>
                          </td>

                          <td class="col" width="50%" style="padding-left:12px; vertical-align:top;">
                            <p class="label" style="margin:0 0 6px; font:600 12px/1.4 ui-sans-serif,system-ui; color:#6b7280; text-transform:uppercase; letter-spacing:.04em;">Vị trí</p>
                            <p class="text"  style="margin:0 0 14px; font:500 16px/1.6 ui-sans-serif,system-ui; color:#111827;">{{ $data['position'] ?? '—' }}</p>

                            <p class="label" style="margin:0 0 6px; font:600 12px/1.4 ui-sans-serif,system-ui; color:#6b7280; text-transform:uppercase; letter-spacing:.04em;">Địa chỉ</p>
                            <p class="text"  style="margin:0 0 14px; font:500 16px/1.6 ui-sans-serif,system-ui; color:#111827;">{{ $data['address'] ?? '—' }}</p>
                          </td>
                        </tr>
                      </table>

                      <!-- Divider -->
                      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:8px 0 16px;">
                        <tr><td style="height:1px; background:#e5e7eb; line-height:1px; font-size:0;">&nbsp;</td></tr>
                      </table>

                      <p class="text" style="margin:0 0 18px; font:500 15px/1.7 ui-sans-serif,system-ui; color:#111827;">
                        CV được đính kèm theo email này.
                      </p>

                      <!-- CTA row -->
                      <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td>
                            <a class="btn" href="{{ $data['cv_url'] ?? '#' }}" target="_blank"
                               style="display:inline-block; background:#111827; color:#ffffff; font:600 14px/1 ui-sans-serif,system-ui; text-decoration:none; padding:12px 18px; border-radius:8px;">
                              Xem / Tải CV
                            </a>
                          </td>
                          @if(!empty($data['job_url']))
                          <td style="width:12px;"></td>
                          <td>
                            <a class="btn" href="{{ $data['job_url'] }}" target="_blank"
                               style="display:inline-block; background:#1d4ed8; color:#ffffff; font:600 14px/1 ui-sans-serif,system-ui; text-decoration:none; padding:12px 18px; border-radius:8px;">
                              Xem tin tuyển dụng
                            </a>
                          </td>
                          @endif
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- Footer -->
            <tr>
              <td align="center" style="padding:16px 8px;">
                <p class="muted" style="margin:0; font:500 12px/1.6 ui-sans-serif,system-ui; color:#6b7280;">
                  Email tự động từ hệ thống tuyển dụng {{ config('app.name') }}.
                </p>
              </td>
            </tr>

          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
