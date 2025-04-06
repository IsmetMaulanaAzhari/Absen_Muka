<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log Absensi</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>

  <nav>
    <div class="container">
      <h1>Sistem Absensi Wajah</h1>
      <ul>
        <li><a href="{{ route('absen.index') }}" data-toggle="tab">Absensi</a></li>
        <li class="active"><a href="{{ route('absen.log') }}" data-toggle="tab">Log Absensi</a></li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <div class="text-center">
      <button class="btn btn-success" onclick="absenMasuk()">Absen Masuk</button>
      <button class="btn btn-danger" onclick="absenKeluar()">Absen Keluar</button>
    </div>

    <h3 class="mt-4">Riwayat Absensi</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Tanggal</th>
          <th>Jam Masuk</th>
          <th>Jam Keluar</th>
        </tr>
      </thead>
      <tbody id="logAbsensi">
      </tbody>
    </table>

    {{-- <button class="btn btn-warning" onclick="hapusLog()">Hapus Log</button> --}}
  </div>
  <footer>
    <div class="container">
      <p>&copy; 2025 Web Absensi | Dibuat dengan ❤️ untuk Perusahaan</p>
    </div>
  </footer>
  <script src="js/scripts.js"></script>
</body>

</html>
