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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-image: url('image/banner-background-image.jpg');
            background-size: cover; 
            background-attachment: fixed;
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
        @media (max-width: 425px) {
             .body {
                background-attachment: scroll;
                background-size: contain;
            }
            .menu li {
                display: block;
                margin: 10px 0;
            }
            h1 {
                text-align: center;
                font-size: 24px;
                margin-left: 10px;
            }
            table {
                width: 100%;
                margin: 0 auto;
                border-collapse: collapse;
                font-size: 8px;
             
            }
            th,
            td {
                border: 1px solid #ccc;
                padding: 5px;
                text-align: center;
            
            }
            .wrapper{
                padding-top: 170px;
            
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
            <div class="menu">
                <ul>
                    <li><a href="../index.html">Tasty Treats</a></li>
                    <li class="in"><a class="menu" href="menu.php">Menu</a></li>
                    <li><a href="order_detail.php">Riwayat order</a></li>
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
    <div class="wrapper">
    <table>
    <tr>
    <div style="text-align: left; margin-bottom: 20px;">
            <a href="tambah_menu.php" style="padding: 10px 20px; font-weight: bold; font-size: 16px; border-radius: 5px; background-color: #3f3f3f; color: white; border: none; cursor: pointer; margin-bottom: 20px;">Tambah Menu</a>
        </div>
            <th>Nomor</th>
            <th>Jenis Makanan</th>
            <th id="nama" onclick="toggleSort('nama')">Nama Makanan <i id="sort-icon-nama" class="fa"></i></th>
            <th id="harga" onclick="toggleSort('harga')">Harga Makanan <i id="sort-icon-harga" class="fa"></i></th>
            <th>Stock</th>
            <th>Edit or Delete</th>
        </tr>
        <?php
        // Buat koneksi ke database
        include("connection.php");

        // Ambil data dari database
        $sql = "SELECT * FROM foods_menu"; 
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $nomor = 1;
            // Loop melalui hasil query dan tampilkan data dalam tabel
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $nomor . "</td>";
                // echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["jenis_makanan"] . "</td>";
                echo "<td>" . $row["nama_makanan"] . "</td>";
                echo "<td>" . $row["harga_makanan"] . "</td>";
                echo "<td>" . $row["stock"] . "</td>";
                echo "<td><a href='edit.php?id=" . $row["id"] . "'>Edit</a>  <a href='delete.php?id=" . $row["id"] . "'>Delete</a></td>";
                echo "</tr>";
                $nomor++;
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada data yang ditemukan.</td></tr>";
        }

        // Tutup koneksi ke database
        $conn->close();
        ?>
    </table>
    </div>
    <script>
    var sortingOrder = 'asc'; // Initial sorting order
    var currentSortColumn = ''; // Current sort column

    function toggleSort(column) {
        var table = document.querySelector('table');
        var rows = Array.from(table.rows).slice(1);

        rows.sort(function(a, b) {
            var textA = a.cells[2].textContent;
            var textB = b.cells[2].textContent;

            if (column === 'harga') {
                var hargaA = parseFloat(a.cells[3].textContent);
                var hargaB = parseFloat(b.cells[3].textContent);
                var comparison = sortingOrder === 'asc' ? hargaA - hargaB : hargaB - hargaA;

                if (comparison === 0) {
                    comparison = textA.localeCompare(textB);
                }

                currentSortColumn = column;
                return comparison;
            } else if (column === 'nama') {
                currentSortColumn = column;
                return sortingOrder === 'asc' ? textA.localeCompare(textB) : textB.localeCompare(textA);
            }
        });

        while (table.rows.length > 1) {
            table.deleteRow(1);
        }

        rows.forEach(function(row) {
            table.appendChild(row);
        });

        var sortIconHarga = document.getElementById('sort-icon-harga');
        var sortIconNama = document.getElementById('sort-icon-nama');

        sortIconHarga.className = column === 'harga' ? `fa fa-sort-${sortingOrder}` : '';
        sortIconNama.className = column === 'nama' ? `fa fa-sort-${sortingOrder}` : '';

        sortingOrder = sortingOrder === 'asc' ? 'desc' : 'asc';
    }
</script>
</body>
</html>