<?php

class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "projekpenduduk";
    private $conn;

    public function __construct() {
        // Membuat koneksi
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Memeriksa koneksi
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getTotalPenduduk() {
        $sql = "SELECT SUM(jumlah_penduduk) as total_penduduk FROM daerah";
        $result = $this->conn->query($sql);

        $total_penduduk = 0;
        if ($result->num_rows > 0) {
            // Mendapatkan data
            $row = $result->fetch_assoc();
            $total_penduduk = $row['total_penduduk'];
        }

        return $total_penduduk;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

// Main code
$db = new Database();
$total_penduduk = $db->getTotalPenduduk();
$db->closeConnection();

// Mengembalikan data dalam format JSON
echo json_encode(['total_penduduk' => $total_penduduk]);

?>
