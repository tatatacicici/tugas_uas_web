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
    <title>Edit Reservasi — Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Edit Reservasi</h1>
    <p style="color:var(--clr-text-muted);margin-bottom:1.5rem;">
      Ubah data atau jadwal reservasi Anda. Perubahan hanya bisa dilakukan jika jadwal masih satu minggu ke depan.
    </p>

    <div class="card" style="max-width:720px;">
      <div class="card-header">Edit Reservasi</div>
      <div class="card-body">
        <form action="../Database/edit_data_reservasi.php" method="post">
          <input type="hidden" name="id" value="<?php echo intval($index['id']); ?>" />

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama_hewan">Nama Hewan</label>
                <input type="text" class="form-control" id="nama_hewan" name="nama_hewan"
                       value="<?php echo htmlspecialchars($index['nama_hewan']); ?>" required />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="jenis_hewan">Jenis Peliharaan</label>
                <input type="text" class="form-control" id="jenis_hewan"
                       value="<?php echo htmlspecialchars($index['nama_binatang']); ?>" readonly />
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
                       value="<?php echo htmlspecialchars($index['tanggal_reservasi']); ?>" required />
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
                      $selected = ($val === $index['waktu_reservasi']) ? 'selected' : '';
                      $disabled = ($count >= 7 && $val !== $index['waktu_reservasi']) ? 'disabled' : '';
                      echo '<option value="' . htmlspecialchars($val) . '" ' . $selected . ' ' . $disabled . '>' . htmlspecialchars($val) . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold">Simpan Perubahan</button>
            <a href="tampilReservasi.php" class="btn btn-outline-rose">Batal</a>
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