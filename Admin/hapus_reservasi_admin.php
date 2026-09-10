<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['roles']) || $_SESSION['roles'] !== 'admin') {
    echo '<script>alert("Akses ditolak."); document.location="../Auth/login.php";</script>';
    exit();
}

include "../Database/config.php";
$db = new Database();

if (!isset($_GET['id'])) {
    header('Location: data_reservasi.php');
    exit();
}

$id_reservasi = intval($_GET['id']);
$data_reservasi = $db->tampil_reservasi_id($id_reservasi);

if (empty($data_reservasi)) {
    header('Location: data_reservasi.php');
    exit();
}

$r = $data_reservasi[0];
$email = $_SESSION['email'];

include "dashboard_admin.php";
?>
    <title>Hapus Reservasi — Admin Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Batalkan Reservasi</h1>

    <div class="card" style="max-width:720px;">
      <div class="card-header" style="background:var(--clr-rose);color:white;">
        ⚠ Konfirmasi Pembatalan
      </div>
      <div class="card-body">
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Nama</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($r['nama']); ?></p>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Email</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($r['email']); ?></p>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted" style="font-size:0.8rem;">Hewan</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($r['nama_hewan']); ?> (<?php echo htmlspecialchars($r['nama_binatang']); ?>)</p>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted" style="font-size:0.8rem;">Tanggal</label>
            <p style="font-weight:600;margin:0;"><?php echo date('d M Y', strtotime($r['tanggal_reservasi'])); ?></p>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted" style="font-size:0.8rem;">Waktu</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($r['waktu_reservasi']); ?></p>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Dokter</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($r['nama_dokter']); ?></p>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Status</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($r['status']); ?></p>
          </div>
          <div class="col-12">
            <label class="form-label text-muted" style="font-size:0.8rem;">Keluhan</label>
            <p style="font-weight:600;margin:0;"><?php echo htmlspecialchars($r['keluhan']); ?></p>
          </div>
        </div>

        <div class="d-flex gap-2">
          <a href="../Database/hapus_data_reservasi_admin.php?id=<?php echo intval($r['id']); ?>"
             class="btn btn-rose"
             onclick="return confirm('Yakin ingin membatalkan reservasi ini?');">
            Ya, Batalkan
          </a>
          <a href="data_reservasi.php" class="btn btn-gold">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</main>

<script src="../Assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../Assets/js/app.js"></script>
</body>
</html>