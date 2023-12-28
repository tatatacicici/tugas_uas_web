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
$data_profil = $db->tampil_profil_member($email);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Include Bootstrap CSS if needed -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Your custom styles go here -->
    <link href="../Assets/Style/styleProfil.css" rel="stylesheet">
</head>

<body style="background-color: #f8f7f3">
<!-- Include the dashboard.php file -->
<?php include "dashboard.php"; ?>
<section id="profil">
    <div class="container mt-2 flex-column kontainer">
        <div class="row">
            <div class="col-10">
                <h1>Profil Pengguna</h1>
            </div>
            <div class="col-2 mr-1">
            </div>
        </div>
        <div class="card">
            <div class="card card-body">
                <?php foreach ($data_profil as $index){
                ?>
                <form>
                    <div class="row align-items-start">
                            <div class="form-group col col-md-6">
                                <label for="inputNama">Nama</label>
                                <input type="text" class="form-control" id="inputNama" value="<?php echo $index['nama']; ?>" readonly>
                            </div>
                            <div class="form-group col col-md-6">
                                <label for="inputJenisKelamin">Jenis Kelamin</label>
                                <input type="text" class="form-control" id="inputJenisKelamin" value="<?php echo $index['jenis_kelamin']; ?>" readonly>
                            </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="form-group col col-md-6">
                            <label for="inputEmail">Email</label>
                            <input type="email" class="form-control" id="inputEmail" value="<?php echo $index['email']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNomorTelepon">Nomor Telepon</label>
                            <input type="text" class="form-control" id="inputNomorTelepon" value="<?php echo $index['nomor_telepon']; ?>" readonly>
                        </div>
                    </div>
                    <?php
                    $data_peliharaan = $db->tampil_reservasi_profil($email);
                    foreach ($data_peliharaan as $peliharan){
                    ?>
                    <div class="row align-items-start">
                        <div class="form-group col col-md-6">
                            <label for="inputJenisHewan">Jenis Hewan</label>
                            <input type="text" class="form-control" id="inputJenisHewan" value="<?php echo $peliharan['nama_binatang']; ?>" readonly>
                        </div>
                        <div class="form-group col col-md-4">
                            <label for="inputNamaHewan">Nama Peliharaan</label>
                            <input type="text" class="form-control" id="inputNamaHewan" value="<?php echo $peliharan['nama_hewan']; ?>" readonly>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="row align-items-end mt-3">
                        <div class="form-group col float-end col-md-6">
                            <button class="btn btn-hapus align-items-end" style="background-color: #F81F45;">
                                <a href="../Database/hapus_profil.php?email=<?php echo $index['email'];?>" onclick="hapusProfil();" style="color: white; text-decoration: none">Hapus Profil
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                            </button>
                            <button class="btn btn-hapus align-items-end" style="background-color: #FFD700;">
                                <a href="edit_member.php" style="color: black; text-decoration: none">Edit Profil
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            </button>
                        </div>
                </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS and dependencies if needed -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script>
    function hapusProfil() {
        return confirm("Apakah anda yakin ingin menghapus akun ?");
    }
</script>

</body>

</html>
