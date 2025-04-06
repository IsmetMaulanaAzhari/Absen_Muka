$(document).ready(function () {
  const video = document.getElementById("video");
  const canvas = document.getElementById("canvas");
  const context = canvas.getContext("2d");

  $("#open").click(function () {
    navigator.mediaDevices
      .getUserMedia({ video: true })
      .then(function (stream) {
        video.srcObject = stream;
        video.play();
      })
      .catch(function (err) {
        alert("Gagal membuka kamera: " + err);
      });
  });

  $("#snap").click(function () {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    const image = canvas.toDataURL("image/png");

    $.ajax({
      url: "/absen/store",
      method: "POST",
      data: {
        image: image,
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (response) {
        alert("Berhasil absen! Gambar: " + response.image);
      },
      error: function (xhr) {
        alert("Gagal menyimpan absen!");
      },
    });
  });

  $("#close").click(function () {
    const stream = video.srcObject;
    if (stream) {
      stream.getTracks().forEach((track) => track.stop());
    }
    video.srcObject = null;
  });
});
