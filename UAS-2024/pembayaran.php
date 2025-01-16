<?php
include ('db.php'); 
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Proses Tambah Data
if (isset($_POST['submit'])) {
    $ID_USER = $_POST['ID_USER'];
    $ID_TRANSAKSI = $_POST['ID_TRANSAKSI'];
    $METODE_BAYAR = $_POST['METODE_BAYAR'];
    $JUMLAH_BAYAR = $_POST['JUMLAH_BAYAR'];
    $STATUS_BAYAR = $_POST['STATUS_BAYAR'];
    $TANGGAL_BAYAR = $_POST['TANGGAL_BAYAR'];

    // Cek apakah User dengan ID_USER ada
    $checkUserQuery = "SELECT * FROM user WHERE ID_USER = '$ID_USER'";
    $checkUserResult = $conn->query($checkUserQuery);

    if ($checkUserResult->num_rows > 0) {
        // Cek apakah Transaksi dengan ID_TRANSAKSI ada
        $checkTransaksiQuery = "SELECT * FROM transaksi WHERE ID_TRANSAKSI = '$ID_TRANSAKSI'";
        $checkTransaksiResult = $conn->query($checkTransaksiQuery);

        if ($checkTransaksiResult->num_rows > 0) {
            // User dan Transaksi ada, lanjutkan memasukkan pembayaran
            $sql = "INSERT INTO pembayaran (ID_USER, ID_TRANSAKSI, METODE_BAYAR, JUMLAH_BAYAR, STATUS_BAYAR, TANGGAL_BAYAR) 
                    VALUES ('$ID_USER', '$ID_TRANSAKSI', '$METODE_BAYAR', '$JUMLAH_BAYAR', '$STATUS_BAYAR', '$TANGGAL_BAYAR')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data pembayaran berhasil ditambahkan!');</script>";
                header("Refresh:0");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('Transaksi dengan ID $ID_TRANSAKSI tidak ditemukan!');</script>";
        }
    } else {
        // User tidak ada
        echo "<script>alert('User dengan ID $ID_USER tidak ditemukan!');</script>";
    }
}

