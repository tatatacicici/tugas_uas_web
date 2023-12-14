<?php
    include('config.php');
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];

    $database->simpanMember($nama, $jenis_kelamin, $nomor_telepon, $email, $alamat, $password);
    header('Location: ../Auth/login.php');
?>