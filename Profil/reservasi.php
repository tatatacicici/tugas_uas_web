<?php
include '../Database/config.php';
$db = new Database();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Buat reservasi di Paws & Whiskers Care untuk hewan peliharaan Anda." />
    <title>Reservasi — Paws & Whiskers Care</title>

    <link href="../Assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" />
    <link href="../Assets/Style/style.css" rel="stylesheet" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top" id="mainNavbar">
      <div class="container">
        <a class="navbar-brand" href="../index.html">
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
            <li class="nav-item"><a class="nav-link" href="../index.html#home">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="../index.html#about">Tentang Kami</a></li>
            <li class="nav-item"><a class="nav-link" href="../dokter.html">Dokter</a></li>
            <li class="nav-item"><a class="nav-link" href="../Auth/login.php">Masuk</a></li>
          </ul>
          <a class="btn btn-reservasi active" href="#" role="button">Reservasi Sekarang</a>
        </div>
      </div>
    </nav>

    <main>
      <section class="section" style="padding-top:2rem;">
        <div class="container">
          <h1 class="section-title">Buat Reservasi</h1>
          <p class="section-subtitle">
            Buat reservasi sebelum bertemu para dokter kami di Paws & Whiskers Care.
            Reservasi bisa dibuat satu hari sebelum hari kedatangan.
          </p>

          <div class="card reveal" style="max-width:720px;margin:0 auto;">
            <div class="card-header">Formulir Reservasi</div>
            <div class="card-body">
              <form action="../Database/simpan_reservasi.php" method="post">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nama">Nama Pemilik</label>
                      <input type="text" class="form-control" id="nama" name="nama"
                             placeholder="Masukkan nama Anda" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" name="email"
                             placeholder="Masukkan email" required />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="nomor_telepon">Nomor Telepon</label>
                  <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon"
                         placeholder="08xxxxxxxxxx" required />
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="jenis_hewan">Jenis Peliharaan</label>
                      <select class="form-select" name="jenis_hewan" id="jenis_hewan" required>
                        <option value="">— Pilih jenis —</option>
                        <?php
                        $stmt = $db->koneksi->prepare("SELECT * FROM jenis_peliharaan");
                        $stmt->execute();
                        foreach ($stmt->fetchAll() as $hewan) {
                            echo '<option value="' . intval($hewan['id_hewan']) . '">' . htmlspecialchars($hewan['nama_binatang']) . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nama_hewan">Nama Peliharaan</label>
                      <input type="text" class="form-control" id="nama_hewan" name="nama_hewan"
                             placeholder="Nama peliharaan Anda" required />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="dokter">Dokter</label>
                  <select class="form-select" name="dokter" id="dokter" required>
                    <option value="">— Pilih dokter —</option>
                    <?php
                    $stmt = $db->koneksi->prepare("SELECT * FROM data_dokter");
                    $stmt->execute();
                    foreach ($stmt->fetchAll() as $dok) {
                        echo '<option value="' . intval($dok['id_dokter']) . '">' . htmlspecialchars($dok['nama_dokter']) . '</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tanggal">Tanggal Reservasi</label>
                      <input type="date" class="form-control" id="tanggal" name="tanggal"
                             min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                             max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="waktu_reservasi">Waktu Reservasi</label>
                      <select class="form-select" id="waktu_reservasi" name="waktu_reservasi" required>
                        <option value="">— Pilih waktu —</option>
                        <?php
                        $stmt = $db->koneksi->prepare("SHOW COLUMNS FROM reservation WHERE Field = 'waktu_reservasi'");
                        $stmt->execute();
                        $col = $stmt->fetch(PDO::FETCH_ASSOC);
                        $values = explode("','", substr($col['Type'], 6, -2));
                        foreach ($values as $val) {
                            $count = $db->cekJumlahReservasi($val);
                            $disabled = ($count >= 7) ? 'disabled' : '';
                            echo '<option value="' . htmlspecialchars($val) . '" ' . $disabled . '>' . htmlspecialchars($val) . ($count >= 7 ? ' (Penuh)' : '') . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="keluhan">Keluhan</label>
                  <textarea class="form-control" name="keluhan" id="keluhan" rows="4"
                            placeholder="Ceritakan keluhan atau kondisi hewan peliharaan Anda" required></textarea>
                </div>

                <button type="submit" class="btn btn-rose" style="padding:0.65rem 2rem;">
                  Kirim Reservasi
                </button>
              </form>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="footer" style="margin-top:3rem;">
      <div class="container">
        <div class="footer__bottom" style="margin-top:0; border-top:none; padding-top:0;">
          <p>&copy; 2024 Paws & Whiskers Care. Seluruh hak cipta dilindungi.</p>
        </div>
      </div>
    </footer>

    <script src="../Assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../Assets/js/app.js"></script>
</body>
</html>