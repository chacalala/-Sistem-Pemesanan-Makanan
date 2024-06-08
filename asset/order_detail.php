<?php

session_start();

include "connection.php";

if (!isset($_SESSION['level'])) {
    header('location: ../index.html');
    exit(); 
}

if ($_SESSION['level'] != 'kasir') {
    header('location: ../index.html');
    exit();
}

if (!isset($_SESSION['login'])) {
    header('location: ../index.html');
    exit();
}

$_SESSION['username'] = "KASIR"; 
// Menentukan kolom pengurutan default
$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'tanggal';

// (ascending atau descending)
$order = "ASC"; 
$arrow = '↑'; 
if (isset($_GET['order'])) {
    if ($_GET['order'] === 'desc') {
        $order = "DESC"; 
        $arrow = '↓';
    }
}

// Fungsi untuk mengembalikan tautan pengurutan yang sesuai
function generateSortingLink($column, $currentOrder, $currentColumn)
{
    $newOrder = 'asc';
    if ($currentOrder === 'asc' && $currentColumn === $column) {
        $newOrder = 'desc';
    }
    return "order_detail.php?orderBy={$column}&order={$newOrder}";
}

// Mengubah tanda panah sesuai dengan jenis pengurutan
$arrow = ($order === 'ASC') ? '↑' : '↓';

