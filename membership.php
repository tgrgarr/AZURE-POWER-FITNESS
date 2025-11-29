<?php
// membership.php

session_start();
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilihan Paket - AZURE POWER FITNESS</title>
    <style>
        /* ================================================= */
        /* GAYA CSS DISINKRONKAN DARI menuutama.php */
        /* ================================================= */
        :root {
            --primary-color: #007bff; 
            --secondary-color: #0056b3; 
            --background-color: #f8f9fa;
            --text-color: #333; 
            --white-color: #ffffff;
            --dark-color: #212529; 
            --success-color: #28a745; 
            --accent-color: #ffc107;
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

        /* ------------------- HEADER & NAVIGASI ------------------- */
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
            list-style: none; /* WAJIB: Hilangkan list style */
            margin: 0; padding: 0; display: flex;
        }
        .nav-links ul li { 
            list-style: none; /* WAJIB: Hilangkan list style */
            margin-left: 25px; 
        }
        .nav-links ul li a {
            text-decoration: none; color: var(--white-color); font-weight: 500; padding: 5px 0; transition: color 0.3s ease, border-bottom 0.3s ease;
        }
        .nav-links ul li a:hover {
            color: var(--primary-color); border-bottom: 2px solid var(--primary-color);
        }
        
        /* Hamburger/Mobile Menu Toggle */
        #menu-toggle { display: none; }
        .menu-icon { display: none; cursor: pointer; z-index: 1000; }
        .menu-icon .bar {
            width: 25px; height: 3px; background-color: var(--white-color); margin: 5px 0; transition: all 0.3s ease;
        }
        
        /* Tombol Logout */
        .cta-button {
            display: inline-block; background-color: var(--error-color); /* Warna merah untuk Logout */ 
            color: var(--white-color); padding: 8px 16px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: background-color 0.3s ease;
        }
        .nav-links ul li a.cta-button:hover { background-color: #c82333; border-bottom: none; }
        /* ------------------- END HEADER & NAVIGASI ------------------- */


        /* Gaya Khusus Konten Membership */
        .main-content {
            padding: 50px 20px;
            max-width: 1100px;
            margin: 0 auto;
            text-align: center;
        }
        .main-content h1 {
            color: var(--dark-color);
            margin-bottom: 40px;
            font-size: 2.5em;
        }
        
        .membership-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        
        .card { 
            background-color: white; 
            padding: 30px; 
            max-width: 300px; 
            border-radius: 10px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            text-align: center; 
            flex: 1 1 300px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-top: 5px solid var(--primary-color); 
        }

        .card.premium {
            border-top: 5px solid var(--accent-color);
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        
        .card:hover {
            transform: translateY(-5px); 
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card h2 { 
            color: var(--secondary-color);
            margin-top: 0; 
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }
        .card.premium h2 {
            border-bottom-color: var(--accent-color);
        }
        
        .price { 
            font-size: 2.5em; 
            color: var(--primary-color); 
            font-weight: bold; 
            margin: 15px 0; 
        }
        .card.premium .price {
             color: var(--accent-color);
        }
        
        ul { 
            list-style: none; /* WAJIB: Hilangkan list style */
            padding: 0; 
            text-align: left; 
            margin: 20px 0; 
        }
        
        li { 
            list-style: none; /* WAJIB: Hilangkan list style */
            margin-bottom: 12px; 
            display: flex; 
            align-items: center; 
            color: var(--text-color);
        }
        
        li::before { 
            content: '; 
            margin-right: 10px; 
            font-size: 1.2em;
        }
        
        li.not-included { 
            color: #6c757d; 
        }
        
        li.not-included::before { 
            content: '➖'; 
            color: #6c757d;
        }
        
        .btn-select { 
            background-color: var(--success-color); 
            color: white; 
            padding: 12px 20px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            text-decoration: none; 
            display: inline-block; 
            font-size: 16px; 
            width: 100%; 
            box-sizing: border-box; 
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        
        .btn-select:hover {
            background-color: #218838;
        }
        .card.premium .btn-select {
            background-color: var(--accent-color); 
            color: var(--dark-color);
        }
        .card.premium .btn-select:hover {
            background-color: #e0a800; 
        }


        /* ------------------- FOOTER ------------------- */
        footer {
            background-color: var(--dark-color);
            color: var(--white-color);
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        /* ------------------- MEDIA QUERY UNTUK MOBILE ------------------- */
        @media (max-width: 768px) {
            /* Tampilkan Hamburger Icon */
            .menu-icon { display: block; }
            header { padding: 15px 20px; flex-wrap: wrap; justify-content: space-between; }
            
            /* Menu Navigasi Mobile */
            .nav-links {
                width: 100%; max-height: 0; overflow: hidden; transition: max-height 0.4s ease-in-out; background-color: var(--dark-color); 
                position: absolute; top: 55px; left: 0; z-index: 999;
            }
            .nav-links ul { 
                flex-direction: column; 
                padding: 10px 0; 
                list-style: none; /* Pastikan tidak ada list style */
            }
            .nav-links ul li { 
                margin: 0; 
                text-align: center; 
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                list-style: none; /* Pastikan tidak ada list style */
            }
            .nav-links ul li:first-child { border-top: none; }
            .nav-links ul li a { 
                padding: 10px 0; 
                display: block; 
                width: 100%; /* Agar tombol Logout full width */
            }
            
            /* Efek Toggle Hamburger/X */
            #menu-toggle:checked ~ .nav-links { max-height: 350px; } /* Ditingkatkan sedikit */
            #menu-toggle:checked ~ .menu-icon .bar:nth-child(1) { transform: rotate(-45deg) translate(-5px, 6px); }
            #menu-toggle:checked ~ .menu-icon .bar:nth-child(2) { opacity: 0; }
            #menu-toggle:checked ~ .menu-icon .bar:nth-child(3) { transform: rotate(45deg) translate(-5px, -6px); }
            
            /* Penyesuaian Konten */
            .main-content { padding: 20px; }
            .membership-grid { flex-direction: column; gap: 20px; }
            .card { max-width: 100%; }
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

    <div class="main-content">
        <h1>Pilih Paket Kebugaran Anda</h1>
        
        <div class="membership-grid">
            
            <div class="card">
                <h2>Paket Basic</h2>
                <div class="price">Rp 150K <span style="font-size: 0.5em; font-weight: normal;">/ bln</span></div>
                
                <ul>
                    <li>Akses ke semua alat gym.</li>
                    <li>Jadwal kelas gym standar.</li>
                    <li>Sesi konsultasi bulanan (1x).</li>
                    <li class="not-included">Pelatih pribadi (Personal Trainer).</li>
                </ul>
                
                <?php
                $nama_paket_basic = urlencode("Pemesanan Paket Basic - Rp 150K");
                ?>
                
                <a href="kontak.php?paket=<?php echo $nama_paket_basic; ?>" class="btn-select">
                    Pilih Paket Ini
                </a>
            </div>

            <div class="card premium">
                <h2>Paket Premium</h2>
                <div class="price">Rp 300K <span style="font-size: 0.5em; font-weight: normal;">/ bln</span></div>
                
                <ul>
                    <li>Akses ke semua alat gym dan sauna.</li>
                    <li>Semua jadwal kelas (termasuk kelas eksklusif).</li>
                    <li>Sesi konsultasi mingguan (4x).</li>
                    <li>Pelatih pribadi (Personal Trainer) 1x seminggu.</li>
                </ul>
                
                <?php
                $nama_paket_premium = urlencode("Pemesanan Paket Premium - Rp 300K");
                ?>
                
                <a href="kontak.php?paket=<?php echo $nama_paket_premium; ?>" class="btn-select">
                    Pilih Paket Ini
                </a>
            </div>
            
        </div>
    </div>
    
    <footer>
        <p>&copy; 2025 AZURE POWER FITNESS - Arka Tegar Ardiansyah. Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>
