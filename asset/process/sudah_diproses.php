<?php
// Sambungkan ke database
include("../connection.php");

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Update status pesanan menjadi "Sudah Diproses"
    $update_query = "UPDATE `order` SET status = 'Sudah dibayar' WHERE id = $order_id";
    $result = mysqli_query($conn, $update_query);

    if ($result) {
        // Redirect kembali ke halaman order_detail.php
        header("Location: ../order_detail.php");
    } else {
        echo "Gagal memperbarui status pesanan.";
    }
}

mysqli_close($conn);
?>