// Fungsi untuk melakukan pencarian
function cariDataDariOrderDetail($conn, $searchTerm) {
    $sql = "SELECT * FROM `order` WHERE no_meja LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $counter = 1; // Variabel untuk nomor urut
        while ($row = mysqli_fetch_assoc($result)) {
            // Ambil id_order
            $id_order = $row["id"];

            // Query SQL untuk menghitung total harga dari order_detil
            $totalHargaQuery = "SELECT SUM(sub_total) AS total_harga FROM order_detil WHERE id_order = $id_order";
            $totalHargaResult = mysqli_query($conn, $totalHargaQuery);
            $totalHargaRow = mysqli_fetch_assoc($totalHargaResult);
            $totalHarga = $totalHargaRow['total_harga'];

            echo "<tr>";
            echo "<td>" . $counter . "</td>"; // Menampilkan nomor urut
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "<td>" . $row['jam'] . "</td>";
            echo "<td>" . $row['pelayan'] . "</td>";
            echo "<td>" . $row['no_meja'] . "</td>";
            echo "<td><a href='o_detailUorD/showpesanan.php?id=" . $row["id"] . "'>Pesanan</a>  <a href='o_detailUorD/delete.php?id=" . $row["id"] . "'>Delete</a></td>";
            echo "<td>$totalHarga</td>"; // Menampilkan total harga
            echo "<td>" . $row['status'] . "</td>";
            echo "<td><a class='process' href='process/sudah_diproses.php?id=" . $row["id"] . "'>Bayar</a></td>";
            echo "</tr>";
            
            $counter++; // Increment nomor urut
        }
    } else {
        echo "<tr><td colspan='8'>Data tidak ditemukan.</td></tr>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-image: url('image/banner-background-image.jpg');
            background-size: cover; 
            background-attachment: fixed;

        }
        .cari{
            color:white;
        }
        
        .navbar {
            padding: 15px 20px;
            text-align: left;
            position: fixed;
            width: 100%; /* Set width to 100% to extend across the entire screen */
            top: 0;
            left: 0;
            z-index: 1000; /* Ensure the navbar is on top of other content */
            background-color: rgba(255, 255, 255, 0.1);
            box-sizing: border-box; /* Ensure padding is included in the width */
               display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: rgba(255, 255, 255, 0.1);
            box-sizing: border-box;
            width: 100%;
        }

        .menu ul {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
        }

        .menu li {
            display: inline-block;
            margin-left: 20px;
        }
        .menu .in a {
            background-color: grey;
            border-radius: 5px;
        }
        .wrapper {
            max-width: 800px; /* Atur lebar maksimum */
            margin: 0 auto; /* Membuat konten berada di tengah */
            padding-top: 60px; /* Atur padding atas untuk mempertahankan posisi navbar */
        }
        .menu a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: color 0.3s, background-color 0.3s;
            padding: 8px 16px;
            border-radius: 5px;
        }

        .menu a:hover {
            background-color: #3f3f3f;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 120px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .right-corner {
            margin-left: auto;
            display: flex;
            align-items: center;
        }
        .container {
            width: 60%;
            margin: 20px auto;
            padding-top: 30px;
        }
        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            font-family: Courier;
            background-color: white;
        }

        tr:nth-child(even),
        tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        th {
            background-color: grey;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }
        .price {
            color: #DBD8ED;
        }
        tr:nth-child(even) {
            background-color: #EEEEEE;
        }
        tr:nth-child(odd) {
            background-color: #ddd;
        }
        .add_menu a {
            font-weight: bold;
        }
        h1 {
            text-align: left;
            color: #d98c59;
        }
        .process {
            background-color: #5C5870;
            color: #DBD8ED;
            text-decoration: none;
            padding: 5px;
            border-radius: 5px;
        }
        .process:hover {
            background-color: #DBD8ED;
            color: #d98c59;
        }
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .page-item {
            margin: 0 5px;
        }

        .page-link {
            color: #343a40;
            background-color: white;
            border: 1px solid #d98c59;
            border-radius: 5px;
            padding: 8px 15px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .page-link:hover {
            color: #fff;
            background-color: #343a40;
        }

        @media (max-width: 425px) {
            .menu li {
                display: block;
                margin: 10px 0;
            }
            
            .body {
                background-attachment: scroll;
                background-size: contain;
            }
            table {
                    font-size: 7px; /* Atur ulang ukuran font agar lebih mudah dibaca di perangkat seluler */
                }
        
            th, td {
                padding: 8px; /* Atur ulang padding agar sel-sel tabel lebih lega */
            }
            
            .th {
                background-color: grey; /* Biarkan warna latar belakang kepala tabel tetap abu-abu */
                color: #fff; /* Atur warna teks agar lebih kontras */
            }
        
            .tr:nth-child(even),
            .tr:nth-child(odd) {
                background-color: #f2f2f2; /* Biarkan pola warna latar belakang tetap */
            }
        
            /* Atur tampilan untuk tabel pada layar seluler */
            .h1 {
                text-align: center; /* Pusatkan judul tabel */
                color: #d98c59;
            }
            .container {
                width: 98%;
                margin: 20px auto;
                padding-top: 100px;
            }
            container td:nth-child(5) a {
                display: block;
                text-align: right;
            }
                }
                </style>
</head>
<body>
<div class="navbar">
            <div class="menu">
                <ul>
                    <li><a href="../index.html">Tasty Treats</a></li>
                    <li><a class="menu" href="menu.php">Menu</a></li>
                    <li class="in"><a href="order_detail.php">Riwayat order</a></li>
                    <li><a href="selectqr.php">Order QR</a></li>
                </ul>
            </div>
            <div class="right-corner">
            <?php
                if(isset($_SESSION['login']) && isset($_SESSION['username'])) {
                    echo '<div class="dropdown">';
                    echo '<a href="#" class="dropbtn" style="font-weight: bold; color: #fff; font-size: 20px;">' . $_SESSION['username'] . ' <i class="fa fa-caret-down"></i></a>';
                    echo '<div class="dropdown-content">';
                    echo '<a href="../logout.php">Logout</a>';
                    echo '</div>';
                    echo '</div>';
            }
            ?>
            </div>
        </div>

<div class="container">
<form action="order_detail.php" method="GET">
    <label class="cari" for="search">Cari berdasarkan nomor meja:</label><br>
    <input type="text" id="search" name="search">
    <input type="submit" value="Cari" name="cari">
</form>

    <table>
        <tr>
            <th>No</th>
            <th><a href="<?php echo generateSortingLink('tanggal', $_GET['order'] ?? 'asc', $_GET['orderBy'] ?? 'tanggal'); ?>">Tanggal<?php echo ($_GET['orderBy'] ?? 'tanggal') === 'tanggal' ? $arrow : ''; ?></a></th>
            <th>Jam</th>
            <th>Pelayan</th>
            <th><a href="<?php echo generateSortingLink('no_meja', $_GET['order'] ?? 'asc', $_GET['orderBy'] ?? 'tanggal'); ?>">No Meja<?php echo ($_GET['orderBy'] ?? 'tanggal') === 'no_meja' ? $arrow : ''; ?></a></th>
            <th>Aksi</th>
            <th>Sub Total</th>
            <th>Status</th>
            <th>Bayar</th>
        </tr>

        <?php
if (isset($_GET['cari'])) {
    $searchTerm = $_GET['search'];
    cariDataDariOrderDetail($conn, $searchTerm);
} else {
    $sql = "SELECT * FROM `order` AS o ORDER BY $orderBy $order";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $batas = 10;
        $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
        $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

        $previous = $halaman - 1;
        $next = $halaman + 1;

        $data = mysqli_query($conn, "SELECT * FROM `order`");
        $jumlah_data = mysqli_num_rows($data);
        $total_halaman = ceil($jumlah_data / $batas);

        $result = mysqli_query($conn, "SELECT * FROM `order` ORDER BY $orderBy $order LIMIT $halaman_awal, $batas");

        $no = $halaman_awal + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            // Ambil id_order
            $id_order = $row["id"];

            // Query SQL untuk menghitung total harga dari order_detil
            $totalHargaQuery = "SELECT SUM(sub_total) AS total_harga FROM order_detil WHERE id_order = $id_order";
            $totalHargaResult = mysqli_query($conn, $totalHargaQuery);
            $totalHargaRow = mysqli_fetch_assoc($totalHargaResult);
            $totalHarga = $totalHargaRow['total_harga'];

            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "<td>" . $row['jam'] . "</td>";
            echo "<td>" . $row['pelayan'] . "</td>";
            echo "<td>" . $row['no_meja'] . "</td>";
            echo "<td><a href='o_detailUorD/showpesanan.php?id=" . $row["id"] . "'>Pesanan</a>  <a href='o_detailUorD/delete.php?id=" . $row["id"] . "'>Delete</a></td>";
            echo "<td>$totalHarga</td>"; // Menampilkan total harga
            echo "<td>" . $row['status'] . "</td>";
            echo "<td><a class='process' href='process/sudah_diproses.php?id=" . $row["id"] . "'>Bayar</a></td>";
            echo "</tr>";
            $no++;
        }
    } else {
        echo "Data tidak ditemukan.";
    }
}
?>

<tr>
    <td colspan="9">
        <div class="add_menu">
            <a href="order.php">Tambah Order</a>
        </div>
    </td>
</tr>
</table>

<div class="pagination-container mt-3">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="?halaman=<?= $previous; ?>" aria-label="Previous">
                   previous
                </a>
            </li>
            <?php if (isset($total_halaman)) : ?>
                <?php for ($i = 1; $i <= $total_halaman; $i++) : ?>
                    <li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                <?php endfor; ?>
            <?php endif; ?>
            <li class="page-item">
                <a class="page-link" href="?halaman=<?= $next; ?>" aria-label="Next">
                    next
                </a>
            </li>
        </ul>
    </nav>
</div>
</body>
</html>
