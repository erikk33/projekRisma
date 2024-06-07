<?php
// index.php

// Load the configuration
require 'config/database.php';

// Load the controllers
require 'controllers/UserController.php';


$controller = new UserController();

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'register':
        $controller->showRegister();
        break;
    case 'login':
        $controller->showLogin();
        break;
    
    case 'logout':
        $controller->logout();
        break;
    default:
        $controller->showLogin();
        break;
}
?>
