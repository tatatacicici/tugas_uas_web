<?php
    include '../Database/config.php';
    $db = new Database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Assets/Style/styleSign.css" rel="stylesheet">
</head>

<body>
        <div class="container mx-5 ">
            <div class="row">
                <div class="col-md-9 mt-4 p-2 kolom-form" >
                    <h1>Sign-In<span><a class="login mx-2" href="login.php"> atau sudah punya akun? masuk</a></span></h1>
                    <p>Mari Gabung Bersama Kami, Paws Family</p>
                    <form action="../Database/simpan_data_member.php" method="post">
                        <!-- Nama -->
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Anda" required>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin:</label>
                            <div>
                                <?php
                                $pdo_statement = $db->koneksi->prepare("SHOW COLUMNS FROM members WHERE Field = 'jenis_kelamin'");
                                $pdo_statement->execute();
                                $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);

                                // Extract ENUM values from the column definition
                                $enum_values = explode("','", substr($result['Type'], 6, -2));

                                foreach ($enum_values as $value) {
                                    echo '<div class="form-check">';
                                    echo '<input type="radio" class="form-check-input" id="jenis_kelamin_' . $value . '" name="jenis_kelamin" value="' . $value . '" required>';
                                    echo '<label class="form-check-label" for="jenis_kelamin_' . $value . '">' . $value . '</label>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Nomor Telepon -->
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telepon:</label>
                            <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon"  placeholder="Masukkan Nomor Telepon"  required>
                        </div>
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email"  placeholder="Masukkan E-mail" required>
                        </div>
                        <!-- Password-->
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Passwword" required>
                        </div>
                        <!-- Alamat -->
                        <div class="form-group">
                            <label for="alamat">Alamat:</label>
                            <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat"  required></textarea>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary mt-3 float-right">Daftar</button>
                    </form>
                </div>
                <div class="col-md-3 mt-0   align-content-end kolom-gambar">
                    <img src="../Assets/Images/gambar2.jpg" alt="doktor hewan">
                </div>
            </div>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>