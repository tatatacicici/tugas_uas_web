<?php
session_start();
$email = $_SESSION['email'];
include 'config.php';


if(isset($_GET['id'])){
    $id = $_GET['id'];
    $database->batal_reservasi($id);
    header("Location: ../Admin/data_reservasi.php");
}else{
    header("../Admin/data_konfirmasi_hapus.php");
}
?>