// Proses Edit Data
if (isset($_POST['update'])) {
    $ID_PEMBAYARAN = $_POST['ID_PEMBAYARAN'];
    $ID_USER = $_POST['ID_USER'];
    $ID_TRANSAKSI = $_POST['ID_TRANSAKSI'];
    $METODE_BAYAR = $_POST['METODE_BAYAR'];
    $JUMLAH_BAYAR = $_POST['JUMLAH_BAYAR'];
    $STATUS_BAYAR = $_POST['STATUS_BAYAR'];
    $TANGGAL_BAYAR = $_POST['TANGGAL_BAYAR'];

    // Cek apakah User dengan ID_USER ada
    $checkUserQuery = "SELECT * FROM user WHERE ID_USER = '$ID_USER'";
    $checkUserResult = $conn->query($checkUserQuery);

    if ($checkUserResult->num_rows > 0) {
        // Cek apakah Transaksi dengan ID_TRANSAKSI ada
        $checkTransaksiQuery = "SELECT * FROM transaksi WHERE ID_TRANSAKSI = '$ID_TRANSAKSI'";
        $checkTransaksiResult = $conn->query($checkTransaksiQuery);

        if ($checkTransaksiResult->num_rows > 0) {
            // User dan Transaksi ada, lanjutkan memperbarui pembayaran
            $sql = "UPDATE pembayaran SET ID_USER = '$ID_USER', ID_TRANSAKSI = '$ID_TRANSAKSI', METODE_BAYAR = '$METODE_BAYAR', 
                    JUMLAH_BAYAR = '$JUMLAH_BAYAR', STATUS_BAYAR = '$STATUS_BAYAR', TANGGAL_BAYAR = '$TANGGAL_BAYAR' 
                    WHERE ID_PEMBAYARAN = '$ID_PEMBAYARAN'";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data pembayaran berhasil diubah!');</script>";
                header("Location: pembayaran.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('Transaksi dengan ID $ID_TRANSAKSI tidak ditemukan!');</script>";
        }
    } else {
        // User tidak ada
        echo "<script>alert('User dengan ID $ID_USER tidak ditemukan!');</script>";
    }
}

// Proses Hapus Data
if (isset($_GET['delete_id'])) {
    $ID_PEMBAYARAN = $_GET['delete_id'];
    $sql = "DELETE FROM pembayaran WHERE ID_PEMBAYARAN = '$ID_PEMBAYARAN'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data pembayaran berhasil dihapus!');</script>";
        header("Location: pembayaran.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil Data dari Database
$sql = "SELECT * FROM pembayaran";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran</title>
    <link rel="stylesheet" href="styles.css">
</head>
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
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background-color: #2c3e50;
    color: #fff;
}
</style>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Laundry Online</h2>
        <ul>
            <li><a href="dasbor.php">🏠 Home</a></li>
            <li><a href="transaksi.php">🛒 Transaksi</a></li>
            <li class="active"><a href="pembayaran.php">💳 Pembayaran</a></li>
            <li><a href="paket.php">📦 Paket</a></li>
            <li><a href="account.php">👤 Account</a></li>
            <li><a href="logout.php">🔒 Logout</a></li>
        </ul>
    </div>
    <!-- Konten Utama -->
    <div class="container">
        <h1>Data Pembayaran</h1>

        <!-- Form Tambah Data -->
        <form method="POST" action="">
            <input type="number" name="ID_USER" placeholder="ID User" required>
            <input type="number" name="ID_TRANSAKSI" placeholder="ID Transaksi" required>
            <input type="text" name="METODE_BAYAR" placeholder="Metode Bayar" required>
            <input type="number" name="JUMLAH_BAYAR" placeholder="Jumlah Bayar" required>
            <input type="text" name="STATUS_BAYAR" placeholder="Status Bayar" required>
            <input type="date" name="TANGGAL_BAYAR" required>
            <button type="submit" name="submit">Tambah Data</button>
        </form>

        <!-- Tabel Data Pembayaran -->
        <table>
            <thead>
                <tr>
                    <th>ID Pembayaran</th>
                    <th>ID User</th>
                    <th>ID Transaksi</th>
                    <th>Metode Bayar</th>
                    <th>Jumlah Bayar</th>
                    <th>Status Bayar</th>
                    <th>Tanggal Bayar</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['ID_PEMBAYARAN'] . "</td>
                                <td>" . $row['ID_USER'] . "</td>
                                <td>" . $row['ID_TRANSAKSI'] . "</td>
                                <td>" . $row['METODE_BAYAR'] . "</td>
                                <td>Rp. " . number_format($row['JUMLAH_BAYAR'], 0, ',', '.') . "</td>
                                <td>" . $row['STATUS_BAYAR'] . "</td>
                                <td>" . $row['TANGGAL_BAYAR'] . "</td>
                                <td>
                                    <a href='?edit_id=" . $row['ID_PEMBAYARAN'] . "' style='color: #1abc9c;'>✏️</a>
                                    <a href='?delete_id=" . $row['ID_PEMBAYARAN'] . "' style='color: red;' onclick='return confirm(\"Apakah Anda yakin?\")'>❌</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Data tidak ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Form Edit Data -->
        <?php
        if (isset($_GET['edit_id'])) {
            $ID_PEMBAYARAN = $_GET['edit_id'];
            $sql_edit = "SELECT * FROM pembayaran WHERE ID_PEMBAYARAN = '$ID_PEMBAYARAN'";
            $result_edit = $conn->query($sql_edit);
            $edit_data = $result_edit->fetch_assoc();
            ?>
            <h2>Edit Pembayaran</h2>
            <form method="POST" action="">
                <input type="hidden" name="ID_PEMBAYARAN" value="<?php echo $edit_data['ID_PEMBAYARAN']; ?>">
                <input type="number" name="ID_USER" value="<?php echo $edit_data['ID_USER']; ?>" required>
                <input type="number" name="ID_TRANSAKSI" value="<?php echo $edit_data['ID_TRANSAKSI']; ?>" required>
                <input type="text" name="METODE_BAYAR" value="<?php echo $edit_data['METODE_BAYAR']; ?>" required>
                <input type="number" name="JUMLAH_BAYAR" value="<?php echo $edit_data['JUMLAH_BAYAR']; ?>" required>
                <input type="text" name="STATUS_BAYAR" value="<?php echo $edit_data['STATUS_BAYAR']; ?>" required>
                <input type="date" name="TANGGAL_BAYAR" value="<?php echo $edit_data['TANGGAL_BAYAR']; ?>" required>
                <button type="submit" name="update">Update Data</button>
            </form>
            <?php
        }
        ?>
    </div>
</body>
</html>
