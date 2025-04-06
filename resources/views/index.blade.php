<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Absen Wajah</title>
</head>

<body>
  <video id="video" autoplay style="width: 480px; height: auto; border-radius: 8px;"></video>
  <canvas id="canvas" style="display: none;"></canvas>
  <button onclick="capture()">Ambil Foto</button>

  <script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    navigator.mediaDevices.getUserMedia({
        video: true
      })
      .then(stream => {
        video.srcObject = stream;
      })
      .catch(error => {
        alert('Gagal mengakses kamera: ' + error);
      });

    function capture() {
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      context.drawImage(video, 0, 0, canvas.width, canvas.height);

      const image = canvas.toDataURL('image/png');

      fetch("{{ route('absen.store') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content'),
          },
          body: JSON.stringify({
            image
          })
        })
        .then(res => res.json())
        .then(data => {
          alert(data.message || 'Berhasil absen!');
        })
        .catch(err => {
          alert('Gagal mengirim absen: ' + err);
        });
    }
  </script>
</body>

</html>
