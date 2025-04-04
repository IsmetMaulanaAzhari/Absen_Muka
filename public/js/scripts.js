// File: tes.js
$(document).ready(function () {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    let streamData;

    $('#control').hide();

    // Sesuaikan ukuran kontainer saat metadata video dimuat
    $('#video').on('loadedmetadata', function () {
        console.log('Video Width:', video.videoWidth, 'Video Height:', video.videoHeight);
        const videoHeight = $(this).height();
        const videoWidth = $(this).width();

        $('#cont').css({
            height: videoHeight,
            width: videoWidth
        });

        $('#control').css({
            height: videoHeight * 0.1,
            top: videoHeight * 0.9,
            width: videoWidth
        }).show();
    });

    // Fungsi untuk membuka kamera
    function openCam() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(streamWebCam)
                .catch(handleError);
        } else {
            alert('getUserMedia tidak didukung oleh browser ini.');
        }
    }

    // Fungsi untuk menutup kamera
    function closeCam() {
        video.pause();
        if (streamData) {
            streamData.getTracks().forEach(track => track.stop());
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
    $('#open').click(openCam);
    $('#close').click(closeCam);
    $('#snap').click(function () {
        canvas.width = video.clientWidth;
        canvas.height = video.clientHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        $('#vid').css('z-index', '20');
        $('#capture').css('z-index', '30');
    });

    $('#retake').click(function () {
        $('#vid').css('z-index', '30');
        $('#capture').css('z-index', '20');
    });
});
