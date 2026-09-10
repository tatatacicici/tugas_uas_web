<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['roles']) || $_SESSION['roles'] !== 'admin') {
    echo '<script>alert("Akses ditolak. Silakan masuk sebagai admin."); document.location="../Auth/login.php";</script>';
    exit();
}

$email = $_SESSION['email'];
include "../Database/config.php";
$db = new Database();
$tampilData = $db->tampil_member_admin();

include "dashboard_admin.php";
?>
    <title>Daftar Member — Admin Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Daftar Member</h1>

    <div class="card">
      <div class="card-header">
        Semua Member Terdaftar
      </div>
      <div class="card-body p-0">
        <?php if (!empty($tampilData)): ?>
        <div class="table-responsive">
          <table class="table-modern">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Kelamin</th>
                <th>Alamat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($tampilData as $member): ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><strong><?php echo htmlspecialchars($member['nama']); ?></strong></td>
                <td><?php echo htmlspecialchars($member['email']); ?></td>
                <td><?php echo htmlspecialchars($member['nomor_telepon']); ?></td>
                <td><?php echo htmlspecialchars($member['jenis_kelamin']); ?></td>
                <td style="max-width:180px;"><?php echo htmlspecialchars($member['alamat']); ?></td>
                <td>
                  <div class="d-flex gap-1">
                    <a href="edit_member_admin.php?email=<?php echo urlencode($member['email']); ?>" class="btn btn-gold btn-sm">Edit</a>
                    <a href="../Database/hapus_profil.php?email=<?php echo urlencode($member['email']); ?>"
                       class="btn btn-outline-rose btn-sm"
                       onclick="return confirm('Yakin ingin menghapus member ini?');">Hapus</a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="empty-state">
          <div class="empty-state__icon">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
          </div>
          <h3 class="empty-state__title">Belum Ada Member</h3>
          <p class="empty-state__desc">Belum ada member yang terdaftar.</p>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

<script src="../Assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../Assets/js/app.js"></script>
</body>
</html>
