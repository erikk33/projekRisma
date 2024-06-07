<?php
class Page {
    private $title;

    public function __construct($title) {
        $this->title = $title;
    }

    public function renderHeader() {
        echo <<<EOT
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{$this->title}</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- TAILWIND CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
<div id="wrapper">
    <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index-admin.php">Binary admin</a> 
        </div>
        <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">
            Last access : <?php echo date('d M Y'); ?> &nbsp; 
            <a href="../../index.php?page=logout" class="btn btn-danger square-btn-adjust">Logout</a>
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
                    <a href="index-admin.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                </li>
              
                <li>
                <a href="table-admin.php"><i class="fa fa-table fa-3x"></i> Table Data Penduduk</a>
            </li>

            <li>
                <a href="table-akun-admin.php"><i class="fa fa-table fa-3x"></i> User Account</a>
            </li>
            <li>
            <a href="table-jumlah.php"><i class="fa fa-table fa-3x"></i> Jumlah Penduduk daerah</a>
        </li>
               
                    <li>
                        <a class="active-menu" href="blank-admin.php"><i class="fa fa-square-o fa-3x"></i> Blank Page</a>
                    </li>   
                </ul>
            </div>
        </nav>  
        <!-- /. NAV SIDE  -->
EOT;
    }

    public function renderFooter() {
        echo <<<EOT
        <!-- /. NAV SIDE  -->
        </div>
    </div>
    <!-- SCRIPTS - AT THE BOTTOM TO REDUCE THE LOAD TIME -->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
EOT;
    }
}
?>
