<?php
// Buat koneksi ke database
include("../connection.php");

// Periksa apakah ada parameter ID yang diberikan
if (isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["id_order"]) && !empty($_GET["id_order"])) {
    $id_detail = $_GET["id"];
    $id_order = $_GET["id_order"];

    // Hapus data dari database
    $sql = "DELETE FROM `order_detil` WHERE id = '$id_detail'";

    if ($conn->query($sql) === TRUE) {
        // Data berhasil dihapus, arahkan kembali ke halaman yang menampilkan data pesanan utama dengan ID yang sesuai
        header("Location: showpesanan.php?id=" . $id_order);
        exit(); // Hentikan eksekusi kode selanjutnya
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID tidak valid.";
}

// Tutup koneksi ke database
$conn->close();
?>