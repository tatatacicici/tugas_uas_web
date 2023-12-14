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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Include Bootstrap CSS if needed -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
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
                <?php foreach ($tampilData as $index => $urutan){
                ?>
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputNama">Nama</label>
                            <input type="text" class="form-control" id="inputNama" value="<?php echo $urutan['nama']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputJenisKelamin">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="inputJenisKelamin" value="<?php echo $urutan['jenis_kelamin']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail">Email</label>
                            <input type="email" class="form-control" id="inputEmail" value="<?php echo $urutan['email']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNomorTelepon">Nomor Telepon</label>
                            <input type="text" class="form-control" id="inputNomorTelepon" value="<?php echo $urutan['nomor_telepon']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputJenisHewan">Jenis Hewan</label>
                            <?php
                            $tampil_jenis_hewan = $db->tampil_jenis_hewan_email($email);
                            foreach ($tampil_jenis_hewan as $z){
                            ?>
                            <input type="text" class="form-control" id="inputJenisHewan" value="<?php echo $z['nama_binatang']; ?>" readonly>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAlamat">Alamat</label>
                            <input type="text" class="form-control" id="inputAlamat" value="<?php echo $urutan['alamat']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputNamaHewan">Nama Peliharaan</label>
                            <input type="text" class="form-control" id="inputNamaHewan" value="<?php echo $x['nama_hewan']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                            foreach ($tampilData as $x) {
                                echo '<a href="javascript:void(0);" class="btn btn-primary" style="background-color: #F81F45; color: #FFFFFF; font-family: Poppins, sans-serif; position: absolute; bottom: 0; right: 0; border: none" onclick="hapusProfil(\'' . $x['email'] . '\')">';
                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">';
                                echo '<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>';
                                echo '</svg>';
                                echo 'Hapus Profil</a>';
                            }
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                            foreach ($tampilData as $x) {
                                echo '<a href="edit_member.php" class="btn btn-primary float-end" style="background-color: #FFD700; color: black; font-family: Poppins, sans-serif; position: absolute; bottom: 0; right: 0; border: none">';
                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">';
                                echo '<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>';
                                echo '<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>';
                                echo '</svg>';
                                echo ' Edit Profil</a>';
                            }
                            ?>
                        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    function hapusProfil(email) {
        // Munculkan konfirmasi
        var konfirmasi = confirm('Apakah Anda yakin ingin menghapus profil?');

        if (konfirmasi) {
            // Redirect ke halaman yang menangani penghapusan profil
            window.location.href = '../Database/hapus_profil.php?email=' + email;
        }
    }
</script>

</body>

</html>
