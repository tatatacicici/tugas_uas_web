
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
$tampilJanji = $db->tampilkanReservasi($email);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservasi - Paws & Whiskers Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../Assets/Style/StyleAppoint.css" rel="stylesheet">
    <!-- Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&family=Oxygen:wght@300;400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300;400;500;600;700&display=swap');
    </style>
</head>

<body>
<?php include "dashboard.php"; ?>

<div class="row">
    <div class="col my-auto kontainer">
        <h1 class="text-center mt-4 sub-judul">Edit Reservasi</h1>
        <p class="text-center isi">Anda dapat mengedit tanggal dan waktu reservasi Anda di Paws & Whisker Care.</p>
    </div>
</div>

<!-- Formulir Edit Reservasi -->
<div class="container mt-5 kontainer">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="font-family: 'Quicksand', 'sans-serif'; font-weight: bold;background-color: #FFD700; color: black; ">Edit Reservasi</div>
                <div class="card-body">
                    <!-- Formulir Edit Reservasi Goes Here -->
                    <?php if (!empty($tampilJanji)) { ?>
                        <form class="form-reservasi" action="../Database/edit_data_reservasi.php" method="post">
                            <?php foreach ($tampilJanji as $index => $reservasi) { ?>
                                <div class="form-row reservasi-container <?= $index === 0 ? 'active' : '' ?>">

                                        <label for="id" hidden="hidden">Id:</label>
                                        <input type="text" class="form-control" id="id" name="id[]" value="<?= $reservasi['id'] ?>" hidden="hidden">

                                    <div class="form-group col-md-6">
                                        <label for="nama_hewan">Nama Peliharaan</label>
                                        <input type="text" class="form-control" id="nama_hewan"  name="nama_hewan[]" value="<?= $reservasi['nama_hewan'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="jenis_hewan">Jenis Peliharaan</label>
                                        <input type="text" class="form-control" id="jenis_hewan" name="jenis_hewan[]" value="<?= $reservasi['jenis_hewan'] ?>" readonly>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-row">
                                <!-- Tanggal Reservasi -->
                                <div class="form-group col-md-6">
                                    <label for="tanggal_reservasi_baru">Tanggal Reservasi:</label>
                                    <input type="date" class="form-control" id="tanggal_reservasi_baru" name="tanggal_reservasi_baru" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" max="<?= date('Y-m-d', strtotime('+1 month')) ?>" value="<?= $tampilJanji[0]['tanggal_reservasi'] ?>" required>
                                </div>
                                <!-- Waktu Reservasi -->
                                <div class="form-group col-md-6">
                                    <label for="waktu_reservasi_baru">Waktu Reservasi:</label>
                                    <select class="form-control" id="waktu_reservasi_baru" name="waktu_reservasi_baru" required>
                                        <?php
                                        $pdo_statement = $db->koneksi->prepare("SHOW COLUMNS FROM reservasi WHERE Field = 'waktu_reservasi'");
                                        if ($pdo_statement->execute()) {
                                            $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);
                                            $enum_values = explode("','", substr($result['Type'], 6, -2));
                                            foreach ($enum_values as $value) {
                                                echo '<option value="' . $value . '">' . $value . '</option>';
                                            }
                                        } else {
                                            echo '<option value="08:00">08:00</option>'; // Default value or handle the error
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn backButton">Back</button>
                                <button type="button" class="btn nextButton">Next</button>
                                <button type="submit" class="btn float-right">Simpan Perubahan</button>
                            </div>
                        </form>
                    <?php } else { ?>
                        <p>Tidak ada janji.</p>
                    <?php } ?>
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
    // Script JavaScript untuk mengatur tampilan formulir dengan tombol Next dan Back
    var currentIndex = 0;
    var reservasiContainers = document.querySelectorAll('.reservasi-container');
    var nextButton = document.querySelector('.nextButton');
    var backButton = document.querySelector('.backButton');

    // Sembunyikan semua elemen kecuali yang pertama
    for (var i = 1; i < reservasiContainers.length; i++) {
        reservasiContainers[i].style.display = 'none';
    }

    nextButton.addEventListener('click', function () {
        // Sembunyikan elemen saat ini
        reservasiContainers[currentIndex].style.display = 'none';

        // Pindah ke elemen berikutnya atau kembali ke yang pertama jika sudah di akhir
        currentIndex = (currentIndex + 1) % reservasiContainers.length;

        // Tampilkan elemen berikutnya
        reservasiContainers[currentIndex].style.display = 'flex';
    });

    backButton.addEventListener('click', function () {
        // Sembunyikan elemen saat ini
        reservasiContainers[currentIndex].style.display = 'none';

        // Pindah ke elemen sebelumnya atau ke yang terakhir jika sudah di awal
        currentIndex = (currentIndex - 1 + reservasiContainers.length) % reservasiContainers.length;

        // Tampilkan elemen sebelumnya
        reservasiContainers[currentIndex].style.display = 'flex';
    });
</script>

</body>

</html>
