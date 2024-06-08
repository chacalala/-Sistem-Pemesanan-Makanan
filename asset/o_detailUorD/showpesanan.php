<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            background-image: url('../image/banner-background-image.jpg');
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            padding: 20px; /* Adding padding for better spacing */
        }
        .container {
            max-width: 100%; /* Adjusted width for larger screens */
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.8); /* Adding a semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Adding a subtle shadow */
        }
        select {
            padding: 5px;
            border: 2px solid #ccc;
            border-radius: 5px;
            width: 50%;
            font-size: 13px;
            background-color: #f2f2f2;
            color: #333;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }
        input[type="number"], input[type="submit"] {
            padding: 5px;
            border: 2px solid #ccc;
            border-radius: 5px;
            width: 48%;
            font-size: 10px;
            background-color: #f2f2f2;
            color: #333;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            color: #d98c59;
            background-color: #DBD8ED;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px; /* Adding some bottom margin for spacing */
            border-radius: 5px;
            overflow: hidden; /* To hide overflow content */
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
            .menu li {
                display: block;
                margin: 10px 0;
            }
            .body {
                background-attachment: scroll;
                background-size: contain;
            }
            table {
                font-size: 10px;
                margin: 0px;
                border-collapse: collapse;
               
            }
            th, td {
                border: 1px solid #ccc;
                padding: 6px;
                text-align: center;
            }
            .container {
                width: 100%;
                margin: 20px auto;
                padding: 10px;
            }

        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <tr>
                <th colspan="6">MENU ANDA</th>
            </tr>
            <tr>
                <th>ID</th>
                <th>Nama Menu</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>

            <?php
            // Buat koneksi ke database
            include("../connection.php");

            // Periksa apakah ada parameter ID yang diterima
            if (isset($_GET['id'])) {
                $id_order = $_GET['id'];

                // Ambil data dari tabel order_detail berdasarkan id_order
                $sql = "SELECT id, nama_menu, jumlah, sub_total FROM `order_detil` WHERE id_order = $id_order";
                $result = mysqli_query($conn, $sql);

                $totalSubTotal = 0;

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nama_menu'] . "</td>";
                        echo "<td>" . $row['jumlah'] . "</td>";
                        echo "<td>" . $row['sub_total'] . "</td>";
                        echo "<td><a href='del_pesanan.php?id={$row['id']}&id_order=$id_order'>Delete</a></td>";
                        echo "</tr>";

                        // Tambahkan nilai sub_total ke totalSubTotal
                        $totalSubTotal += $row['sub_total'];
                    }
                } 
            }
            echo "<tr>";
            echo "<td colspan='6' style='text-align: right;'>Total : $totalSubTotal</td>";
            echo "</tr>";

            mysqli_close($conn);
            ?>
            <tr>
                <td colspan="5">
                    <div class="add_menu">
                        <form action="" method="post">
                            <table>
                                <tr>
                                    <th colspan="2">
                                        <h2>Tambah Menu</h2>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="menu">Pilih Menu:</label>
                                    </td>
                                    <td>
                                        <select name="menu" id="menu">
                                            <?php
                                            // Buat koneksi ke database
                                            include("../connection.php");

                                            // Ambil data dari tabel foods_menu
                                            $sql = "SELECT id, nama_makanan FROM `foods_menu`";
                                            $result = mysqli_query($conn, $sql);

                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $row['id'] . "'>" . $row['nama_makanan'] . "</option>";
                                                }
                                            }
                                            mysqli_close($conn);
                                            ?>
                                        </select>
                                    </td>
                                    <tr>
                                        <td>
                                            <label for="jumlah">Jumlah:</label>
                                        </td>
                                        <td>
                                            <input type="number" name="jumlah" id="jumlah" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="hidden" name="id_order" value="<?php echo $id_order; ?>"><br>
                                            <input type="submit" value="tambah">
                                        </td>
                                    </tr>
                                </tr>
                            </table>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <?php
// Pastikan Anda memiliki koneksi ke database
include("../connection.php");

// Periksa apakah data yang dibutuhkan sudah ada dalam $_POST
if (isset($_POST['menu']) && isset($_POST['jumlah']) && isset($_POST['id_order'])) {
    // Ambil data dari formulir
    $menuId = $_POST['menu'];
    $jumlah = $_POST['jumlah'];
    $idOrder = $_POST['id_order'];

    // Query SQL untuk mengambil nama_menu, harga, dan stok dari tabel foods_menu
    $menuQuery = "SELECT nama_makanan, harga_makanan, stock FROM `foods_menu` WHERE id = $menuId";
    $menuResult = mysqli_query($conn, $menuQuery);

    if ($menuResult && mysqli_num_rows($menuResult) > 0) {
        $menuData = mysqli_fetch_assoc($menuResult);
        $namaMenu = $menuData['nama_makanan'];
        $harga = $menuData['harga_makanan'];
        $stok = $menuData['stock'];

        // Pastikan stok cukup untuk pesanan
        if ($stok >= $jumlah) {
            // Hitung subtotal
            $subTotal = $harga * $jumlah;

            // Kurangi stok di database
            $newStock = $stok - $jumlah;
            $updateStockQuery = "UPDATE `foods_menu` SET stock = $newStock WHERE id = $menuId";

            if (mysqli_query($conn, $updateStockQuery)) {
                // Query SQL untuk menyimpan data pesanan ke dalam tabel order_detil
                $insertQuery = "INSERT INTO `order_detil` (id_order, nama_menu, jumlah, sub_total) VALUES ($idOrder, '$namaMenu', $jumlah, $subTotal)";

                if (mysqli_query($conn, $insertQuery)) {
                    // Pesanan berhasil ditambahkan
                    echo "Pesanan berhasil ditambahkan!";
                    echo "<meta http-equiv=refresh content=1>";
                } else {
                    // Kesalahan saat menyimpan pesanan
                    echo "Gagal menyimpan pesanan: " . mysqli_error($conn);
                }
            } else {
                // Kesalahan saat mengurangi stok
                echo "Gagal mengurangi stok: " . mysqli_error($conn);
            }
        } else {
            // Stok tidak mencukupi untuk pesanan
            echo "Stok tidak mencukupi untuk pesanan ini.";
        }
    } else {
        // Kesalahan dalam mengambil data menu
        echo "Gagal mengambil informasi menu.";
    }
} 

// Tutup koneksi ke database
mysqli_close($conn);
?>

</body>
</html>