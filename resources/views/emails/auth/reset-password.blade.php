<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:Arial,Helvetica,sans-serif;color:#0f172a;">
    <div style="padding:28px 12px;">
        <div style="max-width:640px;margin:0 auto;background:#ffffff;border-radius:18px;overflow:hidden;border:1px solid #e2e8f0;">
            <div style="padding:26px 26px 22px;background:linear-gradient(135deg,#0f172a 0%,#1d4ed8 55%,#38bdf8 100%);color:#ffffff;">
                <div style="display:inline-block;padding:6px 12px;border-radius:999px;background:rgba(255,255,255,0.16);font-size:12px;font-weight:700;letter-spacing:0.06em;">
                    KEAMANAN AKUN
                </div>
                <h1 style="margin:14px 0 8px;font-size:24px;line-height:1.25;">
                    Permintaan Reset Password
                </h1>
                <p style="margin:0;font-size:14px;line-height:1.8;color:rgba(255,255,255,0.9);">
                    Kami menerima permintaan untuk mengatur ulang password akun Anda di <strong>{{ $appName }}</strong>.
                </p>
            </div>

            <div style="padding:26px;">
                <p style="margin:0 0 14px;font-size:14px;line-height:1.8;">
                    Halo <strong>{{ $nama }}</strong>,
                </p>

                <p style="margin:0 0 18px;font-size:14px;line-height:1.8;color:#334155;">
                    Klik tombol di bawah ini untuk membuat password baru. Tautan ini berlaku selama <strong>{{ $expire }} menit</strong>.
                </p>

                <div style="margin:22px 0;text-align:center;">
                    <a href="{{ $resetUrl }}" style="display:inline-block;padding:12px 18px;border-radius:12px;background:#2563eb;color:#ffffff;text-decoration:none;font-size:14px;font-weight:700;">
                        Atur Password Baru
                    </a>
                </div>

                <div style="padding:14px 16px;border-radius:14px;border:1px solid #e2e8f0;background:#f8fafc;">
                    <div style="font-size:12px;font-weight:700;color:#1d4ed8;margin-bottom:8px;">
                        Informasi Permintaan
                    </div>
                    <div style="font-size:13px;line-height:1.8;color:#334155;">
                        <div>Email: <strong>{{ $email }}</strong></div>
                        <div>Masa berlaku: <strong>{{ $expire }} menit</strong></div>
                    </div>
                </div>

                <p style="margin:18px 0 8px;font-size:13px;line-height:1.8;color:#475569;">
                    Jika tombol tidak berfungsi, salin tautan berikut dan buka di browser:
                </p>
                <p style="margin:0;word-break:break-all;font-size:12px;line-height:1.8;color:#2563eb;">
                    {{ $resetUrl }}
                </p>

                <div style="margin-top:20px;padding-top:16px;border-top:1px solid #e2e8f0;">
                    <p style="margin:0 0 8px;font-size:13px;line-height:1.8;color:#475569;">
                        Jika Anda tidak merasa meminta reset password, abaikan email ini. Password akun Anda tidak akan berubah sampai Anda membuat password baru melalui tautan di atas.
                    </p>
                    <p style="margin:0;font-size:12px;line-height:1.8;color:#94a3b8;">
                        Email ini dikirim otomatis oleh sistem {{ $appName }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
