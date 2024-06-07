<?php
require 'models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showLogin()
{
    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Cek untuk superadmin
        if ($username === 'risma' && $password === 'risma') {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'superadmin';
            header('Location: views/bs-binary-admin/blank-admin.php');
            exit();
        }

        if ($this->userModel->validateUser($username, $password)) {
            session_start();
            $_SESSION['username'] = $username;
            // Mendapatkan peran (role) pengguna dari database
            $role = $this->userModel->getUserRole($username);
            $_SESSION['role'] = $role;

            // Mengarahkan ke halaman yang sesuai berdasarkan peran
            if ($role === 'user') {
                header('Location: views/bs-binary-admin/blank.php');
                exit();
            } elseif ($role === 'admin') {
                header('Location: views/bs-binary-admin/blank-admin.php');
                exit();
            } else {
                // Jika peran tidak valid, bisa diarahkan ke halaman lain atau ditangani sesuai kebutuhan
                header('Location: views/error.php');
                exit();
            }
        } else {
            $message = 'Username dan password salah';
        }
    }

    include 'views/layout/header.php';
    include 'views/login.php';
    include 'views/layout/footer.php';
}

    




    public function showRegister()
    {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->userModel->registerUser($username, $password)) {
                $message = 'Data berhasil terinput';
            } else {
                $message = 'Data gagal terinput';
            }
        }

        include 'views/layout/header.php';
        include 'views/register.php';
        include 'views/layout/footer.php';
    }


    public function logout()
{
    // Mulai sesi jika belum dimulai
    session_start();
    
    // Hapus semua data sesi
    session_unset();

    // Hancurkan sesi
    session_destroy();

    // Redirect ke halaman login setelah logout
    header('Location: /projekRisma/index.php?page=login');
    exit();
}

}
?>
