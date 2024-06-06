<?php
session_start();

$request = $_SERVER['REQUEST_URI'];
$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$request = str_replace($baseDir, '', $request);
$request = strtok($request, '?'); // Remove query string if present

switch ($request) {
    case '/':
    case '':
        require __DIR__ . '/../app/Views/login.php';
        break;
    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include_once __DIR__ . '/../app/Controllers/AuthControllers.php';
            $authController = new AuthController();
            $authController->login($_POST['nik'], $_POST['password']);
        } else {
            require __DIR__ . '/../app/Views/login.php';
        }
        break;
    case '/register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include_once __DIR__ . '/../app/Controllers/AuthControllers.php';
            $authController = new AuthController();
            $authController->register($_POST['nik'], $_POST['nama'], $_POST['password']);
        } else {
            require __DIR__ . '/../app/Views/register.php';
        }
        break;
    default:
        http_response_code(404);
        echo "Page not found!";
        break;
}
?>
