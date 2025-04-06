<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Sistem Absensi</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

  <div class="container">
    <h2 class="text-center">Sistem Absensi Wajah</h2>

    <!-- Navigasi -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#absen" data-toggle="tab">Absensi</a></li>
      <li><a href="#history" data-toggle="tab">Log Absensi</a></li>
    </ul>

    <div class="tab-content">
      <!-- Tab Absensi -->
      <div id="absen" class="tab-pane fade in active">
        <div class="container-fluid" id="camcam">
          <a class="btn btn-block btn-primary text-white" id="open">Open Cam</a>
          <div class="row">
            <div class="col-md-offset-1 col-md-10">
              <div id="wrap">
                <div id="cont">
                  <div id="vid" class="son">
                    <video id="video"></video>
                  </div>
                  <div id="capture" class="son">
                    <canvas id="canvas"></canvas>
                    <canvas id="blank" style="display: none;"></canvas>
                  </div>
                  <div id="control">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-4">
                          <a id="retake" class="btn btn-block m-1 hov">
                            <i class="fas fa-sync-alt"></i> Ulangi
                          </a>
                        </div>
                        <div class="col-md-4">
                          <a id="snap" class="btn btn-block m-1 hov">
                            <i class="fas fa-camera"></i> Ambil Foto
                          </a>
                        </div>
                        <div class="col-md-4">
                          <a id="close" class="btn btn-block m-1 hov">
                            <i class="fas fa-times"></i> Tutup
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="history" class="tab-pane fade">
        <h3>Riwayat Absensi</h3>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Tanggal</th>
              <th>Jam Masuk</th>
              <th>Jam Keluar</th>
            </tr>
          </thead>
          <tbody id="absensiList">
            <!-- Data absensi akan dimuat di sini -->
          </tbody>
        </table>
        <button class="btn btn-success" id="exportData">Export Laporan</button>
      </div>
    </div>
  </div>
  <footer>
    <div class="container">
      <p>&copy; 2025 Web Absensi | Dibuat dengan ❤️ untuk Perusahaan</p>
    </div>
  </footer>
  <script src="js/scripts.js"></script>
</body>

</html>
