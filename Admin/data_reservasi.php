<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['roles']) || $_SESSION['roles'] !== 'admin') {
    echo '<script>alert("Akses ditolak. Silakan masuk sebagai admin."); document.location="../Auth/login.php";</script>';
    exit();
}

$email = $_SESSION['email'];
include "../Database/config.php";
$db = new Database();
$tampilData = $db->tampil_reservasi_admin();

include "dashboard_admin.php";
?>
    <title>Daftar Reservasi — Admin Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Daftar Reservasi</h1>

    <div class="card">
      <div class="card-header">Semua Reservasi</div>
      <div class="card-body p-0">
        <?php if (!empty($tampilData)): ?>
        <div class="table-responsive">
          <table class="table-modern">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Hewan</th>
                <th>Jenis</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Dokter</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($tampilData as $r): ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><strong><?php echo htmlspecialchars($r['nama']); ?></strong></td>
                <td><?php echo htmlspecialchars($r['nama_hewan']); ?></td>
                <td><?php echo htmlspecialchars($r['nama_binatang']); ?></td>
                <td><?php echo date('d M Y', strtotime($r['tanggal_reservasi'])); ?></td>
                <td><?php echo htmlspecialchars($r['waktu_reservasi']); ?></td>
                <td><?php echo htmlspecialchars($r['nama_dokter']); ?></td>
                <td>
                  <?php
                  $statusClass = match($r['status']) {
                      'Dijadwalkan' => 'badge-status--scheduled',
                      'Diubah'      => 'badge-status--changed',
                      'Dibatalkan'  => 'badge-status--cancelled',
                      default       => ''
                  };
                  ?>
                  <span class="badge-status <?php echo $statusClass; ?>"><?php echo htmlspecialchars($r['status']); ?></span>
                </td>
                <td>
                  <?php if ($r['status'] !== 'Dibatalkan'): ?>
                  <div class="d-flex gap-1">
                    <a href="edit_reservasi_admin.php?id=<?php echo intval($r['id']); ?>" class="btn btn-gold btn-sm">Edit</a>
                    <a href="hapus_reservasi_admin.php?id=<?php echo intval($r['id']); ?>" class="btn btn-outline-rose btn-sm">Batal</a>
                  </div>
                  <?php else: ?>
                  <span style="color:var(--clr-text-muted);font-size:0.8rem;">—</span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="empty-state">
          <div class="empty-state__icon">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <h3 class="empty-state__title">Belum Ada Reservasi</h3>
          <p class="empty-state__desc">Belum ada reservasi yang masuk.</p>
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
