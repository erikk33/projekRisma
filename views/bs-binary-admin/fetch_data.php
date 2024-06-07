<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekpenduduk";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk menghitung jumlah penduduk
$sql = "SELECT SUM(jumlah_penduduk) as total_penduduk FROM daerah";
$result = $conn->query($sql);

$total_penduduk = 0;

if ($result->num_rows > 0) {
    // Mendapatkan data
    $row = $result->fetch_assoc();
    $total_penduduk = $row['total_penduduk'];
} else {
    $total_penduduk = 0;
}

$conn->close();

// Mengembalikan data dalam format JSON
echo json_encode(['total_penduduk' => $total_penduduk]);
?>
