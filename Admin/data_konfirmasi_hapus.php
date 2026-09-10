<?php
/**
 * Admin: Konfirmasi Pembatalan Reservasi — Paws & Whiskers Care
 * Menampilkan daftar reservasi yang diminta untuk dibatalkan
 */
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['roles']) || $_SESSION['roles'] !== 'admin') {
    echo '<script>alert("Akses ditolak."); document.location="../Auth/login.php";</script>';
    exit();
}

$email = $_SESSION['email'];
include "../Database/config.php";
$db = new Database();
$tampilData = $db->tampil_batal_reservasi();

include "dashboard_admin.php";
?>
    <title>Konfirmasi Pembatalan — Admin Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Permintaan Pembatalan</h1>
    <p style="color:var(--clr-text-muted);margin-bottom:1.5rem;">
      Daftar reservasi yang diminta untuk dibatalkan oleh member.
    </p>

    <div class="card">
      <div class="card-header">Menunggu Konfirmasi</div>
      <div class="card-body p-0">
        <?php if (!empty($tampilData)): ?>
        <div class="table-responsive">
          <table class="table-modern">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Hewan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Dokter</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($tampilData as $r): ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><strong><?php echo htmlspecialchars($r['nama']); ?></strong></td>
                <td><?php echo htmlspecialchars($r['nama_hewan']); ?> (<?php echo htmlspecialchars($r['nama_binatang']); ?>)</td>
                <td><?php echo date('d M Y', strtotime($r['tanggal_reservasi'])); ?></td>
                <td><?php echo htmlspecialchars($r['waktu_reservasi']); ?></td>
                <td><?php echo htmlspecialchars($r['nama_dokter']); ?></td>
                <td>
                  <a href="../Database/hapus_data_reservasi_admin.php?id=<?php echo intval($r['id']); ?>"
                     class="btn btn-rose btn-sm"
                     onclick="return confirm('Konfirmasi pembatalan reservasi ini?');">
                    Konfirmasi Batal
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="empty-state">
          <div class="empty-state__icon">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          </div>
          <h3 class="empty-state__title">Tidak Ada Permintaan</h3>
          <p class="empty-state__desc">Tidak ada permintaan pembatalan saat ini.</p>
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