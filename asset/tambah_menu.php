<?php
    // Buat koneksi ke database
    include("connection.php");

    // Tangkap data dari formulir HTML
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['jenis_makanan']) && isset($_POST['nama_makanan']) && isset($_POST['harga_makanan']) && isset($_POST['stock'])) {
            $jenis_makanan = $_POST['jenis_makanan'];
            $nama_makanan = $_POST['nama_makanan'];
            $harga_makanan = $_POST['harga_makanan'];
            $stock = $_POST['stock'];

            // Fungsi untuk generate ID makanan
            function generateRandomID($conn) {
                // Ambil ID terakhir dari database
                $sql = "SELECT id FROM foods_menu ORDER BY id DESC LIMIT 1";
                $result = $conn->query($sql);
            
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $last_id = $row['id'];
                    // Konversi ID terakhir ke angka, tambahkan 1, dan format sebagai ID baru
                    $next_id = str_pad((intval($last_id) + 1), 3, '0', STR_PAD_LEFT);
                } else {
                    // Jika belum ada data dalam database, mulai dengan ID 001
                    $next_id = '001';
                }
            
                return $next_id;
            }

            // Generate ID makanan
            $id_makanan = generateRandomID($conn);

            // Langkah 4: Masukkan data ke dalam database
            $sql = "INSERT INTO foods_menu (id, jenis_makanan, nama_makanan, harga_makanan, stock) VALUES ('$id_makanan', '$jenis_makanan', '$nama_makanan', '$harga_makanan', '$stock')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Data berhasil disimpan.</p>";
                echo "<meta http-equiv=refresh content=1;URL='tambah_menu.php'>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<p>Data yang diperlukan belum diisi.</p>";
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
    <title>AddMenu</title>
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
        <h2>Edit Menu Form</h2>
        <label for="jenis_makanan">Jenis Makanan :</label> <br>
        <select id="jenis_makanan" name="jenis_makanan">
            <option value="Makanan">Makanan</option>
            <option value="Minuman">Minuman</option>
        </select> <br>

        <label for="nama_makanan">Nama Makanan :</label> <br>
        <input type="text" name="nama_makanan" required> <br>

        <label for="harga_makanan">Harga Makanan :</label> <br>
        <input type="text" name="harga_makanan" required> <br>

        <input type="submit" value="Simpan" name="proses"><span>
        <input type="submit" value="Batal" onclick="window.location.href = 'menu.php'">
    </form>
</body>
</html>