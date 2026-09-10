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
    <title>Edit Profil — Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Edit Profil</h1>

    <?php if (!empty($data_profil)):
      $user = $data_profil[0];
    ?>
    <div class="card" style="max-width:720px;">
      <div class="card-header">Edit Data Profil</div>
      <div class="card-body">
        <form action="../Database/edit_data_member.php" method="post">
          <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" />

          <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama"
                   value="<?php echo htmlspecialchars($user['nama']); ?>" required />
          </div>

          <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
              <option value="Laki-laki" <?php echo ($user['jenis_kelamin'] === 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
              <option value="Perempuan" <?php echo ($user['jenis_kelamin'] === 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
            </select>
          </div>

          <div class="form-group">
            <label for="nomor_telepon">Nomor Telepon</label>
            <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon"
                   value="<?php echo htmlspecialchars($user['nomor_telepon']); ?>" required />
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($user['alamat']); ?></textarea>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold">Simpan Perubahan</button>
            <a href="profil.php" class="btn btn-outline-rose">Batal</a>
          </div>
        </form>
      </div>
    </div>
    <?php endif; ?>
  </div>
</main>

<script src="../Assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../Assets/js/app.js"></script>
</body>
</html>
