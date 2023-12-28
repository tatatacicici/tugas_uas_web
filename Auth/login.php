<?php
include '../Database/config.php';
$db = new Database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Assets/Style/styleSign.css" rel="stylesheet">
</head>

<body>
<div class="container mx-5 ">
    <div class="row">
        <div class="col-md-9 mt-4 p-2 kolom-form" >
            <h1>Log-In<span><a class="login mx-2" href="signIn.php"> belum punya akun? daftar</a></span></h1>
            <form action="validasi_login.php" method="post">
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email"  placeholder="Masukkan E-mail" required>
                </div>
                <!-- Password-->
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mt-3 float-right">Masuk</button>
            </form>
        </div>
        <div class="col-md-3 mt-0 align-content-end kolom-gambar">
            <img src="../Assets/Images/gambar1.jpg" alt="doktor hewan">
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>