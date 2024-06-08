<?php
session_start(); // Mulai sesi (pastikan diinisialisasi di setiap halaman yang diperlukan)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi waktu sebelum pemrosesan pesanan
    if (isset($_SESSION['lastOrderTime'])) {
        $lastOrderTime = $_SESSION['lastOrderTime'];
        $currentTime = time();

        if (($currentTime - $lastOrderTime) < (10 * 60)) {
            echo "<script>
                alert('Anda harus menunggu minimal 10 menit sebelum memesan kembali.');
                history.go(-1);
            </script>";
            exit();
        }
    }
    // Koneksi ke database
    include("connection.php");

    // Ambil ID pesanan terakhir
    $sql = "SELECT id FROM `order` ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id_order = $row['id'];

        $menu = $_POST["menu"];
        $jumlah = $_POST["jumlah"];

        // Ambil harga menu dari tabel foods_menu
        $menu = mysqli_real_escape_string($conn, $menu);
        $sql = "SELECT harga_makanan, stock FROM foods_menu WHERE nama_makanan = '$menu'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $harga = $row['harga_makanan'];
            $stok = $row['stock'];

            if ($stok >= $jumlah) { // Pastikan stok cukup untuk pesanan
                $sub_total = $jumlah * $harga;

                // Kurangi stok di database
                $new_stock = $stok - $jumlah;
                $update_stock_query = "UPDATE foods_menu SET stock = $new_stock WHERE nama_makanan = '$menu'";
                if (mysqli_query($conn, $update_stock_query)) {
                    // Masukkan data ke dalam tabel order_detil
                    $sql = "INSERT INTO order_detil (id_order, nama_menu, jumlah, sub_total) VALUES ($id_order, '$menu', $jumlah, $sub_total)";

                    if (mysqli_query($conn, $sql)) {
                        echo "<p>TERIMA KASIH TELAH ORDER</p>";
                        echo "<meta http-equiv=refresh content=1;URL='insert_order_detail.php?id=$id_order'>";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                } else {
                    echo "Error updating stock: " . mysqli_error($conn);
                }
            } else {
                echo "Stok tidak mencukupi untuk pesanan ini.";
            }
        } else {
            echo "Menu tidak ditemukan.";
        }
    } else {
        echo "ID pesanan tidak ditemukan.";
    }

    mysqli_close($conn);

    $_SESSION['lastOrderTime'] = time();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-image: url('image/banner-background-image.jpg');
            background-size: cover; 
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between; 
            align-items: center;
            overflow: hidden;
            margin-top: 10px;
            margin-right: 20px;
        }
        .navbar-left a {
            color: #DBD8ED;
            font-weight: bold;
            font-size: 30px;
            float: left;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar-left a:hover {
            color: #d98c59;
        }
        .navbar-right a {
            color: #DBD8ED;
            float: left;
            display: block;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            margin-right: 10px;
            margin-left: 10px;
        }
        .navbar-right a:hover {
            font-weight: bold;
            color: #d98c59;
        }
        .form-container {
            color: #DBD8ED;
            width: 20%;
            height: 350px;
            margin: 20px auto 0;
            padding: 5px 16px 0 16px;
            border-radius: 10px;
        }
        select {
            padding: 5px;
            border: 2px solid #ccc;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            margin: 10px 0;
        }
        input {
            font-family: 'Courier New', Courier, monospace;
            padding: 5px;
            border: 2px solid #ccc;
            border-radius: 5px;
            width: 96%;
            font-size: 16px;
            margin: 10px 0;
        }
        input[type="submit"] {
            width: 100%;
        }
        input[type="submit"] {
            width: 100%;
            background-color: grey;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            padding: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            color: #d98c59;
            background-color: #DBD8ED;
        }
        .back {
            width: 100%;
            background-color: grey;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            padding: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            text-decoration: none;
        }
        .back:hover {
            color: #d98c59;
            background-color: #DBD8ED;
        }
        p {
            text-align: center;
            color: #DBD8ED;
        }
        @media (max-width: 425px) {
            .navbar {
                width: 100%;
            }
            .navbar-right a {
                float: right;
            }
            .form-container {
                width: 95%; 
                padding: 5px 0px 0 10px;
            }
            input {
                width: 94%;
            }
            select {
                width: 97%;
            }
            input[type="submit"] {
                width: 97%;
            }
            select {
                width: 97%;
            }
        }
    </style>
    <script>
        function setCookie(name, value, minutes) {
            var expires = "";
            if (minutes) {
                var date = new Date();
                date.setTime(date.getTime() + (minutes * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                while (cookie.charAt(0) === ' ') {
                    cookie = cookie.substring(1, cookie.length);
                }
                if (cookie.indexOf(nameEQ) === 0) {
                    return cookie.substring(nameEQ.length, cookie.length);
                }
            }
            return null;
        }

        function enableOrder() {
            setCookie('orderPlaced', 'true', 10); // Set cookie 'orderPlaced' to true with 10 minutes expiry
            setCookie('lastOrderTime', new Date().getTime(), 10); // Set cookie 'lastOrderTime' to current time
        }

        window.onload = function () {
            var lastOrderTime = getCookie('lastOrderTime');
            var currentTime = new Date().getTime();

            if (lastOrderTime) {
                var timeDiff = currentTime - lastOrderTime;
                var minutesPassed = Math.floor((timeDiff / 1000) / 60);

                if (minutesPassed < 10) {
                    setTimeout(function() {
                        alert("Anda harus menunggu minimal 10 menit sebelum memesan kembali.");
                    }, (10 - minutesPassed) * 60 * 1000);
                } else {
                    enableOrder();
                }
            } else {
                enableOrder();
            }
        };
    </script>
</head>
<body>
    <?php 
    if (isset($_GET['id'])) {
        $orderId = $_GET['id'];
    } 
    ?>
    <div class="form-container">
        <form action="" method="post">
            <label for="menu">Pilih Menu:</label>
            <select name="menu" required>
                <option value="">-- Pilih Menu --</option>
                <?php 
                // Buat koneksi ke database
                include("connection.php");

                // Ambil data menu dari tabel foods_menu
                $sql = "SELECT nama_makanan, harga_makanan FROM foods_menu";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Tambahkan harga makanan ke dalam teks opsi
                        $menuOption = $row['nama_makanan'] . " - Rp " . $row['harga_makanan'];
                        echo "<option value='" . $row['nama_makanan'] . "'>" . $menuOption . "</option>";
                    }
                }

                mysqli_close($conn);
                ?>
            </select>
            <label for="jumlah">Jumlah Makanan:</label>
            <input type="number" name="jumlah" required>

            <input type="submit" value="Tambah Order Detil">
            <a class="back" href='o_detailUorD/showpesanan.php?id=<?php echo $orderId; ?>'>Lihat Pesanan</a>
            <a class="back" href="../index.html">Kembali</a>
        </form>
    </div>
</body>
</html>