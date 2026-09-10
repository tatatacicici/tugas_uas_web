<?php
/**
 * Edit Data Reservasi — Paws & Whiskers Care
 */
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../Profil/tampilReservasi.php');
    exit();
}

$id = intval($_POST['id'] ?? 0);
$nama_hewan = htmlspecialchars(trim($_POST['nama_hewan'] ?? ''), ENT_QUOTES, 'UTF-8');
$tanggal_reservasi = $_POST['tanggal_reservasi'] ?? '';
$waktu_reservasi = $_POST['waktu_reservasi'] ?? '';

if ($id <= 0 || empty($nama_hewan) || empty($tanggal_reservasi) || empty($waktu_reservasi)) {
    echo '<script>alert("Data tidak valid."); history.back();</script>';
    exit();
}

$database->edit_reservasi($id, $nama_hewan, $tanggal_reservasi, $waktu_reservasi);

if (isset($_SESSION['roles']) && $_SESSION['roles'] === 'admin') {
    header('Location: ../Admin/data_reservasi.php');
} else {
    header('Location: ../Profil/tampilReservasi.php');
}
exit();
?>
