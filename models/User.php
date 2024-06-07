<?php

class User
{
    private $pdo;

    public function __construct()
    {
        require 'config/database.php';
        $this->pdo = $pdo;
    }

    public function findUserByUsername($username)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public function validateUser($username, $password)
    {
        $user = $this->findUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }

    public function registerUser($username, $password)
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
        return $stmt->execute([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user'
        ]);
    }

    public function getUserRole($username)
    {
        $stmt = $this->pdo->prepare('SELECT role FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<pre>';
        var_dump($user); // Debug statement untuk melihat nilai $user
        echo '</pre>';
        return $user['role'] ?? null;
    }
    
}
?>
