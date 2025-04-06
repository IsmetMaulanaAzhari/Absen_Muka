// File: tes.js
$(document).ready(function () {
  const video = document.getElementById("video");
  const canvas = document.getElementById("canvas");
  const context = canvas.getContext("2d");
  let streamData;

  $("#control").hide();

  // Sesuaikan ukuran kontainer saat metadata video dimuat
  $("#video").on("loadedmetadata", function () {
    const videoHeight = $(this).height();
    const videoWidth = $(this).width();

    $("#cont").css({
      height: videoHeight,
      width: videoWidth,
    });

    $("#control")
      .css({
        height: videoHeight * 0.1,
        top: videoHeight * 0.9,
        width: videoWidth,
      })
      .show();
  });

  // Fungsi untuk membuka kamera
  function openCam() {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      navigator.mediaDevices
        .getUserMedia({ video: true })
        .then(streamWebCam)
        .catch(handleError);
    } else {
      alert("getUserMedia tidak didukung oleh browser ini.");
    }
  }

  // Fungsi untuk menutup kamera
  function closeCam() {
    video.pause();
    if (streamData) {
      streamData.getTracks().forEach((track) => track.stop());
    }
    video.srcObject = null;
  }

  // Fungsi untuk mengatur stream video ke elemen <video>
  function streamWebCam(stream) {
    video.srcObject = stream;
    video.play();
    streamData = stream;
  }

  // Fungsi untuk menangani error
  function handleError(error) {
    alert(error.name);
  }

  // Event handler untuk tombol-tombol kontrol
  $("#open").click(openCam);
  $("#close").click(closeCam);

  $("#snap").click(function () {
    canvas.width = video.clientWidth;
    canvas.height = video.clientHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    $("#vid").css("z-index", "20");
    $("#capture").css("z-index", "30");
  });

  $("#retake").click(function () {
    $("#vid").css("z-index", "30");
    $("#capture").css("z-index", "20");
  });
});

document.getElementById("open").addEventListener("click", function () {
  let loadingIndicator = document.getElementById("loadingIndicator");
  let cameraContainer = document.getElementById("cont");

  // Tampilkan loading
  loadingIndicator.style.display = "block";

  setTimeout(() => {
    // Hilangkan loading setelah 2 detik
    loadingIndicator.style.display = "none";
    cameraContainer.style.opacity = "1";
  }, 2000);
});

function getTimeNow() {
  let now = new Date();
  return (
    now.getHours().toString().padStart(2, "0") +
    ":" +
    now.getMinutes().toString().padStart(2, "0") +
    ":" +
    now.getSeconds().toString().padStart(2, "0")
  );
}

function getDateNow() {
  let now = new Date();
  return (
    now.getFullYear() +
    "-" +
    (now.getMonth() + 1).toString().padStart(2, "0") +
    "-" +
    now.getDate().toString().padStart(2, "0")
  );
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

  let existing = data.find((d) => d.nama === nama && d.tanggal === today);
  if (existing) return alert("Anda sudah absen masuk hari ini!");

  data.push({
    nama: nama,
    tanggal: today,
    jam_masuk: getTimeNow(),
    jam_keluar: null,
  });
  saveAbsensiData(data);
  loadAbsensi();
}

function absenKeluar() {
  let nama = prompt("Masukkan nama Anda:");
  if (!nama) return alert("Nama tidak boleh kosong!");

  let data = getAbsensiData();
  let today = getDateNow();

  let existing = data.find((d) => d.nama === nama && d.tanggal === today);
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

  data.forEach((d) => {
    logTable.innerHTML += `
            <tr>
                <td>${d.nama}</td>
                <td>${d.tanggal}</td>
                <td>${d.jam_masuk || "-"}</td>
                <td>${d.jam_keluar || "-"}</td>
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
