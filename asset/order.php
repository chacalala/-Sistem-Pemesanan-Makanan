<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $tanggal = $_POST["tanggal"];
    $jam = $_POST["jam"];
    $pelayan = $_POST["pelayan"];
    $no_meja = $_POST["no_meja"];

    // Buat koneksi ke database
    include("connection.php");  

    // Masukkan data ke dalam tabel order
    $sql = "INSERT INTO `order` (tanggal, jam, pelayan, no_meja) VALUES ('$tanggal', '$jam', '$pelayan', '$no_meja')";

    if (mysqli_query($conn, $sql)) {
        $id = mysqli_insert_id($conn);
        header("Location: insert_order_detail.php?id=" . $id);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
$_SESSION['username'] = "KASIR"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Order</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-image: url('image/banner-background-image.jpg');
            background-size: cover; 
            background-attachment: fixed;
            margin: 0;
            padding: 0;
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
        .form-container {
            color: #DBD8ED;
            width: 40%;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="date"],
        input[type="time"],
        input[type="text"],
        select {
            width: calc(100% - 12px);
            padding: 8px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            color: black;
            padding: 10px;
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
        @media (max-width: 425px) {
            .form-container {
                width: 80%;
                padding: 10px;
                padding-top: 110px;
            }
            input[type="date"],
            input[type="time"],
            input[type="text"],
            select {
                width: calc(100% - 10px);
                padding: 6px;
            }
            input[type="submit"] {
                padding: 8px;
            }
            .menu li {
                display: block;
                margin: 10px 0;
            }
            .body {
                background-attachment: scroll;
                background-size: contain;
            }
            .content {
                width: 98%;
                padding: 0;
                left: 0;
                top: 25%;
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
    <div class="form-container">
        <h2>Order Form</h2>
        <form action="" method="post">
            <!-- Your PHP form processing code here -->
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="jam">Jam:</label>
                <input type="time" name="jam" required>
            </div>
            <div class="form-group">
                <label for="pelayan">Pelayan:</label>
                <input type="text" name="pelayan" required>
            </div>
            <div class="form-group">
                <label for="no_meja">No Meja:</label>
                <select id="no_meja" name="no_meja">
                    <option value="-">-- Pilih No Meja --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit Order">
            </div>
        </form>
    </div>
</body>
</html>