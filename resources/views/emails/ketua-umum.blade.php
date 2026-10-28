<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Pemilihan Formatur</title>
  <style>
    body { margin: 0; padding: 32px 16px; background-color: #f4f6f8; font-family: Arial, sans-serif; }
    .wrapper { max-width: 560px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; }
    .header { background-color: #185FA5; padding: 40px 32px; text-align: center; }
    .header-icon { width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,0.2); margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; }
    .header-icon svg { width: 28px; height: 28px; stroke: #fff; fill: none; }
    .header h1 { color: #ffffff; font-size: 20px; font-weight: 600; margin: 0 0 6px; }
    .header p { color: rgba(255,255,255,0.75); font-size: 13px; margin: 0; }
    .body { padding: 32px; }
    .intro { font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px; }
    .result-card { background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 10px; padding: 24px; text-align: center; margin-bottom: 24px; }
    .result-label { font-size: 11px; font-weight: 600; color: #185FA5; text-transform: uppercase; letter-spacing: 0.08em; margin: 0 0 12px; }
    .result-name-row { justify-content: center; gap: 12px; font-size: 22px; font-weight: 600; color: #1e3a5f; }
    .avatar { width: 48px; height: 48px; border-radius: 50%; background: #185FA5; display: flex; align-items: center; justify-content: center; }
    .avatar svg { width: 22px; height: 22px; stroke: #fff; fill: none; }
    .note { display: flex; align-items: flex-start; gap: 10px; background: #f8fafc; border-radius: 8px; padding: 16px 20px; margin-bottom: 28px; }
    .note svg { width: 18px; height: 18px; stroke: #16a34a; fill: none; flex-shrink: 0; margin-top: 2px; }
    .note p { font-size: 14px; color: #64748b; margin: 0; line-height: 1.6; }
    .footer { border-top: 1px solid #e2e8f0; padding-top: 20px; text-align: center; }
    .footer p { font-size: 13px; color: #94a3b8; margin: 0; }
  </style>
</head>
<body>
  <div class="wrapper">

    <div class="header">
      <h1>Hasil Pemilihan Formatur</h1>
      <p>Pengumuman Resmi</p>
    </div>

    <div class="body">
      <p class="intro">
        Dengan bangga kami mengumumkan bahwa proses pemilihan formatur telah selesai dilaksanakan. Berikut adalah hasil yang telah ditetapkan:
      </p>

      <div class="result-card">
        <p class="result-label">Ketua Umum Terpilih</p>
        <div class="result-name-row">
          {{ $kandidat->nama }}
        </div>
      </div>

      <div class="note">
        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <path d="M9 12l2 2 4-4"/>
        </svg>
        <p>Terima kasih telah berpartisipasi dalam proses pemilihan. Kehadiran dan kontribusi Anda sangat berarti bagi organisasi kita.</p>
      </div>

      <div class="footer">
        <p>Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.</p>
      </div>
    </div>

  </div>
</body>
</html>