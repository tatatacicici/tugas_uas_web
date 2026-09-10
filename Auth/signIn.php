<?php
include '../Database/config.php';
$db = new Database();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Daftar sebagai member Paws & Whiskers Care." />
    <title>Daftar — Paws & Whiskers Care</title>

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
                <img src="../Assets/Images/gambar2.jpg" alt="Klinik hewan" />
              </div>
            </div>
            <!-- Form Column -->
            <div class="col-md-7">
              <div class="auth-card__form">
                <a href="../index.html" style="color:var(--clr-rose);font-weight:600;font-size:0.9rem;display:inline-flex;align-items:center;gap:4px;margin-bottom:1.5rem;">
                  <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                  Kembali ke Beranda
                </a>

                <h1 class="auth-card__title">Daftar</h1>
                <p class="auth-card__subtitle">
                  Mari gabung bersama Paws Family! Sudah punya akun? <a href="login.php">Masuk</a>
                </p>

                <form action="../Database/simpan_data_member.php" method="post" id="signupForm">
                  <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                           placeholder="Masukkan nama lengkap Anda" required />
                  </div>

                  <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="d-flex gap-4 mt-1">
                      <?php
                      $pdo_statement = $db->koneksi->prepare("SHOW COLUMNS FROM members WHERE Field = 'jenis_kelamin'");
                      $pdo_statement->execute();
                      $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);
                      $enum_values = explode("','", substr($result['Type'], 6, -2));

                      foreach ($enum_values as $value) {
                          echo '<div class="form-check">';
                          echo '<input type="radio" class="form-check-input" id="jk_' . $value . '" name="jenis_kelamin" value="' . htmlspecialchars($value) . '" required />';
                          echo '<label class="form-check-label" for="jk_' . $value . '">' . htmlspecialchars($value) . '</label>';
                          echo '</div>';
                      }
                      ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon"
                               placeholder="08xxxxxxxxxx" required pattern="[0-9]{10,15}" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Masukkan email" required autocomplete="email" />
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Minimal 6 karakter" required minlength="6" autocomplete="new-password" />
                  </div>

                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat"
                              placeholder="Masukkan alamat lengkap" required rows="3"></textarea>
                  </div>

                  <button type="submit" class="btn btn-rose w-100" style="padding:0.75rem;font-size:1rem;">
                    Daftar Sekarang
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