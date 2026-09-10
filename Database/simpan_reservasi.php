<?php
/**
 * Simpan Reservasi — Paws & Whiskers Care
 * DRY principle: removed duplicated code
 */
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../Profil/reservasi.php');
    exit();
}

// Sanitasi input
$nama = htmlspecialchars(trim($_POST['nama'] ?? ''), ENT_QUOTES, 'UTF-8');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$nomor_telepon = htmlspecialchars(trim($_POST['nomor_telepon'] ?? ''), ENT_QUOTES, 'UTF-8');
$jenis_hewan = intval($_POST['jenis_hewan'] ?? 0);
$nama_hewan = htmlspecialchars(trim($_POST['nama_hewan'] ?? ''), ENT_QUOTES, 'UTF-8');
$dokter = intval($_POST['dokter'] ?? 0);
$tanggal = $_POST['tanggal'] ?? $_POST['tanggal_reservasi'] ?? '';
$waktu_reservasi = $_POST['waktu_reservasi'] ?? '';
$keluhan = htmlspecialchars(trim($_POST['keluhan'] ?? ''), ENT_QUOTES, 'UTF-8');

// Validasi dasar
if (empty($nama) || empty($email) || empty($nomor_telepon) || $jenis_hewan <= 0 ||
    empty($nama_hewan) || $dokter <= 0 || empty($tanggal) || empty($waktu_reservasi) || empty($keluhan)) {
    echo '<script>
        alert("Semua kolom wajib diisi.");
        history.back();
    </script>';
    exit();
}

// Simpan reservasi
$database->simpanReservasi($nama, $email, $nomor_telepon, $jenis_hewan, $nama_hewan, $dokter, $tanggal, $waktu_reservasi, $keluhan);

// Redirect berdasarkan status login
if (isset($_SESSION['email'])) {
    header('Location: ../Profil/pesanProfil.php');
} else {
    header('Location: ../pesan.html');
}
exit();
?>
