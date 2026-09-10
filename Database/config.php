<?php
/**
 * Database Configuration — Paws & Whiskers Care
 * PDO-based database abstraction with secure password handling
 */
class Database
{
    private $host;
    private $username;
    private $passwd;
    private $database;
    public $koneksi;

    public function __construct()
    {
        // 1. Cek variabel URL lengkap (Railway MYSQL_URL atau DATABASE_URL)
        $db_url = getenv('MYSQL_URL') ?: getenv('DATABASE_URL');
        if (!empty($db_url)) {
            $parsed = parse_url($db_url);
            $this->host = $parsed['host'] ?? 'localhost';
            $port = $parsed['port'] ?? 3306;
            $this->username = $parsed['user'] ?? 'root';
            $this->passwd = $parsed['pass'] ?? '';
            $this->database = isset($parsed['path']) ? ltrim($parsed['path'], '/') : 'dokter_hewan';
        } else {
            // 2. Fallback variabel individual (Railway, Docker Compose, atau lokal)
            $this->host = getenv('DB_HOST') ?: getenv('MYSQLHOST') ?: getenv('MYSQL_HOST') ?: "localhost";
            $this->username = getenv('DB_USER') ?: getenv('MYSQLUSER') ?: getenv('MYSQL_USER') ?: "root";
            $this->passwd = getenv('DB_PASS') !== false ? getenv('DB_PASS') : (getenv('MYSQLPASSWORD') ?: getenv('MYSQL_PASSWORD') ?: "");
            $this->database = getenv('DB_NAME') ?: getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE') ?: "dokter_hewan";
            $port = getenv('DB_PORT') ?: getenv('MYSQLPORT') ?: getenv('MYSQL_PORT') ?: "3306";
        }

        try {
            $this->koneksi = new PDO(
                "mysql:host={$this->host};port={$port};dbname={$this->database};charset=utf8mb4",
                $this->username,
                $this->passwd
            );
            $this->koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->koneksi->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->koneksi->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Inisialisasi skema dan seed awal otomatis jika tabel belum dibuat di database cloud
            $this->ensureSchema();
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            $error_detail = htmlspecialchars($e->getMessage());
            die("
            <div style='font-family:Segoe UI,Tahoma,sans-serif;max-width:650px;margin:60px auto;padding:28px;border:1px solid #f5c2c7;background:#fff5f5;color:#842029;border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,0.05);'>
                <h3 style='margin-top:0;display:flex;align-items:center;gap:8px;'>⚠️ Gagal Menghubungkan ke Database</h3>
                <p style='color:#555;'>Aplikasi web tidak dapat terhubung ke server database dengan konfigurasi saat ini:</p>
                <ul style='background:#fff;padding:12px 25px;border-radius:8px;border:1px solid #fed7d7;font-family:monospace;font-size:0.9rem;color:#333;'>
                    <li>Host: <strong>{$this->host}</strong></li>
                    <li>Port: <strong>{$port}</strong></li>
                    <li>Database: <strong>{$this->database}</strong></li>
                    <li>User: <strong>{$this->username}</strong></li>
                </ul>
                <p><strong>Pesan Sistem:</strong> <code style='background:#fed7d7;padding:2px 6px;border-radius:4px;'>{$error_detail}</code></p>
                <hr style='border:0;border-top:1px solid #f5c2c7;margin:20px 0;'/>
                <h4 style='margin-bottom:8px;color:#842029;'>🛠️ Solusi di Railway:</h4>
                <ol style='padding-left:20px;font-size:0.92rem;line-height:1.6;color:#444;'>
                    <li>Buka project Anda di dashboard <strong>Railway</strong>.</li>
                    <li>Klik <strong>+ New</strong> &rarr; pilih <strong>Database</strong> &rarr; pilih <strong>Add MySQL</strong>.</li>
                    <li>Di service web Anda, buka tab <strong>Variables</strong> &rarr; klik <strong>Add Reference Variable</strong> &rarr; pilih variabel database (<code>MYSQLHOST</code>, <code>MYSQLUSER</code>, <code>MYSQLPASSWORD</code>, <code>MYSQLPORT</code>, <code>MYSQLDATABASE</code> atau <code>MYSQL_URL</code>).</li>
                </ol>
            </div>
            ");
        }
    }

    /**
     * Otomatis inisialisasi tabel dan data awal jika tabel members belum ada
     */
    private function ensureSchema()
    {
        try {
            $check = $this->koneksi->query("SHOW TABLES LIKE 'members'");
            if ($check && $check->rowCount() === 0) {
                $schema_file = __DIR__ . '/schema.sql';
                if (file_exists($schema_file)) {
                    $sql = file_get_contents($schema_file);
                    // Hapus perintah CREATE DATABASE dan USE agar kueri tabel masuk ke database aktif
                    $sql = preg_replace('/CREATE DATABASE[^;]+;/i', '', $sql);
                    $sql = preg_replace('/USE[^;]+;/i', '', $sql);
                    $this->koneksi->exec($sql);
                }
            }
        } catch (Exception $ex) {
            error_log("Schema auto-init notice: " . $ex->getMessage());
        }
    }

    // ── Authentication ────────────────────────

    /**
     * Ambil user berdasarkan email (untuk verifikasi password di PHP)
     */
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM members WHERE email = :email LIMIT 1";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Cek apakah email sudah terdaftar
     */
    public function emailExists($email)
    {
        $sql = "SELECT COUNT(*) as jumlah FROM members WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        $result = $query->fetch();
        return $result['jumlah'] > 0;
    }

    // ── Member CRUD ───────────────────────────

    /**
     * Simpan member baru (password sudah di-hash sebelum masuk)
     */
    public function simpanMember($nama, $jenis_kelamin, $nomor_telepon, $email, $alamat, $password)
    {
        $sql = "INSERT INTO members (nama, jenis_kelamin, nomor_telepon, email, password, alamat, roles)
                VALUES (:nama, :jenis_kelamin, :nomor_telepon, :email, :password, :alamat, 'user')";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':nama', $nama);
        $query->bindParam(':jenis_kelamin', $jenis_kelamin);
        $query->bindParam(':nomor_telepon', $nomor_telepon);
        $query->bindParam(':email', $email);
        $query->bindParam(':alamat', $alamat);
        $query->bindParam(':password', $password);
        return $query->execute();
    }

    public function tampil_profil_member($email)
    {
        $sql = "SELECT * FROM members WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll();
    }

    public function tampil_member_email($email)
    {
        $sql = "SELECT * FROM members WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll();
    }

    public function tampil_member_admin()
    {
        $sql = "SELECT * FROM members WHERE roles != 'admin'";
        $query = $this->koneksi->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function editMember($email, $nama, $jenis_kelamin, $nomor_telepon, $alamat)
    {
        $sql = "UPDATE members SET nama = :nama, jenis_kelamin = :jenis_kelamin,
                nomor_telepon = :nomor_telepon, alamat = :alamat WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':nama', $nama);
        $query->bindParam(':jenis_kelamin', $jenis_kelamin);
        $query->bindParam(':nomor_telepon', $nomor_telepon);
        $query->bindParam(':alamat', $alamat);
        $query->bindParam(':email', $email);
        return $query->execute();
    }

    public function hapusMember($email)
    {
        $sql = "DELETE FROM members WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        return $query->execute();
    }

    // ── Reservation CRUD ──────────────────────

    public function simpanReservasi($nama, $email, $nomor_telepon, $jenis_hewan, $nama_hewan, $dokter, $tanggal_reservasi, $waktu_reservasi, $keluhan)
    {
        $sql = "INSERT INTO reservation (nama, email, nomor_telepon, jenis_hewan, nama_hewan, dokter, tanggal_reservasi, waktu_reservasi, keluhan, status)
                VALUES (:nama, :email, :nomor_telepon, :jenis_hewan, :nama_hewan, :dokter, :tanggal_reservasi, :waktu_reservasi, :keluhan, 'Dijadwalkan')";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':nama', $nama);
        $query->bindParam(':email', $email);
        $query->bindParam(':nomor_telepon', $nomor_telepon);
        $query->bindParam(':jenis_hewan', $jenis_hewan);
        $query->bindParam(':nama_hewan', $nama_hewan);
        $query->bindParam(':dokter', $dokter);
        $query->bindParam(':tanggal_reservasi', $tanggal_reservasi);
        $query->bindParam(':waktu_reservasi', $waktu_reservasi);
        $query->bindParam(':keluhan', $keluhan);
        return $query->execute();
    }

    public function tampil_reservasi_email($email)
    {
        $sql = "SELECT a.*, b.nama_dokter, b.spesialisasi, c.nama_binatang
                FROM reservation a
                INNER JOIN data_dokter b ON b.id_dokter = a.dokter
                INNER JOIN jenis_peliharaan c ON c.id_hewan = a.jenis_hewan
                WHERE a.email = :email
                ORDER BY a.tanggal_reservasi DESC";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll();
    }

    public function tampil_reservasi_profil($email)
    {
        $sql = "SELECT a.nama_hewan, b.nama_binatang
                FROM reservation a
                INNER JOIN jenis_peliharaan b ON b.id_hewan = a.jenis_hewan
                WHERE a.email = :email
                GROUP BY a.nama_hewan, b.nama_binatang";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll();
    }

    public function tampil_reservasi_id($id)
    {
        $sql = "SELECT a.*, b.nama_dokter, b.spesialisasi, c.nama_binatang
                FROM reservation a
                INNER JOIN data_dokter b ON b.id_dokter = a.dokter
                INNER JOIN jenis_peliharaan c ON c.id_hewan = a.jenis_hewan
                WHERE a.id = :id AND (a.status = 'Dijadwalkan' OR a.status = 'Diubah')";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }

    public function tampil_reservasi_member($id)
    {
        $sql = "SELECT a.*, b.nama_dokter, b.spesialisasi, c.nama_binatang
                FROM reservation a
                INNER JOIN data_dokter b ON b.id_dokter = a.dokter
                INNER JOIN jenis_peliharaan c ON c.id_hewan = a.jenis_hewan
                WHERE a.id = :id AND a.status = 'Dijadwalkan'";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }

    public function tampil_reservasi_admin()
    {
        $sql = "SELECT a.*, b.nama_dokter, b.spesialisasi, c.nama_binatang
                FROM reservation a
                INNER JOIN data_dokter b ON b.id_dokter = a.dokter
                INNER JOIN jenis_peliharaan c ON c.id_hewan = a.jenis_hewan
                ORDER BY a.created_at DESC";
        $query = $this->koneksi->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function tampil_batal_reservasi()
    {
        $sql = "SELECT a.*, b.nama_dokter, b.spesialisasi, c.nama_binatang
                FROM reservation a
                INNER JOIN data_dokter b ON b.id_dokter = a.dokter
                INNER JOIN jenis_peliharaan c ON c.id_hewan = a.jenis_hewan
                WHERE a.status = 'Diubah'
                ORDER BY a.updated_at DESC";
        $query = $this->koneksi->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function edit_reservasi($id, $nama_hewan, $tanggal_reservasi, $waktu_reservasi)
    {
        $sql = "UPDATE reservation SET nama_hewan = :nama_hewan,
                tanggal_reservasi = :tanggal_reservasi,
                waktu_reservasi = :waktu_reservasi
                WHERE id = :id";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':nama_hewan', $nama_hewan);
        $query->bindParam(':tanggal_reservasi', $tanggal_reservasi);
        $query->bindParam(':waktu_reservasi', $waktu_reservasi);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }

    public function batal_reservasi($id)
    {
        $sql = "UPDATE reservation SET status = 'Dibatalkan' WHERE id = :id";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }

    public function request_batal($id)
    {
        $sql = "UPDATE reservation SET status = 'Diubah' WHERE id = :id";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }

    public function hapus_reservasi_id($id)
    {
        $sql = "DELETE FROM reservation WHERE id = :id";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }

    public function cekJumlahReservasi($waktu_reservasi, $tanggal = null)
    {
        $tanggal = $tanggal ?: ($_POST['tanggal'] ?? date('Y-m-d'));
        $sql = "SELECT COUNT(*) as jumlah FROM reservation
                WHERE waktu_reservasi = :waktu_reservasi AND tanggal_reservasi = :tanggal_reservasi";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':waktu_reservasi', $waktu_reservasi);
        $query->bindParam(':tanggal_reservasi', $tanggal);
        $query->execute();
        $result = $query->fetch();
        return $result['jumlah'];
    }
}

$database = new Database();
?>