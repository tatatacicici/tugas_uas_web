
<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
    header("Location: ../Auth/login.php");
    exit();
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];
include "../Database/config.php";
$db = new Database();
$tampilData = $db->tampil_reservasi_admin();
foreach ($db->login($email, $password) as $index) {
    $roles = $index['roles'];
    if($roles == 'admin'){?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservasi - Paws & Whiskers Care</title>
    <link href="../Assets/Style/styleJanji.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <!-- Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&family=Oxygen:wght@300;400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300;400;500;600;700&display=swap');
    </style>
</head>

<body>
<?php include "dashboard_admin.php"; ?>
<section id="reservasi">
<div class="row">
    <div class="col my-auto kontainer">
        <h1 class="text-center mt-4 sub-judul">Daftar Reservasi</h1>
    </div>
</div>
<div class="mt-5 container">
    <?php if (!empty($tampilData)) {?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Email</th>
            <th scope="col">Nomor Telepon</th>
            <th scope="col">Nama Hewan</th>
            <th scope="col">Jenis Hewan</th>
            <th scope="col">Tanggal Reservasi</th>
            <th scope="col">Waktu Reservasi</th>
            <th scope="col">Dokter</th>
            <th scope="col">Keluhan</th>
            <th scope="col">Status</th>
            <th scope="col">Ubah Reservasi</th>
            <th scope="col">Batalkan Reservasi</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1;
        foreach ($tampilData as $reservasi) { ?>
        <tr>
            <th scope="row"><?php echo $no++?></th>
            <td><?php echo $reservasi['nama']; ?></td>
            <td><?php echo $reservasi['email']; ?></td>
            <td><?php echo $reservasi['nomor_telepon']; ?></td>
            <td><?php echo $reservasi['nama_hewan']; ?></td>
            <td><?php echo $reservasi['nama_binatang']; ?></td>
            <td><?php echo $reservasi['tanggal_reservasi']; ?></td>
            <td><?php echo $reservasi['waktu_reservasi']; ?></td>
            <td><?php echo $reservasi['nama_dokter']; ?></td>
            <td><?php echo $reservasi['keluhan']; ?></td>
            <td><?php echo $reservasi['status']; ?></td>
            <?php
                if($reservasi['status'] != 'Dibatalkan'){
            ?>
            <td><a href="edit_reservasi_admin.php?id=<?php echo $reservasi['id']; ?>"><button class="btn btn-edit">Edit Reservasi</button></a></td>
            <td><a href="hapus_reservasi_admin.php?id=<?php echo $reservasi['id']; ?>"><button class="btn btn-hapus">Batal Reservasi</button></a></td>
            <?php
                }
                else{
                   echo '<td>Sudah Dibatalkan</td>';
                    echo '<td>Sudah Dibatalkan</td>';
                }
            ?>
        </tr>
        </tbody>
        <?php } ?>
        <?php } else { ?>
            <p>Tidak ada janji.</p>
        <?php } ?>
    </table>
</div>
</section>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    var aktif = document.getElementById("reservasi");
    aktif.classList.add("active")
</script>
</body>

</html>
    <?php
}else{
    echo '<script>
      alert("Akses Ditolak. Silahkan masukkan email dan password anda")
      document.location="../index.html"</script>';
}
}
