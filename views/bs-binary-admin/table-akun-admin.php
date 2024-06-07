<?php
// blank.php

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
?>
<?php
require_once 'database/databaseAkunadmin.php';
require_once 'page.php';

// Initialize objects
$db = new Database();
$page = new Page("Admin Account Table - Projek Penduduk");

$page->renderHeader();

// Handle update request
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $nik = $_POST['nik'];
    $db->updateUser($id, $username, $password, $role, $nik);
}

// Handle delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $db->deleteUser($id);
}

// Handle add request
if (isset($_POST['add'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $nik = $_POST['nik'];
    $db->addUser($username, $password, $role, $nik);
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
                <h2 class="text-2xl font-bold">Table Akun Admin</h2>   
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
                                <th class="py-3 px-6 text-left">Username</th>
                                <th class="py-3 px-6 text-left">Password</th>
                                <th class="py-3 px-6 text-left">Role</th>
                                <th class="py-3 px-6 text-left">NIK</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <?php
                            $result = $db->getUsers();
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                                    echo "<td class='py-3 px-6 text-left whitespace-nowrap'>" . $row["id"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["username"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["password"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["role"]. "</td>";
                                    echo "<td class='py-3 px-6 text-left'>" . $row["nik"]. "</td>";
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
                                                        <label class='block'>Username:</label>
                                                        <input type='text' name='username' value='{$row['username']}' class='w-full p-2 border rounded'>
                                                    </div>
                                                    <div class='mb-4'>
                                                        <label class='block'>Password:</label>
                                                        <input type='text' name='password' value='{$row['password']}' class='w-full p-2 border rounded'>
                                                    </div>
                                                    <div class='mb-4'>
                                                        <label class='block'>Role:</label>
                                                        <select name='role' class='w-full p-2 border rounded'>
                                                            <option value='admin' " . ($row['role'] == 'admin' ? 'selected' : '') . ">Admin</option>
                                                            <option value='user' " . ($row['role'] == 'user' ? 'selected' : '') . ">User</option>
                                                        </select>
                                                    </div>
                                                    <div class='mb-4'>
                                                        <label class='block'>NIK:</label>
                                                        <input type='text' name='nik' value='{$row['nik']}' class='w-full p-2 border rounded'>
                                                    </div>
                                                    <div class='flex justify-end'>
                                                        <button type='button' onclick=\"document.getElementById('editModal-{$row['id']}').style.display='none'\" class='bg-gray-500 text-white px-3 py-1 rounded mr-2'>Cancel</button>
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

<!-- Add Modal -->
<div id='addModal' class='fixed z-10 inset-0 overflow-y-auto' style='display:none;'>
    <div class='flex items-center justify-center min-h-screen'>
        <div class='bg-white p-5 rounded shadow-lg'>
            <h2 class='text-2xl mb-4'>Add New Data</h2>
            <form method='POST'>
                <div class='mb-4'>
                    <label class='block'>Username:</label>
                    <input type='text' name='username' class='w-full p-2 border rounded'>
                </div>
                <div class='mb-4'>
                    <label class='block'>Password:</label>
                    <input type='text' name='password' class='w-full p-2 border rounded'>
                </div>
                <div class='mb-4'>
                    <label class='block'>Role:</label>
                    <select name='role' class='w-full p-2 border rounded'>
                        <option value='admin'>Admin</option>
                        <option value='user'>User</option>
                    </select>
                </div>
                <div class='mb-4'>
                    <label class='block'>NIK:</label>
                    <input type='text' name='nik' class='w-full p-2 border rounded'>
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
