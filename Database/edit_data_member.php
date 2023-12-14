<?php
    session_start();
    include 'config.php';
    $email = $_SESSION['email'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];

    $database->editMember($email, $nama, $jenis_kelamin, $nomor_telepon, $alamat);

    header('Location: ../Profil/profil.php');
?>