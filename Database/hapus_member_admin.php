<?php
session_start();
$email = $_SESSION['email'];
include 'config.php';


if(isset($_GET['email'])){
    $id = $_GET['id'];
    $database->request_batal($id);
    header("Location: ../Profil/tampilReservasi.php");
}else{
    header("../Profil/hapus_data_reservasi_admin.php");
}
?>