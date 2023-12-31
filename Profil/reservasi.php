<?php
    include '../Database/config.php';
    $db = new Database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi - Paws & Whiskers Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="../Assets/Style/StyleAppoint.css" rel="stylesheet">
    <!--Fonts    -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&family=Oxygen:wght@300;400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300;400;500;600;700&display=swap');
    </style>
</head>

<body>
    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Paws & Whiskers Care</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto ">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.html#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.html#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../dokter.html">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Auth/login.php">Login</a>
                    </li>
                </ul>
                <a class="btn btn-primary appointment-link " href="#" role="button">Reservasi</a>
            </div>
        </div>
    </nav>
    <!-- Selamat Datang -->
    <div class="Hello Awal">
        <div class="cover"></div>
        <div class="sub-title">
            <div class="row">
                <div class="col my-auto">
                    <h1 class="text-center mt-4 judul">Buat Reservasi</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col my-auto">
            <h1 class="text-center mt-4 sub-judul">Buat Reservasi</h1>
            <p class=" text-center isi">Anda bisa buat reservasi sebelum bertemu para dokter kami di Paws & Whisker Care. Reservasi bisa dibuat satu hari sebelum hari kedatangan</p>
        </div>

    </div>
    <!-- Reservasi Form -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Reservasi</div>
                        <div class="card-body">
                            <!-- Reservasi Form Goes Here -->
                            <form class="form-reservasi" action="../Database/simpan_reservasi.php" method="post">
                            <!--Nama Pemilik-->
                                <div class="form-group">
                                    <label for="nama">Nama Pemilik:</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Anda" required>
                                </div>
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email"  placeholder="Masukkan E-mail" required>
                                </div>
                                <!-- Nomor Telepon -->
                                <div class="form-group">
                                    <label for="nomor_telepon">Nomor Telepon:</label>
                                    <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon"  placeholder="Masukkan Nomor Telepon"  required>
                                </div>
                                <!-- Jenis Hewan -->
                                <div class="form-group">
                                    <label for="jenis_hewan">Jenis Peliharaan:</label>
                                    <select class="form-control" id="jenis_hewan" name="jenis_hewan" required>
                                        <option value="--"></option>
                                        <?php
                                            $pdo_statement = $db->koneksi->prepare("SELECT * FROM jenis_peliharaan");
                                            $pdo_statement->execute();
                                            $result = $pdo_statement->fetchAll();
                                            $no = 1;
                                            foreach ($result as $x){
                                                echo '<option value="'.$x['id_hewan'].'">'.$x['nama_binatang'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!-- Nama Hewan -->
                                <div class="form-group">
                                    <label for="nama_hewan">Nama Peliharaan:</label>
                                    <input type="tel" class="form-control" id="nama_hewan" name="nama_hewan"  placeholder="Masukkan Nama Peliharaan Anda"  required>
                                </div>
                                <!--Dokter -->
                                <div class="form-group">
                                    <label for="dokter">Dokter: </label>
                                    <select class="form-control" id="dokter" name="dokter" required>
                                        <option value="--"></option>
                                        <?php
                                        $pdo_statement = $db->koneksi->prepare("SELECT * FROM data_dokter");
                                        $pdo_statement->execute();
                                        $result = $pdo_statement->fetchAll();
                                        $no = 1;
                                        foreach ($result as $x){
                                            echo '<option value="'.$x['id_dokter'].'">'.$x['nama_dokter'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!-- Tanggal -->
                                <div class="form-group">
                                    <label for="tanggal_reservasi">Tanggal Reservasi:</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" required>
                                </div>
                                <!--Waktu Reservasi-->
                                <div class="form-group">
                                    <label for="waktu_reservasi">Waktu Reservasi:</label>
                                    <select class="form-control" id="waktu_reservasi" name="waktu_reservasi" required>
                                        <?php
                                        $pdo_statement = $db->koneksi->prepare("SHOW COLUMNS FROM reservation WHERE Field = 'waktu_reservasi'");
                                        $pdo_statement->execute();
                                        $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);
                                        $jenis_kelamin = explode("','", substr($result['Type'], 6, -2));
                                        foreach ($jenis_kelamin as $jk) {
                                            $jumlahReservasi = $db->cekJumlahReservasi($jk);
                                            echo '<option value="' . $jk . '" ' . ($jumlahReservasi >= 7 ? 'disabled' : '') . '>' . $jk . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!--Keluhan-->
                                <div class="form-group">
                                    <label for="keluhan">Keluhan:</label>
                                    <div>
                                        <textarea name="keluhan" id="keluhan"  rows="5" cols="80" required></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btnSave float-end">Submit Reservasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>