<?php

session_start();

// Cek apakah pengguna sudah login dan memiliki role yang sesuai
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Jika bukan admin, arahkan ke halaman login
    header('Location: login.php');
    exit();
}
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "projekpenduduk";

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan jumlah baris dalam tabel 'daerah'
$sql = "SELECT COUNT(*) as total_rows FROM daerah";
$result = $conn->query($sql);

// Ambil hasil query
$totalRows = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalRows = $row['total_rows'];
}

// Tutup koneksi
$conn->close();
?>

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
                <a class="navbar-brand" href="index.html">Binary admin</a> 
            </div>
            <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">
                Last access : 30 May 2014 &nbsp; <a href="#" class="btn btn-danger square-btn-adjust">Logout</a>
            </div>
        </nav>   
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center">
                        <img src="assets/img/find_user.png" class="user-image img-responsive"/>
                    </li>
                    <li>
                        <a class="active-menu" href="index.html"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="ui.html"><i class="fa fa-desktop fa-3x"></i> UI Elements</a>
                    </li>
                    <li>
                        <a href="tab-panel.html"><i class="fa fa-qrcode fa-3x"></i> Tabs & Panels</a>
                    </li>
                    <li>
                        <a href="chart.html"><i class="fa fa-bar-chart-o fa-3x"></i> Morris Charts</a>
                    </li>	
                    <li>
                        <a href="table.html"><i class="fa fa-table fa-3x"></i> Table Examples</a>
                    </li>
                    <li>
                        <a href="form.html"><i class="fa fa-edit fa-3x"></i> Forms </a>
                    </li>				
                    <li>
                        <a href="#"><i class="fa fa-sitemap fa-3x"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>  
                    <li>
                        <a href="blank-admin.php"><i class="fa fa-square-o fa-3x"></i> Blank Page</a>
                    </li>	
                </ul>
            </div>
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
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
                                <p class="main-text"><?php echo $totalRows; ?> Jumlah</p>
                                <p class="text-muted">Penduduk</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
                        <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-green set-icon">
                                <i class="fa fa-bars"></i>
                            </span>
                            <div class="text-box" >
                                <p class="main-text">30 Tasks</p>
                                <p class="text-muted">Remaining</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
                        <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-blue set-icon">
                                <i class="fa fa-bell-o"></i>
                            </span>
                            <div class="text-box" >
                                <p class="main-text">240 New</p>
                                <p class="text-muted">Notifications</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
                        <div class="panel panel-back noti-box">
                            <span class="icon-box bg-color-brown set-icon">
                                <i class="fa fa-rocket"></i>
                            </span>
                            <div class="text-box" >
                                <p class="main-text">3 Orders</p>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <!-- Remaining content -->
            </div>
        </div>
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
