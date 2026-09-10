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
$user_data = !empty($data_profil) ? $data_profil[0] : null;

include "dashboard.php";
?>
    <title>Buat Reservasi — Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Buat Reservasi</h1>
    <p style="color:var(--clr-text-muted);margin-bottom:1.5rem;">
      Buat reservasi sebelum bertemu para dokter kami. Reservasi bisa dibuat satu hari sebelum hari kedatangan.
    </p>

    <div class="card" style="max-width:720px;">
      <div class="card-header">Formulir Reservasi</div>
      <div class="card-body">
        <form action="../Database/simpan_reservasi.php" method="post">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama">Nama Pemilik</label>
                <input type="text" class="form-control" id="nama" name="nama"
                       placeholder="Masukkan nama Anda" required
                       value="<?php echo $user_data ? htmlspecialchars($user_data['nama']) : ''; ?>" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       placeholder="Masukkan email" required
                       value="<?php echo $user_data ? htmlspecialchars($user_data['email']) : ''; ?>" />
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="nomor_telepon">Nomor Telepon</label>
            <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon"
                   placeholder="08xxxxxxxxxx" required
                   value="<?php echo $user_data ? htmlspecialchars($user_data['nomor_telepon']) : ''; ?>" />
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="jenis_hewan">Jenis Peliharaan</label>
                <select class="form-select" name="jenis_hewan" id="jenis_hewan" required>
                  <option value="">— Pilih jenis —</option>
                  <?php
                  $stmt = $db->koneksi->prepare("SELECT * FROM jenis_peliharaan");
                  $stmt->execute();
                  foreach ($stmt->fetchAll() as $hewan) {
                      echo '<option value="' . intval($hewan['id_hewan']) . '">' . htmlspecialchars($hewan['nama_binatang']) . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama_hewan">Nama Peliharaan</label>
                <input type="text" class="form-control" id="nama_hewan" name="nama_hewan"
                       placeholder="Nama peliharaan Anda" required />
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="dokter">Dokter</label>
            <select class="form-select" name="dokter" id="dokter" required>
              <option value="">— Pilih dokter —</option>
              <?php
              $stmt = $db->koneksi->prepare("SELECT * FROM data_dokter");
              $stmt->execute();
              foreach ($stmt->fetchAll() as $dok) {
                  echo '<option value="' . intval($dok['id_dokter']) . '">' . htmlspecialchars($dok['nama_dokter']) . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="tanggal">Tanggal Reservasi</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal"
                       min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                       max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" required />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="waktu_reservasi">Waktu Reservasi</label>
                <select class="form-select" id="waktu_reservasi" name="waktu_reservasi" required>
                  <option value="">— Pilih waktu —</option>
                  <?php
                  $stmt = $db->koneksi->prepare("SHOW COLUMNS FROM reservation WHERE Field = 'waktu_reservasi'");
                  $stmt->execute();
                  $col = $stmt->fetch();
                  $values = explode("','", substr($col['Type'], 6, -2));
                  foreach ($values as $val) {
                      $count = $db->cekJumlahReservasi($val);
                      $disabled = ($count >= 7) ? 'disabled' : '';
                      echo '<option value="' . htmlspecialchars($val) . '" ' . $disabled . '>' . htmlspecialchars($val) . ($count >= 7 ? ' (Penuh)' : '') . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="keluhan">Keluhan</label>
            <textarea class="form-control" name="keluhan" id="keluhan" rows="4"
                      placeholder="Ceritakan keluhan atau kondisi hewan peliharaan Anda" required></textarea>
          </div>

          <button type="submit" class="btn btn-rose" style="padding:0.65rem 2rem;">
            Kirim Reservasi
          </button>
        </form>
      </div>
    </div>
  </div>
</main>

<script src="../Assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../Assets/js/app.js"></script>
</body>
</html>