<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Token Pemilihan</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background-color: #f5f5f5; padding: 20px; margin: 0;">

    <div style="
        max-width: 600px;
        margin: auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    ">

        <h2 style="color: #EC900E; text-align: center; margin-top: 0;">
            Token Pemilihan
        </h2>

        <p style="color: #444;">Halo,</p>

        <p style="color: #444;">
            Berikut adalah token yang dapat digunakan untuk melakukan pemilihan:
        </p>

        {{-- Kotak token: klik sekali untuk memilih semua --}}
        <div style="
            background-color: #FFF8E8;
            border: 2px dashed #EC900E;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        ">
            <p style="margin: 0 0 8px 0; font-size: 13px; color: #888; text-transform: uppercase; letter-spacing: 1px;">
                Token Anda
            </p>

            {{-- 
                user-select: all  → sekali klik, seluruh teks langsung terpilih
                cursor: text      → menunjukkan teks ini bisa dipilih
            --}}
            <div style="
                font-size: 32px;
                font-weight: bold;
                letter-spacing: 8px;
                color: #333;
                user-select: all;
                -webkit-user-select: all;
                -moz-user-select: all;
                cursor: text;
                padding: 10px;
                background: #fff;
                border-radius: 6px;
                border: 1px solid #f0d9a0;
                display: inline-block;
                min-width: 80%;
                word-break: break-all;
            ">{{ $token }}</div>
        </div>

        <p style="color: #444;">
            Silakan salin token di atas dan masukkan ke aplikasi untuk melanjutkan proses pemilihan.
        </p>

        <p style="color: #c0392b; font-weight: bold;">
            ⚠️ Jangan membagikan token ini kepada siapa pun.
        </p>

        <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">

        <p style="font-size: 12px; color: #777; margin-bottom: 0;">
            Email ini dikirim secara otomatis oleh sistem VotingMU.
        </p>

    </div>

</body>
</html>