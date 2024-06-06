<?php
class User {
    private $conn;
    private $table_name = "penduduk";

    public $nik;
    public $nama;
    public $password; // untuk menyimpan password

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table_name . " SET nik=:nik, nama=:nama, password=:password";
        $stmt = $this->conn->prepare($query);

        // sanitasi
        $this->nik = htmlspecialchars(strip_tags($this->nik));
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        // bind values
        $stmt->bindParam(":nik", $this->nik);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":password", $this->password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nik = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->nik);
        $stmt->execute();
        
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->password, $row['password'])) {
                $this->nama = $row['nama'];
                return true;
            }
        }
        return false;
    }
}
?>
