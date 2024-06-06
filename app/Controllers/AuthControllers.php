<?php
include_once 'config/Database.php';
include_once 'app/Models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function login($nik, $password) {
        $this->user->nik = $nik;
        $this->user->password = $password;
        if ($this->user->login()) {
            // Login berhasil
            $_SESSION['user'] = $this->user->nama;
            header("Location: /dashboard");
        } else {
            // Login gagal
            echo "Login gagal, periksa kembali NIK dan Password Anda.";
        }
    }

    public function register($nik, $nama, $password) {
        $this->user->nik = $nik;
        $this->user->nama = $nama;
        $this->user->password = $password;
        if ($this->user->register()) {
            // Register berhasil
            header("Location: /login");
        } else {
            // Register gagal
            echo "Pendaftaran gagal, coba lagi.";
        }
    }
}
?>
