<?php
session_start();
include "../Database/config.php";
$db = new Database();
if (!isset($_SESSION['email'])) {
    header("Location: Auth/login.php");
    exit();
}

$email = $_SESSION['email'];
if (isset($_GET['email'])) {
    $emailToDelete = $_GET['email'];
    if ($email == $emailToDelete) {
        $db->hapusMember($email);
        header("Location: ../index.html");
        exit();
    } else {
      $db->hapusMember($emailToDelete);
      header('Location: ../Admin/data_member.php');
    }
} else {
    // Parameter email tidak ditemukan
    header('Location: ../Profil/profil.php');
}
?>
