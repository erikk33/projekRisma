<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "projekpenduduk";
    private $conn;

    public function __construct() {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getDataPenduduk() {
        $sql = "SELECT nik, nama, alamat, tanggal_lahir, jenis_kelamin, id_daerah FROM penduduk";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function updateDataPenduduk($nik, $nama, $alamat, $tanggal_lahir, $jenis_kelamin, $id_daerah) {
        $stmt = $this->conn->prepare("UPDATE penduduk SET nama=?, alamat=?, tanggal_lahir=?, jenis_kelamin=?, id_daerah=? WHERE nik=?");
        $stmt->bind_param("sssssi", $nama, $alamat, $tanggal_lahir, $jenis_kelamin, $id_daerah, $nik);
        return $stmt->execute();
    }

    public function deleteDataPenduduk($nik) {
        $stmt = $this->conn->prepare("DELETE FROM penduduk WHERE nik=?");
        $stmt->bind_param("i", $nik);
        return $stmt->execute();
    }

    public function addDataPenduduk($nik, $nama, $alamat, $tanggal_lahir, $jenis_kelamin, $id_daerah) {
        $stmt = $this->conn->prepare("INSERT INTO penduduk (nik, nama, alamat, tanggal_lahir, jenis_kelamin, id_daerah) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssi", $nik, $nama, $alamat, $tanggal_lahir, $jenis_kelamin, $id_daerah);
        return $stmt->execute();
    }

    public function getDataDaerah() {
        $sql = "SELECT id, nama_daerah, jumlah_penduduk FROM daerah";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function updateDataDaerah($id, $nama_daerah, $jumlah_penduduk) {
        $stmt = $this->conn->prepare("UPDATE daerah SET nama_daerah=?, jumlah_penduduk=? WHERE id=?");
        $stmt->bind_param("sii", $nama_daerah, $jumlah_penduduk, $id);
        return $stmt->execute();
    }

    public function deleteDataDaerah($id) {
        $stmt = $this->conn->prepare("DELETE FROM daerah WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function addDataDaerah($nama_daerah, $jumlah_penduduk) {
        $stmt = $this->conn->prepare("INSERT INTO daerah (nama_daerah, jumlah_penduduk) VALUES (?, ?)");
        $stmt->bind_param("si", $nama_daerah, $jumlah_penduduk);
        return $stmt->execute();
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>
