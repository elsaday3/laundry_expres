<?php
include 'db.php';
session_start();

$error = "";

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek user di database
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password
        $password = md5($_POST['password']);
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $row['email'];

            // Redirect ke dasbor
            header("Location: dasbor.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        // $error = "Email tidak ditemukan.";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
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
        <h2>Form Login</h2>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Masukkan email" required>
            <input type="password" name="password" placeholder="Masukkan password" required>
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</body>
</html>
