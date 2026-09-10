<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../Auth/login.php");
    exit();
}

$email = $_SESSION['email'];
include "../Database/config.php";
$db = new Database();
$tampilJanji = $db->tampil_reservasi_email($email);

include "dashboard.php";
?>
    <title>Reservasi Saya — Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Reservasi Saya</h1>
    <p style="color:var(--clr-text-muted);margin-bottom:1.5rem;">
      Lihat dan kelola jadwal reservasi Anda di Paws & Whiskers Care.
    </p>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Reservasi Aktif</span>
        <a href="reservasi_Profil.php" class="btn btn-rose btn-sm">+ Tambah</a>
      </div>
      <div class="card-body p-0">
        <?php if (!empty($tampilJanji)): ?>
        <div class="table-responsive">
          <table class="table-modern">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Hewan</th>
                <th>Jenis</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Keluhan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($tampilJanji as $reservasi):
                $badge_class = match($reservasi['status']) {
                    'Dijadwalkan' => 'badge-status--scheduled',
                    'Diubah' => 'badge-status--changed',
                    'Dibatalkan' => 'badge-status--cancelled',
                    default => 'badge-status--scheduled'
                };
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><strong><?php echo htmlspecialchars($reservasi['nama_hewan']); ?></strong></td>
                <td><?php echo htmlspecialchars($reservasi['nama_binatang']); ?></td>
                <td><?php echo date('d M Y', strtotime($reservasi['tanggal_reservasi'])); ?></td>
                <td><?php echo htmlspecialchars($reservasi['waktu_reservasi']); ?></td>
                <td><span class="badge-status <?php echo $badge_class; ?>"><?php echo htmlspecialchars($reservasi['status']); ?></span></td>
                <td style="max-width:200px;"><?php echo htmlspecialchars($reservasi['keluhan']); ?></td>
                <td>
                  <div class="d-flex gap-1">
                    <?php if ($reservasi['status'] === 'Dijadwalkan'): ?>
                    <a href="edit_reservasi.php?id=<?php echo intval($reservasi['id']); ?>" class="btn btn-gold btn-sm">Edit</a>
                    <a href="batal_reservasi.php?id=<?php echo intval($reservasi['id']); ?>" class="btn btn-outline-rose btn-sm">Batalkan</a>
                    <?php else: ?>
                    <span style="font-size:0.82rem;color:var(--clr-text-muted);font-style:italic;">Diproses / Selesai</span>
                    <?php endif; ?>
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
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <h3 class="empty-state__title">Belum Ada Reservasi</h3>
          <p class="empty-state__desc">Anda belum memiliki reservasi aktif saat ini.</p>
          <a href="reservasi_Profil.php" class="btn btn-rose">Buat Reservasi Pertama</a>
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
