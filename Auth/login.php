<?php
include '../Database/config.php';
$db = new Database();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Masuk ke akun Paws & Whiskers Care Anda." />
    <title>Masuk — Paws & Whiskers Care</title>

    <link href="../Assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" />
    <link href="../Assets/Style/style.css" rel="stylesheet" />
</head>
<body>
    <section class="auth-page">
      <div class="container">
        <div class="auth-card">
          <div class="row g-0">
            <!-- Image Column -->
            <div class="col-md-5 d-none d-md-block">
              <div class="auth-card__image">
                <img src="../Assets/Images/gambar1.jpg" alt="Klinik hewan" />
              </div>
            </div>
            <!-- Form Column -->
            <div class="col-md-7">
              <div class="auth-card__form">
                <a href="../index.html" style="color:var(--clr-rose);font-weight:600;font-size:0.9rem;display:inline-flex;align-items:center;gap:4px;margin-bottom:1.5rem;">
                  <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                  Kembali ke Beranda
                </a>

                <h1 class="auth-card__title">Masuk</h1>
                <p class="auth-card__subtitle">
                  Belum punya akun? <a href="signIn.php">Daftar sekarang</a>
                </p>

                <form action="validasi_login.php" method="post" id="loginForm">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           placeholder="Masukkan alamat email" required autocomplete="email" />
                  </div>
                  <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="position-relative">
                      <input type="password" class="form-control" id="password" name="password"
                             placeholder="Masukkan kata sandi" required autocomplete="current-password" />
                    </div>
                  </div>
                  <button type="submit" class="btn btn-rose w-100" style="padding:0.75rem;font-size:1rem;">
                    Masuk
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="../Assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../Assets/js/app.js"></script>
</body>
</html>