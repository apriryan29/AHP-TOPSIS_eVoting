<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: sans-serif; background:#f7f8fc; padding:24px;">
    <div style="max-width:480px; margin:0 auto; background:#fff; border-radius:12px; padding:32px;">
        <h2 style="color:#1A1A2E;">Halo, {{ $userName }}</h2>
        <p style="color:#444; font-size:14px;">
            Kami menerima permintaan untuk mereset password akun Anda.
            Tap tombol di bawah ini untuk membuka aplikasi dan membuat password baru.
            Link/kode ini berlaku selama <strong>60 menit</strong>.
        </p>
        <p style="text-align:center; margin:32px 0;">
            <a href="{{ $resetUrl }}"
               style="background:#EC900E; color:#fff; padding:14px 28px;
                      border-radius:8px; text-decoration:none; font-weight:bold;">
                Buka App &amp; Reset Password
            </a>
        </p>
        <p style="color:#8A8FAB; font-size:12px;">
            Jika tombol di atas tidak berfungsi (terutama jika dibuka lewat aplikasi
            email web), buka aplikasi secara manual lalu masukkan kode berikut
            di halaman "Reset Password":
        </p>
        <p style="text-align:center; font-size:18px; font-weight:bold; letter-spacing:2px; color:#1A1A2E; background:#F7F8FC; padding:12px; border-radius:8px;">
            {{ $token }}
        </p>
        <p style="color:#8A8FAB; font-size:12px;">
            Email terdaftar: {{ $userName }} — Jika Anda tidak meminta ini, abaikan saja email ini.
        </p>
    </div>
</body>
</html>