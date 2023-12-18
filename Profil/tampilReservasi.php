
<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
    header("Location: ../Auth/login.php");
    exit();
}

$email = $_SESSION['email'];

include "../Database/config.php";
$db = new Database();
$tampilJanji = $db->tampil_reservasi_email($email);

?>

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
<?php include "dashboard.php"; ?>

<div class="row">
    <div class="col my-auto kontainer">
        <h1 class="text-center mt-4 sub-judul">Lihat Reservasi</h1>
        <p class="text-center isi">Anda dapat melihat tanggal dan waktu reservasi Anda di Paws & Whisker Care.</p>
    </div>
</div>

<!-- Formulir Edit Reservasi -->
<div class="mt-5 container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="font-family: 'Quicksand', 'sans-serif'; font-weight: bold;background-color: #FFD700; color: black; ">Lihat Reservasi <span><?= $x['nama'] ?></span></div>
                <div class="card-body">
                    <?php if (!empty($tampilJanji)) {?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Hewan</th>
                            <th scope="col">Jenis Hewan</th>
                            <th scope="col">Tanggal Reservasi</th>
                            <th scope="col">Waktu Reservasi</th>
                            <th scope="col">Keluhan</th>
                            <th scope="col">Ubah Reservasi</th>
                            <th scope="col">Batalkan Reservasi</th>
                        </tr>
                        </thead>
                        <tbody>
                           <?php $no = 1;
                            foreach ($tampilJanji as $reservasi) { ?>
                        <tr>
                            <th scope="row"><?php echo $no++?></th>
                            <td><?php echo $reservasi['nama_hewan']; ?></td>
                            <td><?php echo $reservasi['nama_binatang']; ?></td>
                            <td><?php echo $reservasi['tanggal_reservasi']; ?></td>
                            <td><?php echo $reservasi['waktu_reservasi']; ?></td>
                            <td><?php echo $reservasi['keluhan']; ?></td>
                            <td><button class="btn btn-edit"><a href="edit_reservasi.php?id=<?php echo $reservasi['id']; ?>">Edit Reservasi</a></button></td>
                            <td><button class="btn btn-hapus"><a href="batal_reservasi.php?id=<?php echo $reservasi['id']; ?>">Batal Reservasi</a></button></td>
                        </tr>
                        </tbody>
                        <?php } ?>
                        <?php } else { ?>
                            <p>Tidak ada janji.</p>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
