<?php
// index.php (Halaman Login)

// 1. WAJIB: Session start harus di baris paling atas
session_start();

// 2. Cek apakah user sudah login sebelumnya?
// Jika sudah ada session username, langsung lempar ke menuutama
if (isset($_SESSION['username'])) {
    header("location: menuutama.php");
    exit;
}

$error = "";

// 3. Logika saat Tombol Login Ditekan
if (isset($_POST['login'])) {
    
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ==================================================================
    // FIX: LOGIN DENGAN DATABASE (db_login/users)
    // ==================================================================
    
    // Pastikan Anda memiliki file koneksi.php di direktori yang sama
    @include 'koneksi.php'; // '@' digunakan untuk menekan error jika file tidak ditemukan
    
    if (isset($koneksi)) {
        // Mencegah SQL Injection sederhana
        $username_safe = mysqli_real_escape_string($koneksi, $username);
        // Catatan: Jika password di-hash di database, gunakan password_verify()
        $password_safe = mysqli_real_escape_string($koneksi, $password); 

        // Cek user di tabel 'users' (Sesuaikan 'users' dengan nama tabel Anda)
        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username_safe' AND password='$password_safe'");
        $cek = mysqli_num_rows($query);

        if ($cek > 0) {
            // SUKSES LOGIN
            $_SESSION['username'] = $username;
            $_SESSION['status'] = "login";
            
            header("location: menuutama.php");
            exit; 
            
        } else {
            $error = "Username atau Password Salah";
        }
    } else {
         // Jika koneksi.php tidak ditemukan atau gagal koneksi
         $error = "Kesalahan Server: File koneksi database (koneksi.php) tidak ditemukan atau koneksi gagal.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AZURE POWER FITNESS</title>
    <style>
        /* Menggunakan style yang konsisten dengan menuutama.php */
        :root {
            --primary-color: #007bff; 
            --background-color: #f8f9fa;
            --white-color: #ffffff;
            --text-color: #333;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-color);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: var(--white-color);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            font-size: 2em;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-msg {
            color: red;
            margin-bottom: 15px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="logo">AZURE POWER FITNESS</div>
        
        <?php if($error != "") { ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php } ?>

        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Masuk Sekarang</button>
        </form>
        
        <p style="margin-top: 20px; font-size: 0.8em; color: #6c757d;">
        </p>
    </div>

</body>
</html>
