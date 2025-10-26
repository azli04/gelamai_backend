<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tanggapan Pengaduan</title>
</head>
<body style="font-family: sans-serif; background: #f9fafb; padding: 20px;">
  <div style="max-width: 600px; margin: auto; background: white; border-radius: 10px; padding: 30px;">
    <h2 style="color: #2563eb;">Tanggapan atas Pengaduan Anda</h2>
    <p>Halo <strong>{{ $pengaduan->nama_lengkap }}</strong>,</p>

    <p>Pengaduan Anda dengan jenis <b>{{ $pengaduan->jenis_pengaduan }}</b> telah ditanggapi oleh tim BBPOM Padang.</p>

    <p><b>Tanggapan:</b></p>
    <blockquote style="border-left: 4px solid #2563eb; margin: 10px 0; padding-left: 10px;">
      {{ $pengaduan->tanggapan }}
    </blockquote>

    <p>Status pengaduan: <strong>{{ ucfirst($pengaduan->status) }}</strong></p>

    <p>Terima kasih atas partisipasi Anda.</p>
    <p>Salam, <br> <b>Tim BBPOM Padang</b></p>
  </div>
</body>
</html>