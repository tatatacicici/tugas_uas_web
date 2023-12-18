<?php
    session_start();
    include "config.php";
    $id = $_POST['id'];
    $database->hapus_reservasi_id($id);
    header('Location: ../Admin/data_reservasi.php');
?>