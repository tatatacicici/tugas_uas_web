<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: Auth/login.php");
    exit();
}

$email = $_SESSION['email'];

if (isset($_GET['email'])) {
    $emailToDelete = $_GET['email'];

    // Pastikan email yang akan dihapus sesuai dengan email yang sedang login
    if ($email == $emailToDelete) {
        include "../Database/config.php";
        $db = new Database();

        // Panggil fungsi hapusMember dengan email yang sesuai
        $db->hapusMember($email);

        // Redirect ke halaman lain atau beri pesan sukses
        header("Location: ../index.html");
        exit();
    } else {
        // Email tidak sesuai, mungkin ada upaya manipulasi
        echo "Access denied!";
    }
} else {
    // Parameter email tidak ditemukan
    echo "Invalid request!";
}
?>
