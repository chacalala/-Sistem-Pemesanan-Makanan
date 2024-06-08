<?php
// Buat koneksi ke database
include("connection.php");

// Periksa apakah ada parameter ID yang diberikan
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = $_GET["id"];

    // Hapus data dari database
    $sql = "DELETE FROM foods_menu WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Data berhasil dihapus, arahkan kembali ke halaman yang menampilkan data
        header("Location: menu.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID tidak valid.";
}

// Tutup koneksi ke database
$conn->close();
?>