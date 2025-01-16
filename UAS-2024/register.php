<?php
include 'db.php';
session_start();
    $_SESSION['logged_in'] = true;
    $_SESSION['user'] = $user; 
    header("Location: login.php");
    exit;

$error = "";
$success = "";

$conn = mysqli_connect("localhost", "root", "", "laundry");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek apakah input sudah diisi
    $nama = isset($_POST['NAMA']) ? $_POST['NAMA'] : '';
    $email = isset($_POST['EMAIL']) ? $_POST['EMAIL'] : '';
    $password = isset($_POST['PASSWORD']) ? $_POST['PASSWORD'] : '';

    // Validasi input (optional)
    if (empty($nama) || empty($email) || empty($password)) {
        // echo "Semua field harus diisi.";
    } else {
        // Hash password
        $hashed_password = md5($password);

                $query = "INSERT INTO user (NAMA, EMAIL, PASSWORD) VALUES ('$nama', '$email', '$password')" ;
                $result = mysqli_query($conn, $query);

                if ($result) {
                    echo "Registrasi berhasil!";
                } else {
                    // echo "Gagal mendaftar: " . mysqli_error($conn);
                }
            }
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Form Registrasi</title>
            <style>
                body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to top right, #f0f4f8, #d9e4f5);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        form h2 {
            margin-bottom: 20px;
            color: #007bff;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        form button:hover {
            background: #0056b3;
        }

        form p {
            margin-top: 10px;
            font-size: 14px;
            color: #495057;
        }

        form a {
            color: #007bff;
            text-decoration: none;
        }

        form a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            font-size: 14px;
            margin-bottom: 15px;
        }

            </style>
        </head>
        <body>
            <div class="form-container">
                <h2>Form Registrasi</h2>
                <?php if ($error): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <?php if ($success): ?>
                    <p style="color: green;"><?php echo $success; ?></p>
                <?php endif; ?>
                <form action="register.php" method="POST">
                <input type="ID_USER" name="ID_USER" placeholder="Masukkan ID_USER " required>
                <input type="NAMA" name="NAMA" placeholder="Masukkan NAMA" required>
                    <input type="EMAIL" name="EMAIL" placeholder="Masukkan EMAIL" required>
                    <input type="PASSWORD" name="PASSWORD" placeholder="Masukkan PASSWORD" required>
                    <button type="submit">Daftar</button>
                </form>
                <p>Sudah punya akun? <a href="login.php">Login</a></p>
            </div>
        </body>
        </html>
