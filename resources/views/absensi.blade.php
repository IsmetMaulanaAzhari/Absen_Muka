<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

    <nav class="navbar-custom">
        <div class="container">
            <div class="nav-brand">
                <i class="fas fa-user-check"></i>
                <h1>Sistem Absensi Wajah</h1>
            </div>
            <ul class="nav-links">
                <li><a href="{{ url('/') }}"><i class="fas fa-camera"></i> Absensi</a></li>
                <li><a href="#history" class="active"><i class="fas fa-history"></i> Log Absensi</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <div class="card-container" style="max-width: 900px;">
                <div class="card-header-custom">
                    <h2><i class="fas fa-clipboard-list"></i> Riwayat Absensi</h2>
                    <p>Daftar kehadiran karyawan</p>
                </div>

                <div style="padding: 30px;">
                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 mb-4 flex-wrap justify-content-center">
                        <button class="btn-success" onclick="absenMasuk()">
                            <i class="fas fa-sign-in-alt me-2"></i> Absen Masuk
                        </button>
                        <button class="btn-danger" onclick="absenKeluar()">
                            <i class="fas fa-sign-out-alt me-2"></i> Absen Keluar
                        </button>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user me-2"></i>Nama</th>
                                    <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                                    <th><i class="fas fa-clock me-2"></i>Jam Masuk</th>
                                    <th><i class="fas fa-clock me-2"></i>Jam Keluar</th>
                                </tr>
                            </thead>
                            <tbody id="logAbsensi">
                                <!-- Data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Empty State -->
                    <div id="emptyState" class="text-center py-5" style="display: none;">
                        <i class="fas fa-inbox fa-3x mb-3" style="color: #ccc;"></i>
                        <p style="color: #888;">Belum ada data absensi</p>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn-warning" onclick="hapusLog()">
                            <i class="fas fa-trash-alt me-2"></i> Hapus Semua Log
                        </button>
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
</body>
</html>