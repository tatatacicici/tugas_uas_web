<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../Auth/login.php");
    exit();
}

$email = $_SESSION['email'];
include "../Database/config.php";
$db = new Database();

if (!isset($_GET['id'])) {
    header('Location: tampilReservasi.php');
    exit();
}

$id_reservasi = intval($_GET['id']);
$data_reservasi = $db->tampil_reservasi_member($id_reservasi);

if (empty($data_reservasi)) {
    header('Location: tampilReservasi.php');
    exit();
}

$index = $data_reservasi[0];

include "dashboard.php";
?>
    <title>Batalkan Reservasi — Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Batalkan Reservasi</h1>
    <p style="color:var(--clr-text-muted);margin-bottom:1.5rem;">
      Periksa detail reservasi di bawah sebelum membatalkan. Pembatalan hanya bisa jika jadwal masih satu minggu ke depan.
    </p>

    <div class="card" style="max-width:720px;">
      <div class="card-header" style="background:var(--clr-rose);color:white;">
        ⚠ Konfirmasi Pembatalan
      </div>
      <div class="card-body">
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Nama</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($index['nama']); ?></p>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Email</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($index['email']); ?></p>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Nama Peliharaan</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($index['nama_hewan']); ?></p>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Jenis Peliharaan</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($index['nama_binatang']); ?></p>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Dokter</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($index['nama_dokter']); ?></p>
          </div>
          <div class="col-md-3">
            <label class="form-label text-muted" style="font-size:0.8rem;">Tanggal</label>
            <p style="font-weight:600;margin:0;"><?php echo date('d M Y', strtotime($index['tanggal_reservasi'])); ?></p>
          </div>
          <div class="col-md-3">
            <label class="form-label text-muted" style="font-size:0.8rem;">Waktu</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($index['waktu_reservasi']); ?></p>
          </div>
          <div class="col-12">
            <label class="form-label text-muted" style="font-size:0.8rem;">Keluhan</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($index['keluhan']); ?></p>
          </div>
        </div>

        <div class="d-flex gap-2">
          <a href="../Database/data_batal_reservasi.php?id=<?php echo intval($index['id']); ?>"
             class="btn btn-rose"
             onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini? Tindakan ini tidak dapat dibatalkan.');">
            Ya, Batalkan Reservasi
          </a>
          <a href="tampilReservasi.php" class="btn btn-gold">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</main>

<script src="../Assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../Assets/js/app.js"></script>
</body>
</html>