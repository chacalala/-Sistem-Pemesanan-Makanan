<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-image: url('image/banner-background-image.jpg');
            background-size: cover; 
            background-attachment: fixed;
            margin: 0; 
            overflow-x: hidden;
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
        }

        .menu ul {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .menu li {
            display: inline-block;
            margin-left: 20px;
        }
        .menu .in a {
            background-color: grey;
            border-radius: 5px;
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

        .content {
            color: black;
            text-align: left;
            font-size: 20px;
            width: 100%;
            margin-top: 50px;
        }
        .content a {
            color: #EEEEEE;
            font-weight: bold;
            font-size: 25px;
        }
        .content a:hover {
            color: #d98c59;
        }
        .image {
            display: flex;
            flex-wrap: wrap; /
            justify-content: flex-start;
            overflow-x: auto;
            white-space: nowrap;
            /* height: 80vh; */
        }

        figure {
            width: 20%; 
            margin: 10px;
            box-sizing: border-box;
            margin-left: 70px;
            margin-top: 100px;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 30px;
            border-radius: 10px;
        }

        img {
            width: 100%;
        }

        figure:last-child {
            margin-right: 0;
        }

        figcaption {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 10px;
            border-radius: 5px;
            margin-top: 50px;
            text-align: center;
            font-size: 25px;
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
            .content {
                width: 98%;
                padding: 0;
                left: 0;
                top: 25%;
            }
             .image {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start;
                overflow-x: auto;
                white-space: nowrap;
                padding: 10px; /* Tambahkan padding untuk memperbaiki tampilan di perangkat seluler */
                padding-top : 100px;
            }

            figure {
                width: 45%; /* Sesuaikan lebar gambar */
                margin: 5px; /* Sesuaikan margin */
                background-color: rgba(255, 255, 255, 0.5);
                padding: 10px;
                border-radius: 10px;
                text-align: center; /* Pusatkan teks caption */
            }
        
            img {
                width: 100%;
                max-width: 100%; /* Agar gambar tidak melebihi lebar layar */
                border-radius: 5px; /* Tambahkan sudut bulat pada gambar */
            }
        
            figcaption {
                font-size: 14px; /* Atur ukuran teks caption */
                margin-top: 10px; /* Atur margin atas caption */
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="menu">
            <ul>
                <li ><a href="../index.html">Tasty Treats</a></li>
                <li><a class="menu" href="menu.php">Menu</a></li>
                <li><a href="order_detail.php">Riwayat order</a></li>
                <li class="in"><a href="selectqr.php">Order QR</a></li>
            </ul>
        </div>
    </div>
    <div class="content">
        <div class="image">
            <figure>
                <img src="image/qrCode/QRno_meja1.png" alt="QR Code 1" class="qr-code">
                 <figcaption>Meja Nomor 1</figcaption>
            </figure>
            <figure>
                <img src="image/qrCode/QRno_meja2.png" alt="QR Code 2" class="qr-code">
                <figcaption>Meja Nomor 2</figcaption>
            </figure>
            <figure>
                <img src="image/qrCode/QRno_meja3.png" alt="QR Code 3" class="qr-code">
                <figcaption>Meja Nomor 3</figcaption>
            </figure>
            <figure>
                <img src="image/qrCode/QRno_meja4.png" alt="QR Code 4" class="qr-code">
                <figcaption>Meja Nomor 4</figcaption>
            </figure>
            <figure>
                <img src="image/qrCode/QRno_meja5.png" alt="QR Code 5" class="qr-code">
                <figcaption>Meja Nomor 5</figcaption>
            </figure>
        </div>
    </div>
</body>
</html>