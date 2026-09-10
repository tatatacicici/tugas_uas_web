<?php
/**
 * Admin: Hapus/Batalkan Reservasi — Paws & Whiskers Care
 */
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['roles']) || $_SESSION['roles'] !== 'admin') {
    header("Location: ../Auth/login.php");
    exit();
}

include "config.php";

if (!isset($_GET['id'])) {
    header('Location: ../Admin/data_reservasi.php');
    exit();
}

$id = intval($_GET['id']);
$database->batal_reservasi($id);
header('Location: ../Admin/data_reservasi.php');
exit();
?>