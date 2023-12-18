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
    foreach ($db->login($email, $password) as $index) {
        $roles = $index['roles'];
        if($roles == 'admin'){
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
<?php include "dashboard_admin.php"; ?>

<div class="row">
    <div class="col my-auto kontainer">
        <h1 class="text-center mt-4 sub-judul">Edit Reservasi</h1>
    </div>

</div>
<!-- Reservasi Form -->
<div class="container mt-5 kontainer">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #FFD700"> Edit Reservasi</div>
                <div class="card-body">
                    <form class="form-reservasi" action="../Database/edit_data_reservasi.php" method="post">
                        <input type="hidden" name="id" value="<?php echo  $data_reservasi[0]['id']; ?>">
                        <!--Nama Hewan-->
                        <div class="form-group">
                            <label for="nama_hewan">Nama Hewan:</label>
                            <input type="text" class="form-control" id="nama_hewan" name="nama_hewan" value="<?php echo $data_reservasi[0]['nama_hewan']; ?>" required>
                            <!-- Jenis Hewan -->
                            <div class="form-group">
                                <label for="jenis_hewan">Jenis Peliharaan:</label>
                                <input type="text" name="jenis_hewan" class="form-control" id="jenis_hewan" value="<?php echo $data_reservasi[0]['nama_binatang'];?>"readonly>
                            </div>
                        </div>
                        <!-- Tanggal -->
                        <div class="form-group">
                            <label for="tanggal_reservasi">Tanggal Reservasi:</label>
                            <input type="date" class="form-control" id="tanggal_reservasi" name="tanggal_reservasi" min="<?php echo date('Y-m-d', strtotime('+1 week')); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>"  value="<?php echo $data_reservasi[0]['tanggal_reservasi'];?>"required>
                        </div>
                        <!--Waktu Reservasi-->
                        <div class="form-group">
                            <label for="waktu_reservasi">Waktu Reservasi:</label>
                            <select class="form-control" id="waktu_reservasi" name="waktu_reservasi" required>
                                <?php
                                $pdo_statement = $db->koneksi->prepare("SHOW COLUMNS FROM reservation WHERE Field = 'waktu_reservasi'");
                                $pdo_statement->execute();
                                $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);
                                $enum_values = explode("','", substr($result['Type'], 6, -2));
                                foreach ($enum_values as $value) {
                                    $jumlahReservasi = $db->cekJumlahReservasi($value);

                                    // Menampilkan opsi dropdown
                                    echo '<option value="' . $value . '" ' . ($jumlahReservasi >= 7 ? 'disabled' : '') . '>' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-edit float-right">Edit Reservasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

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
}else{
    echo '<script>
          alert("Akses Ditolak. Silahkan masukkan email dan password anda")
          document.location="../index.html"</script>';
    }
?>