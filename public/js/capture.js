$(document).ready(function () {
  const video = document.getElementById("video");
  const canvas = document.getElementById("canvas");
  const context = canvas.getContext("2d");

  const notyf = new Notyf({
    duration: 3000,
    position: {
      x: 'center',
      y: 'top',
    }
  });

  $("#open").click(function () {
    navigator.mediaDevices
      .getUserMedia({ video: true })
      .then(function (stream) {
        video.srcObject = stream;
        video.play();
        notyf.success("Kamera berhasil dibuka!");
      })
      .catch(function (err) {
        notyf.error("Gagal membuka kamera: " + err.message);
      });
  });

  function dataURLtoBlob(dataurl) {
    const arr = dataurl.split(',');
    const mime = arr[0].match(/:(.*?);/)[1];
    const bstr = atob(arr[1]);
    let n = bstr.length;
    const u8arr = new Uint8Array(n);
    while (n--) {
      u8arr[n] = bstr.charCodeAt(n);
    }
    return new Blob([u8arr], { type: mime });
  }

  $("#snap").click(function () {
    if (!video.srcObject) {
      notyf.error("Kamera belum dibuka!");
      return;
    }

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    const imageData = canvas.toDataURL("image/png");
    const blob = dataURLtoBlob(imageData);

    const formData = new FormData();
    formData.append("image", blob, "snapshot.png");

    fetch("https://716e-140-213-9-7.ngrok-free.app/recognize", {
      method: "POST",
      body: formData,
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          notyf.success("Berhasil absen sebagai " + data.name);
        } else if (data.status === "unknown") {
          notyf.error("Wajah tidak dikenali!");
        } else {
          notyf.error(data.message || "Gagal memproses data!");
        }
      })
      .catch(err => {
        console.error(err);
        notyf.error("Terjadi kesalahan koneksi ke API!");
      });
  });

  $("#close").click(function () {
    const stream = video.srcObject;
    if (stream) {
      stream.getTracks().forEach((track) => track.stop());
      video.srcObject = null;
      notyf.success("Kamera berhasil ditutup!");
    } else {
      notyf.error("Kamera belum aktif.");
    }
  });
});
