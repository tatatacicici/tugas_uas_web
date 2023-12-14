<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $passwd = "";
    private $database = "dokter_hewan";
    public $koneksi;
    public function __construct()
    {
        try {
            $this->koneksi = new  PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->passwd);
            $this->koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM member WHERE email = :email AND password = :password";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function simpanMember($nama, $jenis_kelamin, $nomor_telepon, $email, $alamat, $password){
        $sql = "INSERT INTO member  (nama, jenis_kelamin, nomor_telepon, email, password, alamat) 
                VALUES (:nama, :jenis_kelamin, :nomor_telepon, :email, :password, :alamat)";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':nama', $nama);
        $query->bindParam(':jenis_kelamin', $jenis_kelamin);
        $query->bindParam(':nomor_telepon', $nomor_telepon);
        $query->bindParam(':email', $email);
        $query->bindParam(':alamat', $alamat);
        $query->bindParam(':password', $password);
        $query->execute();
    }
    public function tampilkanDataMemberReservasi($email)
    {
        $sql = "SELECT member.email, member.nama, member.jenis_kelamin, member.nomor_telepon, member.alamat,
                    (SELECT GROUP_CONCAT(DISTINCT nama_hewan) FROM reservasi WHERE reservasi.email = member.email) AS nama_hewan,
                    (SELECT GROUP_CONCAT(DISTINCT jenis_hewan) FROM reservasi WHERE reservasi.email = member.email) AS jenis_hewan
            FROM member
            where email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        // Mengembalikan hasil query sebagai array associative
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tampilkanDataJenisHewan($id){
        $sql = "SELECT a.*, b.* FROM reservasi a
                INNER JOIN jenis_hewan b ON b.id_hewan = a.jenis_hewan
                where id = :id";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }
    public function tampil_jensi_hewan_email($email){
        $sql = "SELECT a.*, b.* FROM reservasi a
                INNER JOIN jenis_hewan b ON b.id_hewan = a.jenis_hewan
                where email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll();
    }
    public function tampilkanDataDokter($id){
        $sql = "SELECT a.*, b.* FROM reservasi a
                INNER JOIN dokter b ON b.id_dokter = a.dokter
                where id = :id";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }

    public function cekJumlahReservasi($waktu_reservasi)
    {
        $sql = "SELECT COUNT(*) as jumlah FROM reservasi WHERE waktu_reservasi = :waktu_reservasi AND tanggal_reservasi = :tanggal_reservasi";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':waktu_reservasi', $waktu_reservasi);
        $query->bindParam(':tanggal_reservasi', $_POST['tanggal']); // Menggantinya sesuai dengan nama field pada form
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['jumlah'];
    }

    public function simpanReservasi($nama, $email, $nomor_telepon, $jenis_hewan, $nama_hewan, $dokter, $tanggal_reservasi, $waktu_reservasi, $keluhan){
        // Sesuaikan dengan struktur tabel reservasi dan parameter yang dibutuhkan
        $sql = "INSERT INTO reservasi (nama, email, nomor_telepon, jenis_hewan, nama_hewan, dokter, tanggal_reservasi, waktu_reservasi, keluhan) 
            VALUES (:nama, :email, :nomor_telepon, :jenis_hewan, :nama_hewan, :dokter, :tanggal_reservasi, :waktu_reservasi, :keluhan)";
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
        $query->execute();
    }
    public function tampilkanDataMemberByEmail($email)
    {
        $sql = "SELECT * FROM member WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function editMember($email, $nama, $jenis_kelamin, $nomor_telepon, $alamat)
    {
        $sql = "UPDATE member SET nama = :nama, jenis_kelamin = :jenis_kelamin, nomor_telepon = :nomor_telepon, alamat = :alamat WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':nama', $nama);
        $query->bindParam(':jenis_kelamin', $jenis_kelamin);
        $query->bindParam(':nomor_telepon', $nomor_telepon);
        $query->bindParam(':alamat', $alamat);
        $query->bindParam(':email', $email);
        $query->execute();
    }
    public function tampilkanReservasi($email)
    {
        $sql = "SELECT * FROM reservasi WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function hapusMember($email)
    {
        // Hapus terlebih dahulu data reservasi yang terkait dengan member
        $this->hapusReservasi($email);

        // Setelah itu, hapus data member
        $sql = "DELETE FROM member WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
    }

    private function hapusReservasi($email)
    {
        // Hapus data reservasi berdasarkan email member
        $sql = "DELETE FROM reservasi WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
    }



}


$database = new Database();
?>