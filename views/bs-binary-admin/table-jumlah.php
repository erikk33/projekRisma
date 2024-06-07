<?php
// Memulai session
session_start();
// Memeriksa apakah session username sudah diset
if (!isset($_SESSION['username'])) {
    // Jika tidak, redirect ke halaman login
    header('Location: ../../index.php?page=login');
    exit();
}

// Memeriksa role
if ($_SESSION['role'] === 'user') {
    // Jika role adalah user, lempar kembali ke halaman blank.php
    header('Location: blank.php');
    exit();
}

require_once 'database/database-jumlah.php';

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
                    <a href="table-jumlah.php" class="active-menu"><i class="fa fa-table fa-3x"></i> Jumlah Penduduk Daerah</a>
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

// Initialize objects
$db = new Database();
$page = new Page("Table Jumlah - Projek Penduduk");

$page->renderHeader();

// Handle update request
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_daerah = $_POST['nama_daerah'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];
    $db->updateDataDaerah($id, $nama_daerah, $jumlah_penduduk);
}

// Handle delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $db->deleteDataDaerah($id);
}

// Handle add request
if (isset($_POST['add'])) {
    $nama_daerah = $_POST['nama_daerah'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];
    $db->addDataDaerah($nama_daerah, $jumlah_penduduk);
}
?>

<style>
.fixed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Increase font size for table cells */
.table-auto td {
    font-size: 1.2rem; /* Adjust the font size as needed */
}
</style>

<div id="page-wrapper">
    <div id="page-inner" class="container mx-auto p-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-2xl font-bold">Table Jumlah Penduduk</h2>   
                <h5>Welcome Jhon Deo, Love to see you back.</h5>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <button class='bg-green-500 text-white px-3 py-2 rounded mb-4' onclick="document.getElementById('addModal').style.display='block'">Add New</button>
                <!-- Responsive Table -->
                <div class="bg-white shadow-md rounded my-6">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Nama Daerah</th>
                                <th class="py-3 px-6 text-left">Jumlah Penduduk</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <?php
                            $result = $db->getDataDaerah();
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                                    echo "<td class='py-3 px-6 text-left whitespace-nowrap'>" . $row["id"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["nama_daerah"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["jumlah_penduduk"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>";
                                    echo "<button class='bg-blue-500 text-white px-3 py-1 rounded mr-2' onclick=\"document.getElementById('editModal-{$row['id']}').style.display='block'\">Edit</button>";
                                    echo "<form style='display:inline;' method='POST'>";
                                    echo "<input type='hidden' name='id' value='{$row['id']}'>";
                                    echo "<button type='submit' name='delete' class='bg-red-500 text-white px-3 py-1 rounded'>Delete</button>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";

                                    // Edit Modal
                                    echo "
                                    <div id='editModal-{$row['id']}' class='fixed z-10 inset-0 overflow-y-auto' style='display:none;'>
                                        <div class='flex items-center justify-center min-h-screen'>
                                            <div class='bg-white p-5 rounded shadow-lg'>
                                                <h2 class='text-2xl mb-4'>Edit Data</h2>
                                                <form method='POST'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <div class='mb-4'>
                                                        <label class='block'>Nama Daerah:</label>
                                                        <input type='text' name='nama_daerah' value='{$row['nama_daerah']}' class='w-full p-2 border rounded'>
                                                    </div>
                                                    <div class='mb-4'>
                                                        <label class='block'>Jumlah Penduduk:</label>
                                                        <input type='number' name='jumlah_penduduk' value='{$row['jumlah_penduduk']}' class='w-full p-2 border rounded'>
                                                    </div>
                                                    <div class='flex justify-end'>
                                                        <button type='button' onclick=\"document.getElementById('editModal-{$row['id']}').style.display='none'\" class='bg-gray-500 text-white px-3 py-1 rounded mr-2'>Cancel</button>
                                                        <button type='submit' name='update' class='bg-blue-500 text-white px-3 py-1 rounded'>Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center py-3'>No data found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- End Responsive Table -->
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id='addModal' class='fixed z-10 inset-0 overflow-y-auto' style='display:none;'>
    <div class='flex items-center justify-center min-h-screen'>
        <div class='bg-white p-5 rounded shadow-lg'>
            <h2 class='text-2xl mb-4'>Add New Data</h2>
            <form method='POST'>
                <div class='mb-4'>
                    <label class='block'>Nama Daerah:</label>
                    <input type='text' name='nama_daerah' class='w-full p-2 border rounded'>
                </div>
                <div class='mb-4'>
                    <label class='block'>Jumlah Penduduk:</label>
                    <input type='number' name='jumlah_penduduk' class='w-full p-2 border rounded'>
                </div>
                <div class='flex justify-end'>
                    <button type='button' onclick="document.getElementById('addModal').style.display='none'" class='bg-gray-500 text-white px-3 py-1 rounded mr-2'>Cancel</button>
                    <button type='submit' name='add' class='bg-green-500 text-white px-3 py-1 rounded'>Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$page->renderFooter();
?>

<?php
$db->closeConnection();
?>
