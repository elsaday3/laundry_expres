<?php
include ('db.php'); 
session_start();

// Cek Login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Tambah Data
if (isset($_POST['submit'])) {
    $NAMA_PAKET = $_POST['NAMA_PAKET'];
    $harga = $_POST['harga'];

    $stmt = $conn->prepare("INSERT INTO PAKET (NAMA_PAKET, harga) VALUES (?, ?)");
    $stmt->bind_param("sd", $NAMA_PAKET, $harga);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
        header("Location: paket.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Edit Data
if (isset($_POST['update'])) {
    $id_paket = $_POST['id_paket'];
    $NAMA_PAKET = $_POST['NAMA_PAKET'];
    $harga = $_POST['harga'];

    $stmt = $conn->prepare("UPDATE PAKET SET NAMA_PAKET = ?, harga = ? WHERE ID_PAKET = ?");
    $stmt->bind_param("sdi", $NAMA_PAKET, $harga, $id_paket);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        header("Location: paket.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Hapus Data
if (isset($_GET['delete_id'])) {
    $id_paket = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM PAKET WHERE ID_PAKET = ?");
    $stmt->bind_param("d", $id_paket);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus!');</script>";
        header("Location: paket.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Ambil Data untuk Tabel
$search = isset($_POST['search']) ? $_POST['search'] : '';
$stmt = $conn->prepare("SELECT * FROM PAKET WHERE NAMA_PAKET LIKE ?");
$search_param = "%$search%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();

// Ambil Data untuk Edit
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt_edit = $conn->prepare("SELECT * FROM PAKET WHERE ID_PAKET = ?");
    $stmt_edit->bind_param("d", $edit_id);
    $stmt_edit->execute();
    $edit_data = $stmt_edit->get_result()->fetch_assoc();
}


// Ambil Data dari Database
$sql = "SELECT * FROM transaksi";
$result = $conn->query($sql);
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
            <li class="active"><a href="transaksi.php">🛒 Transaksi</a></li>
            <li><a href="pembayaran.php">📊 Pembayaran</a></li>
            <li><a href="paket.php">📦 Paket</a></li>
            <li><a href="account.php">👤 Account</a></li>
            <li><a href="logout.php">🔒 Logout</a></li>
        </ul>
    </div>
    <!-- Konten Utama -->
    <div class="container">
        <h1>Data Transaksi</h1>

        <!-- Form Tambah Data -->
        <form method="POST" action="">
            <input type="number" name="ID_USER" placeholder="ID User" required>
            <input type="number" name="TOTAL_HARGA" placeholder="Total Harga" required>
            <input type="date" name="TANGGAL_TRANSAKSI" required>
            <input type="text" name="STATUS" placeholder="Status" required>
            <button type="submit" name="submit">Tambah Data</button>
        </form>

        <!-- Tabel Data Transaksi -->
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>ID User</th>
                    <th>Total Harga</th>
                    <th>Tanggal Transaksi</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['ID_TRANSAKSI'] . "</td>
                                <td>" . $row['ID_USER'] . "</td>
                                <td>Rp. " . number_format($row['TOTAL_HARGA'], 0, ',', '.') . "</td>
                                <td>" . $row['TANGGAL_TRANSAKSI'] . "</td>
                                <td>" . $row['STATUS'] . "</td>
                                <td>
                                    <a href='?edit_id=" . $row['ID_TRANSAKSI'] . "' style='color: #1abc9c;'>✏️</a>
                                    <a href='?delete_id=" . $row['ID_TRANSAKSI'] . "' style='color: red;' onclick='return confirm(\"Apakah Anda yakin?\")'>❌</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Data tidak ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Form Edit Data -->
        <?php
        if (isset($_GET['edit_id'])) {
            $ID_TRANSAKSI = $_GET['edit_id'];
            $sql_edit = "SELECT * FROM transaksi WHERE ID_TRANSAKSI = '$ID_TRANSAKSI'";
            $result_edit = $conn->query($sql_edit);
            $edit_data = $result_edit->fetch_assoc();
            ?>
            <h2>Edit Transaksi</h2>
            <form method="POST" action="">
                <input type="hidden" name="ID_TRANSAKSI" value="<?php echo $edit_data['ID_TRANSAKSI']; ?>">
                <input type="number" name="ID_USER" value="<?php echo $edit_data['ID_USER']; ?>" required>
                <input type="number" name="TOTAL_HARGA" value="<?php echo $edit_data['TOTAL_HARGA']; ?>" required>
                <input type="date" name="TANGGAL_TRANSAKSI" value="<?php echo $edit_data['TANGGAL_TRANSAKSI']; ?>" required>
                <input type="text" name="STATUS" value="<?php echo $edit_data['STATUS']; ?>" required>
                <button type="submit" name="update">Update Data</button>
            </form>
            <?php
        }
        ?>
    </div>
</body>
</html>
