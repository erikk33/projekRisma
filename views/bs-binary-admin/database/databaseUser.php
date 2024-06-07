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

    public function getData() {
        $sql = "SELECT nik, nama, alamat, tanggal_lahir, jenis_kelamin, id_daerah FROM penduduk";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function getDataByUsername($username) {
        $stmt = $this->conn->prepare("SELECT nik, nama, alamat, tanggal_lahir, jenis_kelamin, id_daerah FROM penduduk WHERE nama = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updateData($nik, $nama, $alamat, $tanggal_lahir, $jenis_kelamin, $id_daerah) {
        $stmt = $this->conn->prepare("UPDATE penduduk SET nama = ?, alamat = ?, tanggal_lahir = ?, jenis_kelamin = ?, id_daerah = ? WHERE nik = ?");
        $stmt->bind_param("sssssi", $nama, $alamat, $tanggal_lahir, $jenis_kelamin, $id_daerah, $nik);
        return $stmt->execute();
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>
