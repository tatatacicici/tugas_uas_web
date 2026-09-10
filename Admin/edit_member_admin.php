<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['roles']) || $_SESSION['roles'] !== 'admin') {
    echo '<script>alert("Akses ditolak."); document.location="../Auth/login.php";</script>';
    exit();
}

$email = $_SESSION['email'];
include "../Database/config.php";
$db = new Database();

if (!isset($_GET['email'])) {
    header('Location: data_member.php');
    exit();
}

$email_user = $_GET['email'];
$data_member = $db->tampil_member_email($email_user);

if (empty($data_member)) {
    header('Location: data_member.php');
    exit();
}

$edit_member = $data_member[0];
include "dashboard_admin.php";
?>
    <title>Edit Member — Admin Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Edit Member</h1>

    <div class="card" style="max-width:720px;">
      <div class="card-header">Edit Data Member</div>
      <div class="card-body">
        <form action="../Database/edit_data_member.php" method="post">
          <input type="hidden" name="email" id="email" value="<?php echo htmlspecialchars($edit_member['email']); ?>" />

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama"
                   value="<?php echo htmlspecialchars($edit_member['nama']); ?>" required />
          </div>

          <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
              <option value="Laki-laki" <?php echo ($edit_member['jenis_kelamin'] === 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
              <option value="Perempuan" <?php echo ($edit_member['jenis_kelamin'] === 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
            </select>
          </div>

          <div class="form-group">
            <label for="nomor_telepon">Nomor Telepon</label>
            <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon"
                   value="<?php echo htmlspecialchars($edit_member['nomor_telepon']); ?>" required />
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($edit_member['alamat']); ?></textarea>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold">Simpan Perubahan</button>
            <a href="data_member.php" class="btn btn-outline-rose">Batal</a>
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