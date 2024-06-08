<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-image: url('image/banner-background-image.jpg');
            background-size: cover; 
        }
        /* Navbar Styling */
        .navbar {
            background-color: #212121;
            padding: 15px 0;
        }

        .menu {
            text-align: right;
        }

        .menu ul {
            padding: 0;
            margin: 0;
        }

        .menu li {
            display: inline;
            margin-left: 20px;
        }
        .menu a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: color 0.3s;
            padding: 8px 16px;
            border-radius: 5px;
        }

        .menu .in a {
            color: white;
            border-radius: 5px;
        }

        .menu a:hover {
            color: white;
            background-color: #3f3f3f;
        }
        form {
            width: 20%; 
            margin: 100px auto 0;
            padding: 20px;
            background-color: rgba(242, 242, 242, 0.3);
            border-radius: 10px;
            color: #DBD8ED;
        }
        select {
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            background-color: #f2f2f2;
            color: #333;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }
        input[type="text"] {
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            width: 94%;
            font-size: 16px;
            background-color: #f2f2f2;
            color: #333;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }
        input[type="submit"] {
            font-family: 'Courier New', Courier, monospace;
            background-color: #d98c59;
            color: #DBD8ED;
            padding: 10px 20px;
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
        input[type="reset"] {
            font-family: 'Courier New', Courier, monospace;
            background-color: #d98c59;
            color: #DBD8ED;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        input[type="reset"]:hover {
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
            form {
                width: 100%; 
                margin-right: 100px;
                padding: 5px 0px 0 10px;
            }
            input[type="text"]  {
                width: 89%;
            }
            select {
                width: 95%;
            }
            input[type="submit"] {
                width: 30%;
            }
            form {
                width: 97%;
                padding-bottom: 20px;
            }
        }
    </style>
</head>
<body>
<div class="navbar">
        <div class="menu">
            <ul>
                <li class="in"><a href="../index.html">Home</a></li>
                <li class="in"><a href="menu.php">Menu</a></li>
                <li><a href="order.php">Order</a></li>
                <li><a href="order_detail.php">Riwayat Order</a></li>
            </ul>
        </div>
    </div>
    <form action="" method="post">
        <h2>Edit Form</h2>
        <?php
        // Buat koneksi ke database
        include("connection.php");

        // Ambil data dari database sesuai ID yang akan diedit
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $sql = "SELECT * FROM foods_menu WHERE id = '$id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                echo '<label for="jenis_makanan">Jenis Makanan</label> <br>';
                echo '<select id="jenis_makanan" name="jenis_makanan">';
                echo '<option value="Makanan" ' . ($row["jenis_makanan"] == "Makanan" ? 'selected' : '') . '>Makanan</option>';
                echo '<option value="Minuman" ' . ($row["jenis_makanan"] == "Minuman" ? 'selected' : '') . '>Minuman</option>';
                echo '</select> <br>';
                echo '<label for="nama_makanan">Nama Makanan</label> <br>';
                echo '<input type="text" name="nama_makanan" value="' . $row["nama_makanan"] . '" required> <br>';
                echo '<label for="harga_makanan">Harga Makanan</label> <br>';
                echo '<input type="text" name="harga_makanan" value="' . $row["harga_makanan"] . '" required> <br>';
            }
        }
        ?>

        <input type="submit" value="Update">
        <input type="reset" value="Reset">
    </form>
</body>
</html>
<?php
// Buat koneksi ke database
include("connection.php");

// Tangkap data dari formulir HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $jenis_makanan = $_POST['jenis_makanan'];
    $nama_makanan = $_POST['nama_makanan'];
    $harga_makanan = $_POST['harga_makanan'];

    // Perbarui data di database
    $sql = "UPDATE foods_menu SET jenis_makanan = '$jenis_makanan', nama_makanan = '$nama_makanan', harga_makanan = '$harga_makanan' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Data berhasil diperbarui.</p>";
        echo "<meta http-equiv=refresh content=1;URL='menu.php'>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi ke database
$conn->close();
?>