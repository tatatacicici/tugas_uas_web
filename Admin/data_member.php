
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
$tampilData = $db->tampil_member_admin();
foreach ($db->login($email, $password) as $index) {
    $roles = $index['roles'];
    if($roles == 'admin'){
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
<?php include "dashboard_admin.php"; ?>
<div class="row">
    <div class="col my-auto kontainer">
        <h1 class="text-center mt-4 sub-judul">Daftar Member</h1>
    </div>
</div>
<div class="mt-5 container">
    <div class="table-responsive">
    <?php if (!empty($tampilData)) {?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Email</th>
            <th scope="col">Nomor Telepon</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Alamat</th>
            <th scope="col">Ubah Akun</th>
            <th scope="col">Hapus Akun</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1;
        foreach ($tampilData as $member) { ?>
        <tr>
            <th scope="row"><?php echo $no++?></th>
            <td><?php echo $member['nama']; ?></td>
            <td><?php echo $member['email']; ?></td>
            <td><?php echo $member['nomor_telepon']; ?></td>
            <td><?php echo $member['jenis_kelamin']; ?></td>
            <td><?php echo $member['alamat']; ?></td>
            <td><a href="../Admin/edit_member_admin.php?email=<?php echo $member['email']; ?>"><button class="btn btn-edit">Edit Akun</button></a></td>
            <td><a href="../Database/hapus_profil.php?email=<?php echo $member['email']; ?>"><button class="btn btn-hapus">Hapus Akun</button></a></td>
        </tr>
        </tbody>
        <?php } ?>
        <?php } else { ?>
            <p style="text-align: center">Tidak ada Member.</p>
        <?php } ?>
    </table>
    </div>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
<?php
    }else{
    echo '<script>
          alert("Akses Ditolak. Silahkan masukkan email dan password anda")
          document.location="../index.html"</script>';
}
}
