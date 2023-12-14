<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="../Assets/Style/styleDashBoard.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
    .offcanvas{
        position: fixed;
        margin-top: 57px; /* Adjust this value based on your navbar height */
        bottom: 0;
        right: 0;
        left: 0;
        padding: 1rem;
        overflow-y: auto;
        z-index: 1050; /* Ensure offcanvas is above the rest of the content */
        background-color: #FFD700; /* Set background color for offcanvas */
        transition: transform 0.3s ease; /* Add smooth transition for better user experience */
        transform: translateX(100%);
    }
    .offcanvas-body{
        background-color: #FFD700;
    }
    .list-group-item {
        color: #000;
        position: relative;
        transition: color 0.3s ease;
        overflow: hidden; /* Menyembunyikan isi yang keluar dari batas */
        text-overflow: ellipsis; /* Menampilkan elipsis (...) jika isi terlalu panjang */
        white-space: nowrap; /* Mencegah pemisahan baris pada isi yang panjang */
        max-width: 200px; /* Sesuaikan panjang maksimum sesuai kebutuhan */
    }

    .list-group-item::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: #F81F45;
        transform: translateX(-50%);
        transition: width 0.3s ease;
    }

    .list-group-item:hover {
        color: #F81F45;
    }

    .list-group-item:hover::before {
        width: 100%;
    }

    .list-group-item.active {
        color: #F81F45 !important;
    }


</style>
<body>
<nav class="navbar navbar-expand-lg py-2 sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand mx-4" href="#">
            <?php
            $tampilData = $db->tampilkanDataMemberReservasi($email);
            foreach ($tampilData as $x) {

            }
            ?>
           <p class="mr-5 mb-0">Selamat Datang <span><?php echo $x['nama']; ?></span></p>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas">

            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservasi_Profil.php">Appointment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../Auth/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<button class="btn button-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
    </svg>
</button>

<div class="offcanvas offcanvas-start show" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel" >
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Menu Profil & Reservasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="" style="border: none">
            <li class="list-group-item active p-2"><a href="profil.php" style="color: black; text-decoration: none; font-family: 'Poppins', sans-serif" >Profil</a></li>
            <li class="list-group-item p-2"><a href="tampilReservasi.php" style="color: black; text-decoration: none; font-family: 'Poppins', sans-serif">Lihat Reservasi</a></li>
            <li class="list-group-item p-2"><a href="reservasi_Profil.php" style="color: black; text-decoration: none; font-family: 'Poppins', sans-serif">Tambah Reservasi</a></li>
            <li class="list-group-item p-2"><a href="edit_reservasi.php" style="color: black; text-decoration: none; font-family: 'Poppins', sans-serif">Edit Reservasi</a></li>
            <li class="list-group-item p-2"><a href="hapus_reserbasi.php" style="color: black; text-decoration: none; font-family: 'Poppins', sans-serif">Hapus Reservasi</a></li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        var offcanvasScrolling = new bootstrap.Offcanvas(document.getElementById('offcanvasScrolling'));

        offcanvasScrolling._element.addEventListener('shown.bs.offcanvas', function () {
            // Geser kontainer ke kanan ketika offcanvas ditampilkan
            $('.kontainer').css('transform', 'translateX(200px)');
        });

        offcanvasScrolling._element.addEventListener('hidden.bs.offcanvas', function () {
            // Kembalikan kontainer ke posisi semula ketika offcanvas disembunyikan
            $('.kontainer').css('transform', 'translateX(0)');
        });
    });
</script>

</body>
</html>
