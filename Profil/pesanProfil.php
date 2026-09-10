<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../Auth/login.php");
    exit();
}

$email = $_SESSION['email'];
include "../Database/config.php";
$db = new Database();
$data_profil = $db->tampil_profil_member($email);

include "dashboard.php";
?>
    <title>Reservasi Berhasil — Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <div class="thank-you__card" style="max-width:640px;margin:2rem auto;">
      <div class="thank-you__icon">
        <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <h1 class="thank-you__title">Reservasi Berhasil!</h1>
      <div class="thank-you__text">
        <p>Terima kasih telah mempercayai <strong>Paws & Whiskers Care</strong>. Reservasi Anda telah berhasil diproses.</p>
        <p>Tim medis kami akan menghubungi Anda untuk mengkonfirmasi jadwal kedatangan.</p>
      </div>
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="tampilReservasi.php" class="btn btn-rose">Lihat Reservasi Saya</a>
        <a href="profil.php" class="btn btn-gold">Kembali ke Profil</a>
      </div>
    </div>
  </div>
</main>

<script src="../Assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../Assets/js/app.js"></script>
</body>
</html>