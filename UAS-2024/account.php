<?php 
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #2c3e50;
    color: #ecf0f1;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 20px;
    z-index: 100; 
}

.container {
    margin-left: 250px; 
    padding: 20px;
    width: calc(100% - 250px); 
    box-sizing: border-box; 
}


.sidebar h2 {
    text-align: center;
    margin: 0;
    padding: 10px 0;
    background: #34495e;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    padding: 15px;
}

.sidebar ul li a {
    text-decoration: none;
    color: #ecf0f1;
    display: block;
}

.sidebar ul li a:hover, .sidebar ul li a.active {
    background: #1abc9c;
}

/* Container */
.container {
    margin-left: 260px;
    padding: 20px;
color: #fff;
}
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .profile-header h1 {
            font-size: 2rem;
            color: #2c3e50;
        }
        .profile-header p {
            font-size: 1.1rem;
            color: #7f8c8d;
        }
        .profile-info {
            margin-top: 20px;
        }
        .profile-info h2 {
            font-size: 1.5rem;
            color: #34495e;
        }
        .profile-info p {
            font-size: 1rem;
            color: #7f8c8d;
            line-height: 1.6;
        }
        .services {
            margin-top: 20px;
        }
        .services ul {
            list-style: none;
            padding: 0;
        }
        .services ul li {
            font-size: 1.1rem;
            color: #34495e;
            margin-bottom: 10px;
        }
</style>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2> Elsaday Laundry</h2>
        <ul>
            <li><a href="dasbor.php">🏠 Home</a></li>
            <li><a href="transaksi.php">🛒 Transaksi</a></li>
            <li><a href="pembayaran.php">📊 Pembayaran</a></li>
            <li><a href="paket.php">📦 Paket</a></li>
            <li class="active"><a href="account.php">👤 Account</a></li>
            <li><a href="logout.php">🔒 Logout</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="profile-header">
            <!-- Ganti link dengan foto profile bisnis laundry Anda -->
            <img src="asset/laundry.jpg" alt="Laundry Profile Photo">
            <div>
                <h1> Elsaday Laundry </h1>
                <p>Admin      : Elsaday Simanjuntak </p>
                <p>Email      : elsadayjuntak3@gmail.com</p>
                <p>Nomor Hp   : 098765432 </p>

            </div>
        </div>

        <div class="profile-info">
            <h2>Tentang Kami</h2>
            <p> Laundry adalah layanan laundry profesional yang didirikan dengan tujuan untuk memberikan kenyamanan dan kemudahan bagi pelanggan dalam merawat pakaian mereka. Kami mengutamakan kualitas dan kepuasan pelanggan dengan menggunakan bahan pencuci terbaik dan
            peralatan modern untuk memastikan pakaian Anda tetap terjaga keindahan dan kebersihannya</p>
        </div>

        <div class="services">
            <h2>Layanan Kami</h2>
            <ul>
                <li>🍃 Laundry Kiloan (Cuci, Kering, Lipat)</li>
                <li>👗 Pembersihan Pakaian Premium (Dry Clean)</li>
                <li>🧴 Perawatan Pakaian Khusus (Cuci Sepatu, Tas, dll.)</li>
                <li>⏰ Layanan Ekspres (Cuci dalam 3 Jam)</li>
                <li>🚚 Antar Jemput Gratis</li>
            </ul>
        </div>
    </div>

</body>
</html>
