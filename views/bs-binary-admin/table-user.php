<?php
session_start();
require_once 'database/databaseUser.php';
require_once 'page-user.php';

// Check if the user is logged in and has the 'user' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit();
}

// Initialize objects
$db = new Database();
$page = new Page("User Table - Projek Penduduk", "table-user");

$page->renderHeader();

// Handle update request
if (isset($_POST['update'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $id_daerah = $_POST['id_daerah'];
    $db->updateData($nik, $nama, $alamat, $tanggal_lahir, $jenis_kelamin, $id_daerah);
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
                <h2 class="text-2xl font-bold">User Table Penduduk</h2>   
                <h5>Welcome <?php echo $_SESSION['username']; ?>, Love to see you back.</h5>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <!-- Responsive Table -->
                <div class="bg-white shadow-md rounded my-6">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">NIK</th>
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Address</th>
                                <th class="py-3 px-6 text-left">Date of Birth</th>
                                <th class="py-3 px-6 text-left">Gender</th>
                                <th class="py-3 px-6 text-left">Region ID</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <?php
                            $username = $_SESSION['username'];
                            $result = $db->getDataByUsername($username);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                                    echo "<td class='py-3 px-6 text-left whitespace-nowrap'>" . $row["nik"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["nama"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["alamat"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["tanggal_lahir"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["jenis_kelamin"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["id_daerah"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>";
                                    echo "<button class='bg-blue-500 text-white px-3 py-1 rounded' onclick=\"document.getElementById('editModal-{$row['nik']}').style.display='block'\">Edit</button>";
                                    echo "</td>";
                                    echo "</tr>";

                                    // Edit Modal
                                    echo "
                                    <div id='editModal-{$row['nik']}' class='fixed z-10 inset-0 overflow-y-auto' style='display:none;'>
                                        <div class='flex items-center justify-center min-h-screen'>
                                            <div class='bg-white p-5 rounded shadow-lg'>
                                                <h2 class='text-2xl mb-4'>Edit Data</h2>
                                                <form method='POST'>
                                                    <input type='hidden' name='nik' value='{$row['nik']}'>
                                                    <div class='mb-4'>
                                                        <label class='block'>Name:</label>
                                                        <input type='text' name='nama' value='{$row['nama']}' class='w-full p-2 border rounded'>
                                                    </div>
                                                    <div class='mb-4'>
                                                        <label class='block'>Address:</label>
                                                        <input type='text' name='alamat' value='{$row['alamat']}' class='w-full p-2 border rounded'>
                                                    </div>
                                                    <div class='mb-4'>
                                                        <label class='block'>Date of Birth:</label>
                                                        <input type='date' name='tanggal_lahir' value='{$row['tanggal_lahir']}' class='w-full p-2 border rounded'>
                                                    </div>
                                                    <div class='mb-4'>
                                                        <label class='block'>Gender:</label>
                                                        <select name='jenis_kelamin' class='w-full p-2 border rounded'>
                                                            <option value='L' " . ($row['jenis_kelamin'] == 'L' ? 'selected' : '') . ">L</option>
                                                            <option value='P' " . ($row['jenis_kelamin'] == 'P' ? 'selected' : '') . ">P</option>
                                                        </select>
                                                    </div>
                                                    <div class='mb-4'>
                                                        <label class='block'>Region ID:</label>
                                                        <input type='text' name='id_daerah' value='{$row['id_daerah']}' class='w-full p-2 border rounded'>
                                                    </div>
                                                    <div class='flex justify-end'>
                                                        <button type='button' onclick=\"document.getElementById('editModal-{$row['nik']}').style.display='none'\" class='bg-gray-500 text-white px-3 py-1 rounded mr-2'>Cancel</button>
                                                        <button type='submit' name='update' class='bg-blue-500 text-white px-3 py-1 rounded'>Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    ";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='py-3 px-6 text-center'>No data available</td></tr>";
                            }
                            $db->closeConnection();
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- End Responsive Table -->
            </div>
        </div>
    </div>
</div>

<?php
$page->renderFooter();
?>
