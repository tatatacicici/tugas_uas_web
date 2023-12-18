<?php
    session_start();
    include 'config.php';
    $email_admin = "admin@root.com";
    $email = $_SESSION['email'];
    $email_user = $_POST['email'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];

    if($email == $email_admin){
        $database->editMember($email_user, $nama, $jenis_kelamin, $nomor_telepon, $alamat);
        header('Location: ../Admin/data_member.php');
    }else{
        $database->editMember($email, $nama, $jenis_kelamin, $nomor_telepon, $alamat);
        header('Location: ../Profil/profil.php');

    }
?>