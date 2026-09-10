<?php
/**
 * Request Batal Reservasi — Paws & Whiskers Care
 * User meminta pembatalan, status diubah ke 'Diubah' agar admin bisa konfirmasi
 */
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../Auth/login.php");
    exit();
}

include 'config.php';

if (!isset($_GET['id'])) {
    header('Location: ../Profil/tampilReservasi.php');
    exit();
}

$id = intval($_GET['id']);
$database->request_batal($id);
header("Location: ../Profil/tampilReservasi.php");
exit();
?>