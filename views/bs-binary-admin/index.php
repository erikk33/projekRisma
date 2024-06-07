<?php

// Class for managing sessions and user authentication
class SessionManager {
    public function __construct() {
        session_start();
    }

    public function checkUserRole($role) {
        if (!isset($_SESSION['username']) || $_SESSION['role'] !== $role) {
            header('Location: login.php');
            exit();
        }
    }
}

// Class for handling database operations
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "projekpenduduk";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    public function getTotalRows($table) {
        $sql = "SELECT COUNT(*) as total_rows FROM " . $table;
        $result = $this->conn->query($sql);
        $totalRows = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalRows = $row['total_rows'];
        }
        return $totalRows;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

// Class for rendering the page
class PageRenderer {
    private $totalRows;

    public function __construct($totalRows) {
        $this->totalRows = $totalRows;
    }

    public function renderHeader() {
        echo <<<EOT
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Bootstrap Admin Template : Binary Admin</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Binary admin</a> 
            </div>
            <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">
               
            <a href="../../index.php?page=logout" class="btn btn-danger square-btn-adjust">Logout</a>
        </div>
        </nav>   
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center">
                        <img src="assets/img/find_userb.png" class="user-image img-responsive"/>
                    </li>
                    <li>
                        <a class="active-menu" href="index.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
                   
                    
                    <li>
                        <a href="table-user.php"><i class="fa fa-table fa-3x"></i> Table Data Penduduk</a>
                    </li>
                  
                    <li>
                        <a href="blank-admin.php"><i class="fa fa-square-o fa-3x"></i> Blank Page</a>
                    </li>   
                </ul>
            </div>
        </nav>  
        <!-- /. NAV SIDE  -->
EOT;
    }

    public function renderContent() {
        echo <<<EOT
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Admin Dashboard</h2>   
                        <h5>Welcome Jhon Deo, Love to see you back. </h5>
                    </div>
                </div>              
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-6">           
                        <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-red set-icon">
                                <i class="fa fa-envelope-o"></i>
                            </span>
                            <div class="text-box" >
                                <p class="main-text">{$this->totalRows} Jumlah</p>
                                <p class="text-muted">Penduduk</p>
                            </div>
                        </div>
                    </div>
                  
                    
                   
                </div>
                <!-- /. ROW  -->
                <hr />
                <!-- Remaining content -->
            </div>
        </div>
EOT;
    }

    public function renderFooter() {
        echo <<<EOT
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- SCRIPTS AT THE BOTTOM TO REDUCE LOAD TIME -->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- MORRIS CHART SCRIPTS -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
EOT;
    }
}

// Main code
$sessionManager = new SessionManager();
$sessionManager->checkUserRole('user');

$db = new Database();
$totalRows = $db->getTotalRows('daerah');
$db->closeConnection();

$pageRenderer = new PageRenderer($totalRows);
$pageRenderer->renderHeader();
$pageRenderer->renderContent();
$pageRenderer->renderFooter();

?>
