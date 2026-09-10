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
    <title>Edit Reservasi — Admin Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Edit Reservasi</h1>

    <div class="card" style="max-width:720px;">
      <div class="card-header">Edit Reservasi — <?php echo htmlspecialchars($r['nama']); ?></div>
      <div class="card-body">
        <form action="../Database/edit_data_reservasi.php" method="post">
          <input type="hidden" name="id" value="<?php echo intval($r['id']); ?>" />

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama_hewan">Nama Hewan</label>
                <input type="text" class="form-control" id="nama_hewan" name="nama_hewan"
                       value="<?php echo htmlspecialchars($r['nama_hewan']); ?>" required />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="jenis_hewan">Jenis Peliharaan</label>
                <input type="text" class="form-control" id="jenis_hewan"
                       value="<?php echo htmlspecialchars($r['nama_binatang']); ?>" readonly />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="tanggal_reservasi">Tanggal Reservasi</label>
                <input type="date" class="form-control" id="tanggal_reservasi" name="tanggal_reservasi"
                       min="<?php echo date('Y-m-d', strtotime('+1 week')); ?>"
                       max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>"
                       value="<?php echo htmlspecialchars($r['tanggal_reservasi']); ?>" required />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="waktu_reservasi">Waktu Reservasi</label>
                <select class="form-select" id="waktu_reservasi" name="waktu_reservasi" required>
                  <?php
                  $stmt = $db->koneksi->prepare("SHOW COLUMNS FROM reservation WHERE Field = 'waktu_reservasi'");
                  $stmt->execute();
                  $col = $stmt->fetch();
                  $values = explode("','", substr($col['Type'], 6, -2));
                  foreach ($values as $val) {
                      $count = $db->cekJumlahReservasi($val);
                      $selected = ($val === $r['waktu_reservasi']) ? 'selected' : '';
                      $disabled = ($count >= 7 && $val !== $r['waktu_reservasi']) ? 'disabled' : '';
                      echo '<option value="' . htmlspecialchars($val) . '" ' . $selected . ' ' . $disabled . '>' . htmlspecialchars($val) . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold">Simpan Perubahan</button>
            <a href="data_reservasi.php" class="btn btn-outline-rose">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<script src="../Assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../Assets/js/app.js"></script>
</body>
</html>