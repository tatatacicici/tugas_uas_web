<?php
/**
 * Reusable Navbar Component — Paws & Whiskers Care
 * Usage: <?php $activePage = 'home'; include 'includes/navbar.php'; ?>
 * $activePage options: 'home', 'about', 'services', 'login'
 * $isSubdir: set to true if included from a subdirectory (Auth/, Profil/, etc.)
 */

$basePath = isset($isSubdir) && $isSubdir ? '../' : '';
?>
<nav class="navbar navbar-expand-lg sticky-top" id="mainNavbar">
  <div class="container">
    <a class="navbar-brand" href="<?php echo $basePath; ?>index.html">
      <span class="brand-icon">🐾</span>
      Paws & Whiskers Care
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarMain" aria-controls="navbarMain"
            aria-expanded="false" aria-label="Toggle navigasi">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMain">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($activePage) && $activePage === 'home') ? 'active' : ''; ?>"
             href="<?php echo $basePath; ?>index.html#home">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($activePage) && $activePage === 'about') ? 'active' : ''; ?>"
             href="<?php echo $basePath; ?>index.html#about">Tentang Kami</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($activePage) && $activePage === 'services') ? 'active' : ''; ?>"
             href="<?php echo $basePath; ?>dokter.html">Layanan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($activePage) && $activePage === 'login') ? 'active' : ''; ?>"
             href="<?php echo $basePath; ?>Auth/login.php">Masuk</a>
        </li>
      </ul>
      <a class="btn btn-reservasi" href="<?php echo $basePath; ?>Profil/reservasi.php" role="button">
        Reservasi Sekarang
      </a>
    </div>
  </div>
</nav>
