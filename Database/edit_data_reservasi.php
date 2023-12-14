<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../Database/config.php";
    $db = new Database();

    // Assuming $_POST['id'], $_POST['nama_hewan'], $_POST['jenis_hewan'] are arrays
    $ids = $_POST['id'];
    $nama_hewan_values = $_POST['nama_hewan'];
    $jenis_hewan_values = $_POST['jenis_hewan'];

    // Additional processing for other fields like tanggal_reservasi_baru, waktu_reservasi_baru, etc.
    $tanggal_reservasi_baru = $_POST['tanggal_reservasi_baru'];
    $waktu_reservasi_baru = $_POST['waktu_reservasi_baru'];

    // Loop through the arrays and update the data
    foreach ($ids as $i => $id) {
        $nama_hewan = $nama_hewan_values[$i];
        $jenis_hewan = $jenis_hewan_values[$i];

        // Update the database with the new values
        $db->editReservasi($id, $nama_hewan, $jenis_hewan, $tanggal_reservasi_baru, $waktu_reservasi_baru);
    }

    // Redirect after updating
    header("Location: ../Profil/tampilReservasi.php");
    exit();
} else {
    // Redirect if the request method is not POST
    header("Location: ../Profil/edit_reservasi.php");
    exit();
}
?>
