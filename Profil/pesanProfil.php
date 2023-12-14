<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
    header("Location: Auth/login.php");
    exit();
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];

include "../Database/config.php";
$db = new Database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="Assets/Style/stylePesan.css" rel="stylesheet">
    <!--Fonts    -->
    <style>

    </style>
</head>

<body>
<?php include "dashboard.php"; ?>

<div class="container kontainer-pesan kontainer">
    <div class="row justify-content-center custom-card">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Paws & Whisker Care</div>
                <div class="card-body">
                    <h1 class="card-title text-center">Terimakasih telah mempercayai kami,</h1>
                    <p class="card-text">
                        Kami ingin memberitahu Anda bahwa reservasi temu dokter di Klinik Paws & Whisker Care telah
                        berhasil diproses. Kami sangat menghargai kepercayaan Anda untuk memberikan perawatan terbaik
                        bagi hewan kesayangan Anda.
                    </p>
                    <p class="card-text">
                        Dalam beberapa waktu ke depan, tim medis kami akan menghubungi Anda untuk mengkonfirmasi
                        jadwal temu dokter dan memberikan informasi lebih lanjut mengenai persiapan yang perlu
                        dilakukan sebelum kedatangan Anda ke klinik.
                    </p>
                    <p class="card-text">
                        Jika Anda memiliki pertanyaan atau kebutuhan khusus sehubungan dengan reservasi Anda, jangan
                        ragu untuk menghubungi layanan pelanggan kami. Kami siap membantu dan menjamin bahwa kunjungan
                        Anda akan berjalan dengan nyaman.
                    </p>
                    <p class="card-text">
                        Terima kasih atas kepercayaan dan kerjasama Anda. Kami berharap dapat memberikan pelayanan yang
                        berkualitas untuk kesehatan dan kesejahteraan hewan kesayangan Anda.
                    </p>
                    <p class="card-text">
                        Salam hangat,
                        Tim Paws & Whisker Care
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Us END -->
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- Script JS -->
</body>

</html>