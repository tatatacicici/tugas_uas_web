<?php
/**
 * Dashboard Navigation — User
 * Paws & Whiskers Care
 * Reusable sidebar/navbar for user profile area
 */
// $email and $db should already be set by the parent page
$data_nav = $db->tampil_profil_member($email);
$user_name = !empty($data_nav) ? htmlspecialchars($data_nav[0]['nama']) : 'Pengguna';
$user_initial = !empty($user_name) ? strtoupper(substr($user_name, 0, 1)) : 'P';

// Determine active page
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="../Assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" />
    <link href="../Assets/Style/style.css" rel="stylesheet" />
</head>
<body style="background-color: var(--clr-bg);">

<nav class="dashboard-nav navbar navbar-expand-lg sticky-top">
  <div class="container-fluid px-4">
    <a class="navbar-brand d-flex align-items-center gap-2" href="profil.php">
      <span style="width:32px;height:32px;background:var(--clr-rose);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;"><?php echo $user_initial; ?></span>
      Halo, <?php echo $user_name; ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#dashNav" aria-controls="dashNav"
            aria-expanded="false" aria-label="Toggle navigasi">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="dashNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page === 'profil.php') ? 'active' : ''; ?>"
             href="profil.php">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px;margin-right:4px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Profil
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page === 'tampilReservasi.php') ? 'active' : ''; ?>"
             href="tampilReservasi.php">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px;margin-right:4px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Reservasi Saya
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page === 'reservasi_Profil.php') ? 'active' : ''; ?>"
             href="reservasi_Profil.php">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px;margin-right:4px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buat Reservasi
          </a>
        </li>
      </ul>
      <a class="btn btn-outline-rose btn-sm" href="../Auth/logout.php">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:-2px;margin-right:4px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Keluar
      </a>
    </div>
  </div>
</nav>
