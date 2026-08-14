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
            <div class="card-container" style="max-width: 1100px;">
                <div class="card-header-custom">
                    <h2><i class="fas fa-clipboard-list"></i> Riwayat Absensi Wajah</h2>
                    <p>Daftar foto absensi yang sudah tersimpan di database</p>
                </div>

                <div style="padding: 30px;">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">#</th>
                                    <th style="width: 120px;">Foto</th>
                                    <th>Path Database</th>
                                    <th style="width: 220px;">Waktu Tersimpan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($absens as $absen)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img
                                                src="{{ asset('storage/' . $absen->image) }}"
                                                alt="Foto absensi {{ $loop->iteration }}"
                                                style="width: 72px; height: 72px; object-fit: cover; border-radius: 16px; border: 2px solid #e9e6ff;"
                                            >
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $absen->image }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $absen->created_at?->format('d F Y H:i:s') }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x mb-3" style="color: #ccc;"></i>
                                                <p class="mb-0" style="color: #888;">Belum ada data absensi wajah</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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

</body>
</html>