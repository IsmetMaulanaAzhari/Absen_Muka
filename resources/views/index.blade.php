<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sistem Absensi Wajah</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

  <nav class="navbar-custom">
    <div class="container">
      <div class="nav-brand">
        <i class="fas fa-user-check"></i>
        <h1>Sistem Absensi Wajah</h1>
      </div>
      <ul class="nav-links">
        <li><a href="#absen" class="active"><i class="fas fa-camera"></i> Absensi</a></li>
        <li><a href="{{ url('/absen') }}"><i class="fas fa-history"></i> Log Absensi</a></li>
      </ul>
    </div>
  </nav>

  <main class="main-content">
    <div class="container">
      <div class="card-container">
        <div class="card-header-custom">
          <h2><i class="fas fa-id-card-alt"></i> Absensi Kehadiran</h2>
          <p>Silakan buka kamera dan ambil foto untuk melakukan absensi</p>
        </div>
        
        <div class="camera-section" id="camcam">
          <!-- Open Camera Button -->
          <button class="btn-open-camera" id="open">
            <i class="fas fa-video"></i>
            <span>Buka Kamera</span>
          </button>

          <!-- Camera Container -->
          <div class="camera-wrapper" id="wrap">
            <div class="camera-container" id="cont">
              <div id="vid" class="camera-view">
                <video id="video" autoplay playsinline></video>
              </div>
              <div id="capture" class="camera-view">
                <canvas id="canvas"></canvas>
                <canvas id="blank" style="display: none;"></canvas>
              </div>
              <!-- Overlay untuk tampilan lebih bagus -->
              <div class="camera-overlay">
                <div class="face-guide"></div>
              </div>
            </div>
            
            <!-- Control Buttons - Di luar container kamera -->
            <div class="control-buttons" id="control">
              <button id="snap" class="btn-control btn-capture">
                <div class="btn-icon-wrapper">
                  <i class="fas fa-camera"></i>
                </div>
                <span>Ambil Foto</span>
              </button>
              <button id="close" class="btn-control btn-close-cam">
                <div class="btn-icon-wrapper">
                  <i class="fas fa-times"></i>
                </div>
                <span>Tutup</span>
              </button>
            </div>
          </div>

          <!-- Status Message -->
          <div class="status-message" id="statusMessage">
            <i class="fas fa-info-circle"></i>
            <span>Posisikan wajah Anda di tengah kamera</span>
          </div>

          <!-- Success Modal -->
          <div class="success-modal" id="successModal">
            <div class="modal-content">
              <div class="modal-icon success">
                <i class="fas fa-check-circle"></i>
              </div>
              <h3>Absensi Berhasil!</h3>
              <p>Foto absensi Anda telah tersimpan</p>
              <div class="captured-preview">
                <img id="capturedImage" src="" alt="Captured Photo">
              </div>
              <div class="modal-buttons">
                <button class="btn-modal btn-retake" id="retakeBtn">
                  <i class="fas fa-redo-alt"></i>
                  <span>Foto Ulang</span>
                </button>
                <button class="btn-modal btn-confirm" id="confirmBtn">
                  <i class="fas fa-check"></i>
                  <span>Selesai</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Info Cards -->
        <div class="info-section">
          <div class="info-card">
            <div class="info-icon">
              <i class="fas fa-clock"></i>
            </div>
            <div class="info-text">
              <h4>Waktu Sekarang</h4>
              <p id="currentTime">--:--:--</p>
            </div>
          </div>
          <div class="info-card">
            <div class="info-icon">
              <i class="fas fa-calendar-day"></i>
            </div>
            <div class="info-text">
              <h4>Tanggal</h4>
              <p id="currentDate">-- --- ----</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="footer-custom">
    <div class="container">
      <p>&copy; 2025 Sistem Absensi Wajah | Dibuat dengan <i class="fas fa-heart text-danger"></i> untuk Perusahaan</p>
    </div>
  </footer>

  <script src="js/scripts.js"></script>
  <script src="js/capture.js"></script>
  <script>
    // Update waktu real-time
    function updateDateTime() {
      const now = new Date();
      const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
      const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      
      document.getElementById('currentTime').textContent = now.toLocaleTimeString('id-ID', timeOptions);
      document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', dateOptions);
    }
    
    updateDateTime();
    setInterval(updateDateTime, 1000);
  </script>
</body>

</html>