<?php
include ('db.php');
session_start();

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Paket Laundry</title>
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
    margin-left: 260px;
    padding: 20px;
    box-sizing: border-box;
    overflow-x: auto;
}

/* Tabel */
table {
    width: 100%;
    border-collapse: collapse;
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

/* Form Cari */
form {
    margin-bottom: 20px; /* Jarak bawah form pencarian */
}

form input[type="text"] {
    padding: 8px;
    margin-right: 10px; /* Jarak antara input dan tombol */
    border: 1px solid #ccc;
    border-radius: 4px;
}

form button {
    padding: 8px 16px;
    background-color: #1abc9c;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form button:hover {
    background-color: #16a085;
}
</style>
<body>
    <div class="sidebar">
        <h2>Laundry Online</h2>
        <ul>
            <li><a href="dasbor.php">🏠 Home</a></li>
            <li><a href="transaksi.php">🛒 Transaksi</a></li>
            <li><a href="pembayaran.php">📊 Pembayaran</a></li>
            <li class="active"><a href="paket.php">📦 Paket</a></li>
            <li><a href=" account.php">👤 Account</a></li>
            <li><a href="logout.php">🔒 Logout</a></li>
        </ul>
    </div>

    <div class="container">
    <h1>Data Jenis Laundry</h1>

    <!-- Form Cari Data -->
    <form method="POST" action="">
        <input type="text" name="search" placeholder="Cari Nama Paket" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Cari</button>
    </form>

    <!-- Form Tambah Data -->
    <div class="form-container">
        <form method="POST" action="">
            <input type="text" name="NAMA_PAKET" placeholder="NAMA_PAKET" required>
            <input type="number" name="harga" placeholder="harga" required>
            <button type="submit" name="submit">Tambah Data</button>
        </form>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th>ID_PAKET</th>
                <th>Nama Paket</th>
                <th>Harga</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $no++ . "</td>
                            <td>" . htmlspecialchars($row['NAMA_PAKET']) . "</td>
                            <td>Rp. " . number_format($row['harga'], 0, ',', '.') . "</td>
                            <td>
                                <a href='?edit_id=" . $row['ID_PAKET'] . "' style='color: #1abc9c;'>✏️</a>
                                <a href='?delete_id=" . $row['ID_PAKET'] . "' style='color: red;' onclick='return confirm(\"apakah anda yakin?\")'>❌</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Data tidak ditemukan</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Form Edit Data -->
    <?php
    if (isset($_GET['edit_id'])) {
        $ID_PAKET = $_GET['edit_id'];
        $stmt_edit = $conn->prepare("SELECT * FROM PAKET WHERE ID_PAKET = ?");
        $stmt_edit->bind_param("d", $ID_PAKET);
        $stmt_edit->execute();
        $edit_data = $stmt_edit->get_result()->fetch_assoc();
        ?>
        <h2>Edit Paket</h2>
        <form method="POST" action="">
            <input type="hidden" name="id_paket" value="<?php echo $edit_data['ID_PAKET']; ?>">
            <input type="text" name="NAMA_PAKET" value="<?php echo $edit_data['NAMA_PAKET']; ?>" required>
            <input type="number" name="harga" value="<?php echo $edit_data['harga']; ?>" required>
            <button type="submit" name="update">Update Data</button>
        </form>
        <?php
    }
    ?>
</div>

</body>
</html>
