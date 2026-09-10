<?php
/**
 * Simpan Data Member — Paws & Whiskers Care
 * Secure registration with password hashing and validation
 */
include('config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../Auth/signIn.php');
    exit();
}

// Sanitasi input
$nama = htmlspecialchars(trim($_POST['nama'] ?? ''), ENT_QUOTES, 'UTF-8');
$jenis_kelamin = htmlspecialchars(trim($_POST['jenis_kelamin'] ?? ''), ENT_QUOTES, 'UTF-8');
$nomor_telepon = htmlspecialchars(trim($_POST['nomor_telepon'] ?? ''), ENT_QUOTES, 'UTF-8');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$alamat = htmlspecialchars(trim($_POST['alamat'] ?? ''), ENT_QUOTES, 'UTF-8');
$password = $_POST['password'] ?? '';

// Validasi
if (empty($nama) || empty($email) || empty($password) || strlen($password) < 6) {
    echo '<script>
        alert("Data tidak valid. Pastikan semua kolom terisi dan kata sandi minimal 6 karakter.");
        history.back();
    </script>';
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<script>
        alert("Format email tidak valid.");
        history.back();
    </script>';
    exit();
}

// Cek email sudah terdaftar
if ($database->emailExists($email)) {
    echo '<script>
        alert("Email sudah terdaftar. Silakan gunakan email lain atau masuk.");
        history.back();
    </script>';
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Simpan ke database
$database->simpanMember($nama, $jenis_kelamin, $nomor_telepon, $email, $alamat, $hashed_password);

header('Location: ../Auth/login.php');
exit();
?>