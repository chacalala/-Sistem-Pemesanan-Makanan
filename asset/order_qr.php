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
    $sql = "INSERT INTO `order` (tanggal, jam, pelayan, no_meja) VALUES ('$tanggal', '$jam', '$pelayan', $no_meja)";

    if (mysqli_query($conn, $sql)) {
        $id = mysqli_insert_id($conn);
        header("Location: insert_order_detail.php?id=" . $id);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
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
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }
        .form-container {
            color: #DBD8ED;
            width: 20%;
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
            .body {
                background-attachment: scroll;
                background-size: contain;
                background-repeat: no-repeat; /* Hentikan pengulangan gambar latar belakang */

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
</head>
<body>
    <div class="form-container">
        <h2>Order Form</h2>
        <?php 
            if (isset($_GET['no_meja'])){
                $no_meja = $_GET['no_meja'];
            } else {
                $no_meja = '';
            }
        ?>
        <form action="" method="post" id="orderForm">
            <input type="hidden" name="order_id" value="<?php echo $id; ?>">

            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" id="tanggal" required>
            
            <label for="jam">Jam:</label>
            <input type="time" name="jam" id="jam" required>
            
            <label for="pelayan">Pelayan :</label>
            <input type="text" name="pelayan" required>

            <label for="no_meja">No Meja : <?php echo $no_meja;?></label>
            <input type="hidden" name="no_meja" value="<?php echo $no_meja;?>" required>

            <input type="submit" value="Submit Order">
        </form>
    </div>
</body>
</html>
<script>
    var inputTanggal = document.getElementById('tanggal');
    var inputJam = document.getElementById('jam');

    var now = new Date();

    // Mendapatkan tanggal dengan format YYYY-MM-DD
    var year = now.getFullYear();
    var month = (now.getMonth() + 1).toString().padStart(2, '0'); 
    var day = now.getDate().toString().padStart(2, '0'); 

    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');

    inputTanggal.value = year + '-' + month + '-' + day;
    inputJam.value = hours + ':' + minutes;
</script>
