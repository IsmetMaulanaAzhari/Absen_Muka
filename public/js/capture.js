$(document).ready(function () {
  const video = document.getElementById("video");
  const canvas = document.getElementById("canvas");
  const context = canvas.getContext("2d");
  const wrap = document.getElementById("wrap");
  const openBtn = document.getElementById("open");
  const statusMsg = document.getElementById("statusMessage");
  const successModal = document.getElementById("successModal");
  const capturedImage = document.getElementById("capturedImage");

  let currentImageData = null;

  // Open Camera
  $("#open").click(function (e) {
    e.preventDefault();
    console.log('[capture.js] Open camera button clicked');

    // Clear previous status
    resetStatusMessage();

    navigator.mediaDevices
      .getUserMedia({ video: { facingMode: "user", width: 640, height: 480 } })
      .then(function (stream) {
        console.log('[capture.js] getUserMedia succeeded', stream);
        try {
          video.srcObject = stream;
          // Ensure play is called after metadata is loaded
          video.onloadedmetadata = function () {
            video.play().catch(function(playErr){
              console.error('[capture.js] video.play() failed', playErr);
            });
          };
        } catch (err) {
          console.error('[capture.js] error assigning stream to video', err);
        }

        // Show camera wrapper and hide open button
        $(wrap).addClass("active");
        $(openBtn).hide();
        $(statusMsg).addClass("show");
        resetStatusMessage();
      })
      .catch(function (err) {
        console.error('[capture.js] Gagal membuka kamera:', err);
        $(statusMsg).html('<i class="fas fa-exclamation-circle" style="color: #eb3349;"></i><span>Gagal membuka kamera: ' + (err.message || err.name || err) + '</span>');
        alert('Gagal membuka kamera: ' + (err.message || err.name || err));
      });
  });

  // Capture Photo
  $("#snap").click(function () {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    currentImageData = canvas.toDataURL("image/png");

    // Show loading state
    const snapBtn = $("#snap");
    const originalHtml = snapBtn.html();
    snapBtn.html('<div class="btn-icon-wrapper"><i class="fas fa-spinner fa-spin"></i></div><span>Memproses...</span>');
    snapBtn.prop("disabled", true);

    $.ajax({
      url: "/absen/store",
      method: "POST",
      data: {
        image: currentImageData,
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (response) {
        snapBtn.html(originalHtml);
        snapBtn.prop("disabled", false);
        
        // Show captured image in modal
        $(capturedImage).attr("src", currentImageData);
        
        // Show success modal
        $(successModal).addClass("show");
        $(statusMsg).removeClass("show");
      },
      error: function (xhr) {
        $(statusMsg).html('<i class="fas fa-exclamation-circle" style="color: #eb3349;"></i><span>Gagal menyimpan absen. Coba lagi!</span>');
        snapBtn.html(originalHtml);
        snapBtn.prop("disabled", false);
      },
    });
  });

  // Retake Photo - Foto ulang
  $("#retakeBtn").click(function () {
    $(successModal).removeClass("show");
    $(statusMsg).addClass("show");
    resetStatusMessage();
    // Kamera tetap aktif, user bisa langsung foto ulang
  });

  // Confirm and Close - Selesai
  $("#confirmBtn").click(function () {
    $(successModal).removeClass("show");
    closeCamera();
    
    // Show success toast
    showToast("Absensi berhasil disimpan!", "success");
  });

  // Close Camera
  $("#close").click(function () {
    closeCamera();
  });

  function closeCamera() {
    const stream = video.srcObject;
    if (stream) {
      stream.getTracks().forEach((track) => track.stop());
    }
    video.srcObject = null;
    currentImageData = null;
    
    // Hide camera wrapper and show open button
    $(wrap).removeClass("active");
    $(openBtn).show();
    $(statusMsg).removeClass("show");
    $(successModal).removeClass("show");
    resetStatusMessage();
  }

  function resetStatusMessage() {
    $(statusMsg).html('<i class="fas fa-info-circle"></i><span>Posisikan wajah Anda di tengah kamera</span>');
  }

  function showToast(message, type) {
    // Create toast element
    const toast = $('<div class="toast-notification ' + type + '">' +
      '<i class="fas ' + (type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle') + '"></i>' +
      '<span>' + message + '</span>' +
    '</div>');
    
    $('body').append(toast);
    
    // Animate in
    setTimeout(() => toast.addClass('show'), 10);
    
    // Remove after delay
    setTimeout(() => {
      toast.removeClass('show');
      setTimeout(() => toast.remove(), 300);
    }, 3000);
  }
});
