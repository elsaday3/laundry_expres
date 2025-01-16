<?php
include ('db.php');
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
    <title>  Elsa Laundry </title>
    <style>
    /* Sidebar */
    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #2c3e50;
        color: #ecf0f1;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
    }

    .sidebar h2 {
        text-align: center;
        margin: 0;
        padding: 10px 0;
        font-size: 1.5rem;
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
        color: #fff;
    }

    /* Container untuk Konten */
    .container {
        margin-left: 260px; /* Memberikan jarak dari sidebar */
        padding: 20px;
        box-sizing: border-box;
    }

    /* Card Style */
    .card {
        width: 18rem;
        background-color: #fff;
        margin: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        float: left;
    }

    .card img {
        width: 100%;
        border-radius: 8px 8px 0 0;
    }

    .card-body {
        padding: 15px;
    }

    .card-text {
        font-size: 1rem;
        color: #34495e;
    }

    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    /* Tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }

    th {
        background-color: #2c3e50;
        color: #fff;
    }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Laundry Express </h2>
        <ul>
            <li class ="active"><a href="dasbor.php">🏠 Home</a></li>
            <li><a href="transaksi.php">🛒 Transaksi</a></li>
            <li><a href="pembayaran.php">📊 Pembayaran</a></li>
            <li><a href="paket.php">📦 Paket</a></li>
            <li><a href="account.php">👤 Account </a></li>
            <li class = "active"><a href="logout.php">🔒 Logout</a></li>
        </ul>
    </div>

    <!-- Konten Utama -->
    <div class="container">
        <h1>Dasbor</h1>

        <!-- Card Section -->
        <div class="clearfix">
            <div class="card">
                <img src="asset/kiloan.png" alt="Image 1">
                <div class="card-body">
                    <h5 class="card-title">Laundry Kiloan</h5>
                    <p class="card-text">Laundry kiloan adalah jasa laundry ang menghitung kuantitas pakaian berdasarkan satuan kilogram.</p>
                </div>
            </div>

            <div class="card">
                <img src="asset/antar.jpg" alt="Image 2">
                <div class="card-body">
                    <h5 class="card-title">Laundry On Demand</h5>
                    <p class="card-text">Saat Anda sudah menyiapkan pakaian kotor untuk dicuci, Anda tinggal menghubungi 
                        penyedia jasa laundry via aplikasi supaya pakaian tersebut lekas dijemput..</p>
                </div>
            </div>

            <div class="card">
                <img src="asset/servis.jpg" alt="Image 3">
                <div class="card-body">
                    <h5 class="card-title">Laundry Self Service</h5>
                    <p class="card-text">Laundry self service adalah jasa laundry yang mengharuskan Anda mengurus sendiri pakaian kotor di tempat laundry.</p>
                </div>
            </div>
            <div class="card">
                <img src="asset/setrika.jpg" alt="Image 3">
                <div class="card-body">
                    <h5 class="card-title">Cuci Dan Setrika</h5>
                    <p class="card-text">Menghilangkan Kerutan: Setrika membantu menghilangkan kerutan pada pakaian yang terbentuk selama proses pencucian dan pengeringan..</p>
                </div>
            </div>
            <div class="card">
                <img src="asset/cuci kering.jpg" alt="Image 3">
                <div class="card-body">
                    <h5 class="card-title">Dry Cleaning</h5>
                    <p class="card-text">Dry cleaning (cuci kering) adalah metode pencucian tanpa menggunakan air sama sekali.</p>
                </div>
            </div>
        </div>

        <!-- Tabel Data Transaksi -->
        <h2>Data Transaksi</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>ID User</th>
                    <th>Total Harga</th>
                    <th>Tanggal Transaksi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>101</td>
                    <td>Rp. 50,000</td>
                    <td>2024-12-10</td>
                    <td>Selesai</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>102</td>
                    <td>Rp. 75,000</td>
                    <td>2024-12-11</td>
                    <td>Proses</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>103</td>
                    <td>Rp. 120,000</td>
                    <td>2024-12-12</td>
                    <td>Selesai</td>
                </tr>
            </tbody>
        </table>

    </div>

</body>
</html>
