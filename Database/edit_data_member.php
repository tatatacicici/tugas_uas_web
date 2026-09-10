<?php
/**
 * Edit Data Member — Paws & Whiskers Care
 */
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../Profil/profil.php');
    exit();
}

$email = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8');
$nama = htmlspecialchars(trim($_POST['nama'] ?? ''), ENT_QUOTES, 'UTF-8');
$jenis_kelamin = htmlspecialchars(trim($_POST['jenis_kelamin'] ?? ''), ENT_QUOTES, 'UTF-8');
$nomor_telepon = htmlspecialchars(trim($_POST['nomor_telepon'] ?? ''), ENT_QUOTES, 'UTF-8');
$alamat = htmlspecialchars(trim($_POST['alamat'] ?? ''), ENT_QUOTES, 'UTF-8');

if (empty($email) || empty($nama)) {
    echo '<script>alert("Data tidak valid."); history.back();</script>';
    exit();
}

$database->editMember($email, $nama, $jenis_kelamin, $nomor_telepon, $alamat);

// Redirect berdasarkan role
if (isset($_SESSION['roles']) && $_SESSION['roles'] === 'admin') {
    header('Location: ../Admin/data_member.php');
} else {
    header('Location: ../Profil/profil.php');
}
exit();
?>