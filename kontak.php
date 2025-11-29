<?php
// kontak.php

session_start();
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
}

// 1. Ambil nilai 'paket' dari URL (GET)
// Jika ada, gunakan nilai tersebut. Jika tidak ada, gunakan subjek default.
$subjek_pesan_otomatis = isset($_GET['paket']) ? htmlspecialchars($_GET['paket']) : 'Pertanyaan Umum Membership';

$status_pesan = ""; // Inisialisasi

// 2. Proses pengiriman formulir saat metode POST digunakan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // === Konfigurasi Telegram Bot Anda ===
    $BOT_TOKEN = "7519973051:AAGFZCUjGnWZATN7yXzm6kKj9z2Ydgh5APs"; // Contoh: 123456789:ABC-DEF123456...
    $CHAT_ID = "5731451750"; // Contoh: -1001234567890 (untuk grup/channel)
    // =====================================

    // Ambil dan bersihkan data formulir
    $nama = htmlspecialchars($_POST['nama_lengkap']);
    $email = htmlspecialchars($_POST['email']);
    $subjek = htmlspecialchars($_POST['subjek_pesan']);
    $pesan = htmlspecialchars($_POST['pesan_lengkap']);

    // Buat format pesan yang akan dikirim ke Telegram (menggunakan Markdown)
    $teks_telegram = "
