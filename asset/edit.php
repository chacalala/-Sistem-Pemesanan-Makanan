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
        margin: 0;
        padding: 0;
        color: white; /* Teks menjadi putih */
    }
    form {
        width: 50%; /* Lebarkan form agar lebih lebar */
        margin: 100px auto 0;
        padding: 30px;
        border-radius: 10px;
        color: #333;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        background-color: rgba(255, 255, 255, 0.9); /* Ubah latar belakang form */
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }
    label {
        font-weight: bold;
        color: #333;
    }
    select,
    input[type="text"],
    input[type="submit"],
    input[type="reset"] {
        width: 100%;
        padding: 10px; /* Sedikit kurangi padding untuk membuat tombol lebih kecil */
        margin-top: 2px;
        margin-bottom: 12px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-family: 'Courier New', Courier, monospace;
        color: #333; /* Warna teks menjadi hitam agar terlihat lebih jelas */
    }
    select,
    input[type="text"] {
        background-color: #f2f2f2;
        border: 2px solid #ccc;
    }
    input[type="submit"],
    input[type="reset"] {
        cursor: pointer;
        background-color: grey;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* Ubah bayangan tombol */
        color: white;
        transition: background-color 0.3s;
        font-weight: bold; /* Tambahkan tebal pada tombol */
    }
    input[type="submit"]:hover,
    input[type="reset"]:hover {
        background-color: #555; /* Warna hover sedikit lebih gelap */
    }
    p {
        text-align: center;
        color: #333;
        font-weight: bold;
    }
    @media (max-width: 425px) {
        form {
            width: 90%; 
            padding: 20px;
        }
    }
</style>
</head>
<body>
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
        <input type="submit" value="Batal" onclick="window.location.href = 'menu.php'">
    </form>
</body>
</html>