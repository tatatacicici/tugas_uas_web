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
    //login
    public function login($email, $password)
    {
        $sql = "SELECT * FROM members WHERE email = :email AND password = :password";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    //Tambah Data
    public function simpanMember($nama, $jenis_kelamin, $nomor_telepon, $email, $alamat, $password){
        $sql = "INSERT INTO members  (nama, jenis_kelamin, nomor_telepon, email, password, alamat, roles) 
                VALUES (:nama, :jenis_kelamin, :nomor_telepon, :email, :password, :alamat, 'user')";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':nama', $nama);
        $query->bindParam(':jenis_kelamin', $jenis_kelamin);
        $query->bindParam(':nomor_telepon', $nomor_telepon);
        $query->bindParam(':email', $email);
        $query->bindParam(':alamat', $alamat);
        $query->bindParam(':password', $password);
        $query->execute();
    }
    public function simpanReservasi($nama, $email, $nomor_telepon, $jenis_hewan, $nama_hewan, $dokter, $tanggal_reservasi, $waktu_reservasi, $keluhan){
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
        $query->execute();
    }
    //tampil data
    public function tampil_profil_member($email)
    {
        $sql = "SELECT * FROM members
                WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function tampil_reservasi_email($email){
        $sql = "SELECT a.*, b.*, c.* FROM reservation a
                INNER JOIN data_dokter b ON b.id_dokter = a.dokter
                INNER JOIN jenis_peliharaan c ON c.id_hewan = a.jenis_hewan
                WHERE email = :email AND status = 'Dijadwalkan'";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll();
    }
    public function tampil_reservasi_profil($email){
        $sql = "SELECT a.*, b.*,
                GROUP_CONCAT(b.nama_binatang) AS nama_binatang,
                GROUP_CONCAT(a.nama_hewan) AS nama_hewan
                FROM reservation a
                INNER JOIN jenis_peliharaan b ON b.id_hewan = a.jenis_hewan
                WHERE email = :email ";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll();
    }
    public function tampil_reservasi_id($id){
        $sql = "SELECT a.*, b.*, c.* FROM reservation a
                INNER JOIN data_dokter b ON b.id_dokter = a.dokter
                INNER JOIN jenis_peliharaan c ON c.id_hewan = a.jenis_hewan
                WHERE id = :id AND status = 'Dijadwalkan' OR  status = 'Diubah'";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }
    public function tampil_reservasi_member($id){
        $sql = "SELECT a.*, b.*, c.* FROM reservation a
                INNER JOIN data_dokter b ON b.id_dokter = a.dokter
                INNER JOIN jenis_peliharaan c ON c.id_hewan = a.jenis_hewan
                WHERE id = :id AND status = 'Dijadwalkan'";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }
    public function tampil_member_admin(){
        $sql = "SELECT * FROM members
                WHERE NOT roles = 'admin' ";
        $query = $this->koneksi->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public function tampil_reservasi_admin(){
        $sql = "SELECT a.*, b.*, c.* FROM reservation a
                INNER JOIN data_dokter b ON b.id_dokter = a.dokter
                INNER JOIN jenis_peliharaan c ON c.id_hewan = a.jenis_hewan";
        $query = $this->koneksi->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public function tampil_batal_reservasi(){
        $sql = "SELECT a.*, b.*, c.* FROM reservation a
                INNER JOIN data_dokter b ON b.id_dokter = a.dokter
                INNER JOIN jenis_peliharaan c ON c.id_hewan = a.jenis_hewan
                WHERE status = 'Diubah'";
        $query = $this->koneksi->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function cekJumlahReservasi($waktu_reservasi)
    {
        $sql = "SELECT COUNT(*) as jumlah FROM reservation 
              WHERE waktu_reservasi = :waktu_reservasi AND tanggal_reservasi = :tanggal_reservasi";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':waktu_reservasi', $waktu_reservasi);
        $query->bindParam(':tanggal_reservasi', $_POST['tanggal']);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['jumlah'];
    }
    public function tampil_member_email($email)
    {
        $sql = "SELECT * FROM members WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchAll();
    }
    //update data
    public function editMember($email, $nama, $jenis_kelamin, $nomor_telepon, $alamat)
    {
        $sql = "UPDATE members SET nama = :nama, jenis_kelamin = :jenis_kelamin, nomor_telepon = :nomor_telepon,
                alamat = :alamat WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':nama', $nama);
        $query->bindParam(':jenis_kelamin', $jenis_kelamin);
        $query->bindParam(':nomor_telepon', $nomor_telepon);
        $query->bindParam(':alamat', $alamat);
        $query->bindParam(':email', $email);
        $query->execute();
    }
    public function edit_reservasi($id, $nama_hewan, $tanggal_reservasi, $waktu_reservasi){
        $sql = "UPDATE reservation SET nama_hewan = :nama_hewan, tanggal_reservasi = :tanggal_reservasi, 
                waktu_reservasi = :waktu_reservasi
                WHERE id = :id";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':nama_hewan', $nama_hewan);
        $query->bindParam(':tanggal_reservasi', $tanggal_reservasi);
        $query->bindParam(':waktu_reservasi', $waktu_reservasi);
        $query->bindParam(':id', $id);
        $query->execute();
    }
    public function batal_reservasi($id){
        $sql = "UPDATE reservation SET status = 'Dibatalkan'
                WHERE id = :id";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
    }
    public function request_batal($id){
        $sql = "UPDATE reservation SET status = 'Diubah'
                WHERE id = :id";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
    }
    //hapus data
    public function hapusMember($email)
    {
        $sql = "DELETE FROM members WHERE email = :email";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
    }

    public function hapus_reservasi_id($id){
        $sql = "DELETE  FROM reservation WHERE id = :id";
        $query = $this->koneksi->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
    }



}


$database = new Database();
?>