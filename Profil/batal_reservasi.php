<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
    header("Location: Auth/login.php");
    exit();
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];

include "../Database/config.php";
$db = new Database();
if(isset($_GET['id'])){
    $id_reservasi = $_GET['id'];
    $data_reservasi = $db->tampil_reservasi_id($id_reservasi);
    foreach ($data_reservasi as  $index){
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi - Paws & Whiskers Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../Assets/Style/styleJanji.css" rel="stylesheet">
    <!--Fonts    -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&family=Oxygen:wght@300;400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300;400;500;600;700&display=swap');
    </style>
</head>

<body>
<?php include "dashboard.php"; ?>

<div class="row">
    <div class="col my-auto kontainer">
        <h1 class="text-center mt-4 sub-judul">Hapus Reservasi</h1>
        <p class=" text-center isi">Anda bisa membatalkan jadwal di Paws & Whisker Care. Perubahan Jadwal hanya bisa jika jadwal masih satu minggu kedepan</p>
    </div>

</div>
<!-- Reservasi Form -->
<div class="container mt-5 kontainer">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #FFD700"> Hapus Reservasi</div>
                <div class="card-body">
                    <form class="form-reservasi" action="../Database/data_batal_reservasi.php" method="get">
                        <input type="hidden" name="id" value="<?php echo  $index['id']; ?>">
                        <!--Nama Klien-->
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo  $index['nama']; ?>" readonly>
                        </div>
                        <!--Email-->
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo  $index['email']; ?>" readonly>
                        </div>
                        <!--Nomor Telepon-->
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telepon:</label>
                            <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?php echo  $index['nomor_telepon']; ?>" readonly>
                        </div>
                        <!--Nama Hewan-->
                        <div class="form-group">
                            <label for="email">Nama Peliharaan:</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $index['nama_hewan']; ?>" readonly>
                        </div>
                        <!-- Jenis Hewan -->
                        <div class="form-group">
                            <label for="jenis_hewan">Jenis Peliharaan:</label>
                            <input type="text" name="jenis_hewan" class="form-control" id="jenis_hewan" value="<?php echo $index['nama_binatang'];?>"readonly>
                        </div>
                        <!-- Dokter -->
                        <div class="form-group">
                            <label for="dokter">Jenis Peliharaan:</label>
                            <input type="text" name="dokter" class="form-control" id="dokter" value="<?php echo $index['nama_dokter'];?>"readonly>
                        </div>
                        <!-- Tanggal -->
                        <div class="form-group">
                            <label for="tanggal_reservasi">Tanggal Reservasi:</label>
                            <input type="date" class="form-control" id="tanggal_reservasi" name="tanggal_reservasi" value="<?php echo $index['tanggal_reservasi'];?>"readonly>
                        </div>
                        <!--Waktu Reservasi-->
                        <div class="form-group">
                            <label for="waktu_reservasi">Waktu Reservasi:</label>
                            <input type="text" class="form-control" id="waktu_reservasi" name="waktu_reservasi" value="<?php echo $index['waktu_reservasi']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="keluhan">Keluhan:</label>
                            <input class="form-control" name="keluhan" id="keluhan" value="<?php echo $index['keluhan']; ?>" readonly>
                        </div>
                        <button type="submit" onclick="reconfirm()"  class="btn  btn-hapus float-right">Hapus Reservasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    function reconfirm(){
        return confirm("Jika sudah terbatalkan tidak bisa kembali? Yakin Membatalkan")
    }
</script>
</body>

</html>
<?php
    }
}else{
    header('Loaction: tampilReservasi.php');
}
    ?>