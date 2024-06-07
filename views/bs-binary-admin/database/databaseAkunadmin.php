<?php
class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'projekpenduduk');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getUsers() {
        $sql = "SELECT * FROM users";
        return $this->conn->query($sql);
    }

    public function addUser($username, $password, $role, $nik) {
        $sql = "INSERT INTO users (username, password, role, nik) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $password, $role, $nik);
        $stmt->execute();
        $stmt->close();
    }

    public function updateUser($id, $username, $password, $role, $nik) {
        $sql = "UPDATE users SET username = ?, password = ?, role = ?, nik = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $username, $password, $role, $nik, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>
