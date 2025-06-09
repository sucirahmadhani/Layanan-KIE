<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Sertifikat</title>

  <style>
    @page {
      size: A4 landscape;
      margin: 0;
    }

    @font-face {
      font-family: 'Poppins';
      src: url("{{ public_path('fonts/Poppins-Regular.ttf') }}") format('truetype');
    }

    @font-face {
      font-family: 'Great Vibes';
      src: url("{{ public_path('fonts/GreatVibes-Regular.ttf') }}") format('truetype');
    }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      text-align: center;
      background-image: url('{{ public_path('img/sertifikat.png') }}');
      background-size: cover;
      background-repeat: no-repeat;
      width: 100%;
      height: 100%;
    }

    .bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    .bg img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .certificate {
      padding-top: 70px;
      margin: 0;
    }

    .logo {
      position: absolute;
      top: 80px;
      left: 100px;
    }

    .logo img {
      height: 80px;
    }

    h1 {
      font-size: 50px;
      margin: 10px 0 0 0;
      color: #1c355e;
      font-weight: bold;
    }

    h2 {
      font-size: 20px;
      margin: 15px 0 0 0;
      color: #1c355e;
      font-weight: 50;
    }

    .name {
      font-family: 'Great Vibes', cursive;
      font-size: 60px;
      color: goldenrod;
      margin-top: 0px;
      margin-bottom: 10px;
    }

    .role {
      font-size: 30px;
      font-weight: bold;
      color: #1c355e;
      margin-bottom: 20px;
      margin-top: 20px;
      font-style: italic;
    }

    .certificate p {
      font-size: 20px;
      margin: 0 auto;
      max-width: 80%;
      line-height: 0.9;
    }

    .signature {
      margin-top: 40px;
      text-align: right;
      padding-right: 80px;
    }

    .signature-text {
      font-size: 16px;
      line-height: 0.9;
    }
    .signature-img {
      height: 100px;
      object-fit: contain;
      margin-bottom: -20px;
    }

  </style>
</head>
<body>
  <div class="certificate">
    <div class="logo">
      <img src="{{ public_path('img/logo.png') }}" alt="Logo BPOM">
    </div>
    <h1>SERTIFIKAT</h1>
    <p>001/KIE/BBPOM/2024</p>
    <h2>Diberikan kepada:</h2>
    <div class="name">{{ $pengguna->nama }}</div>
    <p>Sebagai:</p>
    <div class="role">PESERTA</div>
    <p>
      Pada kegiatan Layanan Komunikasi Informasi dan Edukasi Balai Besar POM di Padang
      dengan topik
        @foreach ($layanan->topik as $topik)
          “{{ $topik->judul }}”@if (!$loop->last), @endif
        @endforeach yang diselenggarakan
      pada {{ \Carbon\Carbon::parse($layanan->tanggal)->translatedFormat('d F Y') }}.
    </p>
    <div class="signature">
       <table style="float: right; text-align: center;">
            <tr>
            <td>
                <img src="{{ public_path('img/sign.jpg') }}" alt="Tanda Tangan Ketua" class="signature-img" />
            </td>
            </tr>
            <tr>
            <td class="signature-text justify-start">
                <strong>DRA. HILDA MURNI, APT., M.M.</strong><br />
                Ketua Panitia Pelaksana Tugas<br />
                Kepala Balai Besar POM di Padang
            </td>
            </tr>
        </table>
    </div>
  </div>
</body>
</html>
