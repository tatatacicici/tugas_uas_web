<?php
/**
 * Hapus Profil Member — Paws & Whiskers Care
 */
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../Auth/login.php");
    exit();
}

include "config.php";

if (!isset($_GET['email'])) {
    header('Location: ../Profil/profil.php');
    exit();
}

$emailToDelete = $_GET['email'];
$currentEmail = $_SESSION['email'];

// Admin bisa hapus member lain, user hanya bisa hapus diri sendiri
if ($currentEmail === $emailToDelete) {
    $database->hapusMember($emailToDelete);
    session_unset();
    session_destroy();
    header("Location: ../index.html");
    exit();
} elseif (isset($_SESSION['roles']) && $_SESSION['roles'] === 'admin') {
    $database->hapusMember($emailToDelete);
    header('Location: ../Admin/data_member.php');
    exit();
} else {
    header('Location: ../Profil/profil.php');
    exit();
}
?>
