<?php
/**
 * Reusable Footer Component — Paws & Whiskers Care
 * Usage: <?php include 'includes/footer.php'; ?>
 * $basePath should be set before including
 */

$basePath = isset($basePath) ? $basePath : '';
?>
<footer class="footer" id="footer">
  <div class="container">
    <div class="row">
      <!-- Brand -->
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <div class="footer__brand">🐾 Paws & Whiskers Care</div>
        <p class="footer__desc">
          Klinik hewan terpercaya dengan perawatan berkualitas dan sentuhan penuh kasih sayang
          untuk sahabat berbulu Anda.
        </p>
      </div>

      <!-- Tautan Cepat -->
      <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
        <h5 class="footer__heading">Navigasi</h5>
        <ul class="footer__links">
          <li><a href="<?php echo $basePath; ?>index.html#home">Beranda</a></li>
          <li><a href="<?php echo $basePath; ?>index.html#about">Tentang Kami</a></li>
          <li><a href="<?php echo $basePath; ?>index.html#services">Layanan</a></li>
          <li><a href="<?php echo $basePath; ?>dokter.html">Dokter Kami</a></li>
        </ul>
      </div>

      <!-- Layanan -->
      <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
        <h5 class="footer__heading">Layanan</h5>
        <ul class="footer__links">
          <li><a href="<?php echo $basePath; ?>Profil/reservasi.php">Reservasi</a></li>
          <li><a href="<?php echo $basePath; ?>Auth/login.php">Masuk</a></li>
          <li><a href="<?php echo $basePath; ?>Auth/signIn.php">Daftar</a></li>
        </ul>
      </div>

      <!-- Kontak -->
      <div class="col-lg-4 col-md-6">
        <h5 class="footer__heading">Hubungi Kami</h5>
        <div class="footer__contact-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
          </svg>
          <span>Jl. Veteriner No. 1, Jakarta Selatan 12345</span>
        </div>
        <div class="footer__contact-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
          </svg>
          <span>(021) 1234-5678</span>
        </div>
        <div class="footer__contact-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
          </svg>
          <span>info@pawswhiskers.com</span>
        </div>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="footer__bottom">
      <p>&copy; <?php echo date('Y'); ?> Paws & Whiskers Care. Seluruh hak cipta dilindungi.</p>
    </div>
  </div>
</footer>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop" aria-label="Kembali ke atas">
  <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
    <polyline points="18 15 12 9 6 15"/>
  </svg>
</button>
