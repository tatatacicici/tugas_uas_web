<?php
session_start();
$email = $_SESSION['email'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../Database/config.php";
    $db = new Database();
    $db->edit_reservasi($_POST['id'], $_POST['nama_hewan'], $_POST['tanggal_reservasi'], $_POST['waktu_reservasi']);
    if($email == "admin@root.com"){
        header("Location: ../Admin/data_reservasi.php");
    }else{
        header("Location: ../Profil/tampilReservasi.php");
        exit();
    }
} else {
    if($email == "admin@root.com"){
        header("Location: ../Admin/edit_reservasi_admin.php");
    }else{
        header("Location: ../Profil/edit_reservasi.php");
    }
}
?>
