<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "restoran_db";

$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>