-- ============================================
-- Paws & Whiskers Care — Database Schema
-- ============================================
-- Jalankan file ini di MySQL/MariaDB untuk membuat database dan data awal.
-- Perintah: mysql -u root -p < schema.sql
-- ============================================

CREATE DATABASE IF NOT EXISTS `dokter_hewan`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE `dokter_hewan`;

-- -------------------------------------------
-- Tabel: members
-- -------------------------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id_member`      INT AUTO_INCREMENT PRIMARY KEY,
  `nama`           VARCHAR(100)   NOT NULL,
  `jenis_kelamin`  ENUM('Laki-laki','Perempuan') NOT NULL,
  `nomor_telepon`  VARCHAR(20)    NOT NULL,
  `email`          VARCHAR(150)   NOT NULL UNIQUE,
  `password`       VARCHAR(255)   NOT NULL,
  `alamat`         TEXT           NOT NULL,
  `roles`          ENUM('admin','user') NOT NULL DEFAULT 'user',
  `created_at`     TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -------------------------------------------
-- Tabel: jenis_peliharaan
-- -------------------------------------------
DROP TABLE IF EXISTS `jenis_peliharaan`;
CREATE TABLE `jenis_peliharaan` (
  `id_hewan`       INT AUTO_INCREMENT PRIMARY KEY,
  `nama_binatang`  VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- -------------------------------------------
-- Tabel: data_dokter
-- -------------------------------------------
DROP TABLE IF EXISTS `data_dokter`;
CREATE TABLE `data_dokter` (
  `id_dokter`    INT AUTO_INCREMENT PRIMARY KEY,
  `nama_dokter`  VARCHAR(100) NOT NULL,
  `spesialisasi` VARCHAR(100) DEFAULT NULL,
  `deskripsi`    TEXT         DEFAULT NULL
) ENGINE=InnoDB;

-- -------------------------------------------
-- Tabel: reservation
-- -------------------------------------------
DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `id`                 INT AUTO_INCREMENT PRIMARY KEY,
  `nama`               VARCHAR(100) NOT NULL,
  `email`              VARCHAR(150) NOT NULL,
  `nomor_telepon`      VARCHAR(20)  NOT NULL,
  `jenis_hewan`        INT          NOT NULL,
  `nama_hewan`         VARCHAR(100) NOT NULL,
  `dokter`             INT          NOT NULL,
  `tanggal_reservasi`  DATE         NOT NULL,
  `waktu_reservasi`    ENUM('08:00','09:00','10:00','11:00','13:00','14:00','15:00') NOT NULL,
  `keluhan`            TEXT         NOT NULL,
  `status`             ENUM('Dijadwalkan','Diubah','Dibatalkan') NOT NULL DEFAULT 'Dijadwalkan',
  `created_at`         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at`         TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT `fk_reservation_hewan`
    FOREIGN KEY (`jenis_hewan`) REFERENCES `jenis_peliharaan`(`id_hewan`)
    ON DELETE RESTRICT ON UPDATE CASCADE,

  CONSTRAINT `fk_reservation_dokter`
    FOREIGN KEY (`dokter`) REFERENCES `data_dokter`(`id_dokter`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;


-- ============================================
-- SEED DATA
-- ============================================

-- Jenis Peliharaan
INSERT INTO `jenis_peliharaan` (`nama_binatang`) VALUES
  ('Anjing'),
  ('Kucing'),
  ('Kelinci'),
  ('Hamster'),
  ('Burung'),
  ('Kura-kura'),
  ('Ikan'),
  ('Reptil');

-- Dokter
INSERT INTO `data_dokter` (`nama_dokter`, `spesialisasi`, `deskripsi`) VALUES
  ('Drh. Andrea Silalahi', 'Bedah & Ortopedi',
   'Dokter hewan berpengalaman dengan keahlian dalam bedah tulang dan jaringan lunak. Dengan pengalaman lebih dari 10 tahun, Drh. Andrea siap memberikan perawatan terbaik untuk menjaga kesehatan hewan kesayangan Anda.'),
  ('Drh. Lily Syalita', 'Dermatologi & Kecantikan',
   'Spesialis kesehatan kulit dan perawatan kecantikan hewan. Drh. Lily memberikan sentuhan kecantikan pada pelayanan hewan peliharaan Anda dengan perawatan yang disesuaikan dan penanganan yang teliti.'),
  ('Drh. Joko Arifin', 'Penyakit Dalam & Holistik',
   'Praktisi kesehatan hewan dengan pendekatan holistik. Drh. Joko tidak hanya fokus pada gejala penyakit, tetapi juga memahami kebutuhan emosional dan lingkungan hewan untuk perawatan menyeluruh.'),
  ('Drh. Merilyn Dove', 'Gigi & Mulut',
   'Dokter hewan dengan kepekaan khusus terhadap kesehatan gigi dan mulut hewan. Drh. Merilyn menawarkan solusi perawatan yang disesuaikan untuk kesehatan optimal hewan peliharaan Anda.');

-- Admin (password: admin123 — hashed dengan password_hash)
INSERT INTO `members` (`nama`, `jenis_kelamin`, `nomor_telepon`, `email`, `password`, `alamat`, `roles`) VALUES
  ('Administrator', 'Laki-laki', '081234567890', 'admin@pawswhiskers.com',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
   'Jl. Veteriner No. 1, Jakarta Selatan', 'admin');

-- User contoh (password: user123 — hashed dengan password_hash)
INSERT INTO `members` (`nama`, `jenis_kelamin`, `nomor_telepon`, `email`, `password`, `alamat`, `roles`) VALUES
  ('Budi Santoso', 'Laki-laki', '081298765432', 'budi@email.com',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
   'Jl. Merpati No. 5, Bandung', 'user'),
  ('Sari Dewi', 'Perempuan', '085612345678', 'sari@email.com',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
   'Jl. Kucing No. 12, Surabaya', 'user');

-- Reservasi contoh
INSERT INTO `reservation` (`nama`, `email`, `nomor_telepon`, `jenis_hewan`, `nama_hewan`, `dokter`, `tanggal_reservasi`, `waktu_reservasi`, `keluhan`, `status`) VALUES
  ('Budi Santoso', 'budi@email.com', '081298765432', 1, 'Rocky', 1,
   DATE_ADD(CURDATE(), INTERVAL 3 DAY), '09:00',
   'Anjing saya tidak mau makan selama 2 hari dan terlihat lesu.', 'Dijadwalkan'),
  ('Sari Dewi', 'sari@email.com', '085612345678', 2, 'Mimi', 2,
   DATE_ADD(CURDATE(), INTERVAL 5 DAY), '10:00',
   'Kucing saya sering menggaruk telinga dan ada bercak merah di kulit.', 'Dijadwalkan');