🚀 **PESAN BARU (FORM KONTAK)** 🚀
----------------------------------------
👤 *Nama Lengkap:* " . $nama . "
📧 *Email:* " . $email . "
✨ *Subjek Pesan:* **" . $subjek . "**
----------------------------------------
💬 *Pesan Lengkap:* " . $pesan . "
";

    // URL API Telegram
    $url = "https://api.telegram.org/bot" . $BOT_TOKEN . "/sendMessage";

    // Data yang akan dikirim menggunakan format array
    $data = [
        'chat_id' => $CHAT_ID,
        'text' => $teks_telegram,
        'parse_mode' => 'Markdown'
    ];

    // Kirim permintaan ke Telegram API menggunakan cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Contoh penanganan respon
    if ($http_code == 200) {
        $status_pesan = "Pesan berhasil dikirim ke Admin Telegram!";
    } else {
        $status_pesan = "Gagal mengirim pesan. Cek Token dan Chat ID Anda.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Admin - AZURE POWER FITNESS</title>
    <style>
        /* ================================================= */
        /* SALIN GAYA CSS DARI menuutama.php DI SINI */
        /* ================================================= */
        :root {
            --primary-color: #007bff; 
            --secondary-color: #0056b3; 
            --background-color: #f8f9fa;
            --text-color: #333; 
            --white-color: #ffffff;
            --dark-color: #212529; 
            --success-color: #28a745; 
            --error-color: #dc3545;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        /* Header (disinkronkan dengan menuutama.php) */
        header {
            background-color: var(--dark-color);
            color: var(--white-color);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .logo {
            font-size: 1.8em;
            font-weight: bold;
            color: var(--primary-color);
            text-transform: uppercase;
        }
        .nav-links ul {
            list-style: none; margin: 0; padding: 0; display: flex;
        }
        .nav-links ul li { margin-left: 25px; }
        .nav-links ul li a {
            text-decoration: none; color: var(--white-color); font-weight: 500; padding: 5px 0; transition: color 0.3s ease, border-bottom 0.3s ease;
        }
        .nav-links ul li a:hover {
            color: var(--primary-color); border-bottom: 2px solid var(--primary-color);
        }
        #menu-toggle { display: none; }
        .menu-icon { display: none; cursor: pointer; z-index: 1000; }
        .menu-icon .bar {
            width: 25px; height: 3px; background-color: var(--white-color); margin: 5px 0; transition: all 0.3s ease;
        }
        .cta-button {
            display: inline-block; background-color: var(--error-color); color: var(--white-color); padding: 8px 16px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: background-color 0.3s ease;
        }
        .nav-links ul li a.cta-button:hover { background-color: #c82333; border-bottom: none; }

        /* Gaya Khusus Konten Kontak */
        .content-wrap { padding: 40px 20px; text-align: center; }
        .form-container { 
            background-color: white; 
            padding: 30px; 
            margin: 0 auto; 
            max-width: 500px; 
            border-radius: 10px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
            text-align: left;
        }
        
        .header-telegram { 
            background-color: var(--primary-color); 
            color: white; 
            padding: 15px; 
            border-radius: 8px; 
            text-align: center; 
            margin-bottom: 25px; 
            font-weight: bold;
            font-size: 1.1em;
        }
        
        input[type="text"], input[type="email"], textarea { 
            width: 100%; 
            padding: 12px; 
            margin: 5px 0 20px 0; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            box-sizing: border-box;
            font-size: 1em;
        }
        
        label { 
            font-weight: bold; 
            margin-bottom: 5px; 
            display: block; 
            color: var(--secondary-color);
        }
        
        .btn-submit { 
            background-color: var(--success-color); 
            color: white; 
            padding: 15px 20px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            width: 100%; 
            font-size: 1.1em; 
            font-weight: bold; 
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        
        .btn-submit:hover {
            background-color: #218838;
        }
        
        .status { 
            margin-top: 20px; 
            padding: 15px; 
            border-radius: 5px; 
            text-align: center;
            font-weight: bold;
        }
        
        .success { 
            background-color: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
        }
        
        .error { 
            background-color: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
        }

        /* Footer (disinkronkan dengan menuutama.php) */
        footer {
            background-color: var(--dark-color);
            color: var(--white-color);
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        /* MEDIA QUERY UNTUK MOBILE */
        @media (max-width: 768px) {
            .menu-icon { display: block; }
            header { padding: 15px 20px; flex-wrap: wrap; justify-content: space-between; }
            .nav-links {
                width: 100%; max-height: 0; overflow: hidden; transition: max-height 0.4s ease-in-out; background-color: var(--dark-color); position: absolute; top: 55px; left: 0; z-index: 999;
            }
            .nav-links ul { flex-direction: column; padding: 10px 0; }
            .nav-links ul li { margin: 0; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.1); }
            .nav-links ul li:first-child { border-top: none; }
            .nav-links ul li a { padding: 10px 0; display: block; }
            #menu-toggle:checked ~ .nav-links { max-height: 300px; }
            #menu-toggle:checked ~ .menu-icon .bar:nth-child(1) { transform: rotate(-45deg) translate(-5px, 6px); }
            #menu-toggle:checked ~ .menu-icon .bar:nth-child(2) { opacity: 0; }
            #menu-toggle:checked ~ .menu-icon .bar:nth-child(3) { transform: rotate(45deg) translate(-5px, -6px); }
            .content-wrap { padding: 20px; }
        }
    </style>
</head>
<body>
    
    <header>
        <div class="logo">AZURE POWER FITNESS</div>
        <input type="checkbox" id="menu-toggle" />
        <label for="menu-toggle" class="menu-icon">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </label>
        <nav class="nav-links">
            <ul>
                <li><a href="menuutama.php">Beranda</a></li>
                <li><a href="profil.php">Tentang Saya</a></li>
                <li><a href="membership.php">Membership</a></li>
                <li><a href="kontak.php">Kontak</a></li>
                <li><a href="logout.php" class="cta-button">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="content-wrap">
        <h1>Hubungi Kami</h1>
        <div class="form-container">
            <div class="header-telegram">
                Pesan akan di kirim ke admin.
            </div>

            <?php
            // Tampilkan status pesan setelah pengiriman
            if (!empty($status_pesan)) {
                $class = ($http_code == 200) ? 'success' : 'error';
                echo "<div class='status {$class}'>{$status_pesan}</div>";
            }
            ?>

            <form action="kontak.php" method="POST">
                
                <label for="nama_lengkap">👤 Nama Lengkap *</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap Anda" required>

                <label for="email">📧 Email *</label>
                <input type="email" id="email" name="email" placeholder="contoh@email.com" required>

                <label for="subjek_pesan">✏️ Subjek Pesan *</label>
                <input type="text" id="subjek_pesan" name="subjek_pesan"
                       value="<?php echo $subjek_pesan_otomatis; ?>"
                       placeholder="Contoh: Info Membership / Jadwal Kelas" required>

                <label for="pesan_lengkap">💬 Pesan Lengkap *</label>
                <textarea id="pesan_lengkap" name="pesan_lengkap" rows="5"
                          placeholder="Tuliskan detail pertanyaan atau pesan Anda di sini..." required></textarea>

                <button type="submit" class="btn-submit">
                    🚀 KIRIM PESAN SEKARANG
                </button>
            </form>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2025 AZURE POWER FITNESS - Arka Tegar Ardiansyah. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>
