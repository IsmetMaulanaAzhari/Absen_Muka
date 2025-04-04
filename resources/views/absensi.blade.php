<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Absensi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="text-center mt-3">Log Absensi</h2>
    
    <div class="text-center">
        <button class="btn btn-success" onclick="absenMasuk()">Absen Masuk</button>
        <button class="btn btn-danger" onclick="absenKeluar()">Absen Keluar</button>
    </div>

    <h3 class="mt-4">Riwayat Absensi</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
            </tr>
        </thead>
        <tbody id="logAbsensi">
        </tbody>
    </table>
    
    <button class="btn btn-warning" onclick="hapusLog()">Hapus Log</button>
</div>

<script>
function getTimeNow() {
    let now = new Date();
    return now.getHours().toString().padStart(2, '0') + ":" +
           now.getMinutes().toString().padStart(2, '0') + ":" +
           now.getSeconds().toString().padStart(2, '0');
}

function getDateNow() {
    let now = new Date();
    return now.getFullYear() + "-" + 
           (now.getMonth() + 1).toString().padStart(2, '0') + "-" + 
           now.getDate().toString().padStart(2, '0');
}

function getAbsensiData() {
    return JSON.parse(localStorage.getItem("absensi")) || [];
}

function saveAbsensiData(data) {
    localStorage.setItem("absensi", JSON.stringify(data));
}

function absenMasuk() {
    let nama = prompt("Masukkan nama Anda:");
    if (!nama) return alert("Nama tidak boleh kosong!");

    let data = getAbsensiData();
    let today = getDateNow();

    let existing = data.find(d => d.nama === nama && d.tanggal === today);
    if (existing) return alert("Anda sudah absen masuk hari ini!");

    data.push({
        nama: nama,
        tanggal: today,
        jam_masuk: getTimeNow(),
        jam_keluar: null
    });
    saveAbsensiData(data);
    loadAbsensi();
}

function absenKeluar() {
    let nama = prompt("Masukkan nama Anda:");
    if (!nama) return alert("Nama tidak boleh kosong!");

    let data = getAbsensiData();
    let today = getDateNow();

    let existing = data.find(d => d.nama === nama && d.tanggal === today);
    if (!existing) return alert("Anda belum absen masuk hari ini!");

    if (existing.jam_keluar) return alert("Anda sudah absen keluar!");

    existing.jam_keluar = getTimeNow();
    saveAbsensiData(data);
    loadAbsensi();
}

function loadAbsensi() {
    let data = getAbsensiData();
    let logTable = document.getElementById("logAbsensi");
    logTable.innerHTML = "";

    data.forEach(d => {
        logTable.innerHTML += `
            <tr>
                <td>${d.nama}</td>
                <td>${d.tanggal}</td>
                <td>${d.jam_masuk || '-'}</td>
                <td>${d.jam_keluar || '-'}</td>
            </tr>
        `;
    });
}

function hapusLog() {
    if (confirm("Yakin ingin menghapus semua data absensi?")) {
        localStorage.removeItem("absensi");
        loadAbsensi();
    }
}

loadAbsensi();
</script>
</body>
</html>
