<?php
session_start();

include('config.php');

// Check if the referrer is the dashboard page (assuming the dashboard URL)
$referrer = $_SERVER['HTTP_REFERER'];
$dashboardUrl = 'http://localhost/dokter_hewan/Profil/reservasi_Profil.php'; // Change this to the actual URL of your dashboard

if (strpos($referrer, $dashboardUrl) !== false && isset($_SESSION['email'])) {

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $jenis_hewan = $_POST['jenis_hewan'];
    $nama_hewan = $_POST['nama_hewan'];
    $dokter = $_POST['dokter'];
    $tanggal = $_POST['tanggal'];
    $waktu_reservasi = $_POST['waktu_reservasi'];
    $keluhan = $_POST['keluhan'];

    $database->simpanReservasi($nama, $email, $nomor_telepon, $jenis_hewan, $nama_hewan, $dokter, $tanggal, $waktu_reservasi, $keluhan);

    header('Location: ../Profil/pesanProfil.php');
} else {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $jenis_hewan = $_POST['jenis_hewan'];
    $nama_hewan = $_POST['nama_hewan'];
    $dokter = $_POST['dokter'];
    $tanggal = $_POST['tanggal'];
    $waktu_reservasi = $_POST['waktu_reservasi'];
    $keluhan = $_POST['keluhan'];

    $database->simpanReservasi($nama, $email, $nomor_telepon, $jenis_hewan, $nama_hewan, $dokter, $tanggal, $waktu_reservasi, $keluhan);

    header('Location: ../pesan.html');
}

?>
