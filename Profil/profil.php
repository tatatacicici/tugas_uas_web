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
    <title>Profil — Paws & Whiskers Care</title>

<main>
  <div class="dashboard-container" style="margin-top:2rem;">
    <h1 class="dashboard-title">Profil Saya</h1>

    <?php if (!empty($data_profil)):
      $user = $data_profil[0];
      $initials = !empty($user['nama']) ? strtoupper(substr($user['nama'], 0, 1)) : 'P';
    ?>
    <div class="profile-card">
      <div class="profile-card__header">
        <div class="profile-card__avatar"><?php echo $initials; ?></div>
        <h2 style="margin:0;font-size:1.3rem;"><?php echo htmlspecialchars($user['nama']); ?></h2>
        <p style="margin:0;opacity:0.8;font-size:0.9rem;"><?php echo htmlspecialchars($user['email']); ?></p>
      </div>

      <div class="profile-card__body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Nama Lengkap</label>
            <p style="font-weight:600;margin-bottom:0;"><?php echo htmlspecialchars($user['nama']); ?></p>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Jenis Kelamin</label>
            <p style="font-weight:600;margin-bottom:0;"><?php echo htmlspecialchars($user['jenis_kelamin']); ?></p>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Email</label>
            <p style="font-weight:600;margin-bottom:0;"><?php echo htmlspecialchars($user['email']); ?></p>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted" style="font-size:0.8rem;">Nomor Telepon</label>
            <p style="font-weight:600;margin-bottom:0;"><?php echo htmlspecialchars($user['nomor_telepon']); ?></p>
          </div>
          <div class="col-12">
            <label class="form-label text-muted" style="font-size:0.8rem;">Alamat</label>
            <p style="font-weight:600;margin-bottom:0;"><?php echo htmlspecialchars($user['alamat']); ?></p>
          </div>
        </div>

        <?php
        $data_peliharaan = $db->tampil_reservasi_profil($email);
        if (!empty($data_peliharaan) && !empty($data_peliharaan[0]['nama_hewan'])):
        ?>
        <hr style="margin:1.5rem 0;" />
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem;">Hewan Peliharaan</h3>
        <div class="row g-2">
          <?php foreach ($data_peliharaan as $pet): ?>
          <div class="col-md-6">
            <div style="background:var(--clr-off-white);padding:0.75rem 1rem;border-radius:var(--radius-sm);display:flex;align-items:center;gap:0.75rem;">
              <span style="font-size:1.5rem;">🐾</span>
              <div>
                <strong><?php echo htmlspecialchars($pet['nama_hewan']); ?></strong>
                <br/><small style="color:var(--clr-text-muted);"><?php echo htmlspecialchars($pet['nama_binatang']); ?></small>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="profile-card__actions">
        <a href="edit_member.php" class="btn btn-gold btn-sm">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-1px;margin-right:4px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit Profil
        </a>
        <a href="../Database/hapus_profil.php?email=<?php echo urlencode($user['email']); ?>"
           class="btn btn-outline-rose btn-sm"
           onclick="return confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.');">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-1px;margin-right:4px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
          Hapus Akun
        </a>
      </div>
    </div>
    <?php endif; ?>
  </div>
</main>

<script src="../Assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../Assets/js/app.js"></script>
</body>
</html>
