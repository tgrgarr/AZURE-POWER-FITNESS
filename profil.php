<?php
// PHP SESSION START dan Proteksi Halaman
session_start(); 

// 1. Cek Proteksi: Jika user belum login, kembalikan ke login
if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
}

// 2. Ambil username untuk pesan sambutan (Tidak digunakan di profil, tapi dipertahankan untuk konsistensi)
// $current_username = htmlspecialchars($_SESSION['username']); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AZURE POWER FITNESS - Tentang Saya (Tugas Basis Data)</title>
    <style>
        /* ================================================= */
        /* SALIN SEMUA GAYA CSS DARI menuutama.php DI SINI */
        /* (Sudah ada di kode asli, hanya memastikan konsistensi) */
        /* ================================================= */

        /* Variabel Warna dan Gaya Dasar */
        :root {
            --primary-color: #007bff; 
            --secondary-color: #0056b3; 
            --background-color: #f8f9fa;
            --text-color: #333; 
            --white-color: #ffffff;
            --dark-color: #212529; 
            --accent-color: #ffc107;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        /* Gaya Header dan Navigasi Dasar */
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

        /* Navigasi Desktop */
        .nav-links ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-links ul li {
            margin-left: 25px;
        }

        .nav-links ul li a {
            text-decoration: none;
            color: var(--white-color);
            font-weight: 500;
            padding: 5px 0;
            transition: color 0.3s ease, border-bottom 0.3s ease;
        }

        .nav-links ul li a:hover {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }
        
        /* Gaya Baru untuk Ikon Menu Hamburger/X */
        #menu-toggle {
            display: none; 
        }

        .menu-icon {
            display: none; 
            cursor: pointer;
            z-index: 1000;
        }

        .menu-icon .bar {
            width: 25px;
            height: 3px;
            background-color: var(--white-color);
            margin: 5px 0;
            transition: all 0.3s ease;
        }

        /* Konten Utama (Hero Section) - Disesuaikan untuk Profil */
        .hero {
            background: var(--primary-color); 
            color: var(--white-color);
            text-align: center;
            padding: 50px 20px;
            min-height: 200px; 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .hero h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            color: var(--white-color);
        }

        .hero p {
            font-size: 1.1em;
            margin-bottom: 30px;
        }

        .cta-button {
            display: inline-block;
            background-color: #dc3545; /* Warna merah untuk Logout */
            color: var(--white-color);
            padding: 8px 16px; 
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .nav-links ul li a.cta-button:hover {
            background-color: #c82333;
            border-bottom: none;
        }

        /* Konten Tambahan & Footer */
        .main-content {
            padding: 40px;
            text-align: left; 
            max-width: 800px;
            margin: 0 auto;
        }

        .main-content h2 {
            color: var(--primary-color);
            margin-bottom: 25px;
            text-align: center;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
            font-size: 2.2em; 
        }
        
        /* Gaya Khusus untuk Informasi Profil */
        .profile-info {
            background-color: var(--white-color);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .profile-info ul {
            list-style: none;
            padding: 0;
        }
        
        .profile-info ul li {
            margin-bottom: 15px;
            padding: 10px;
            border-left: 5px solid var(--primary-color);
            background-color: #e9ecef;
            border-radius: 4px;
        }
        
        .profile-info ul li strong {
            display: inline-block;
            width: 150px; 
            color: var(--secondary-color);
        }

        .explanation {
            margin-top: 30px;
            padding: 20px;
            border: 1px dashed var(--primary-color);
            border-radius: 8px;
            background-color: #f1f8ff;
            text-align: center;
        }
        .explanation h2::after { /* Hapus garis bawah pada h2 di explanation */
            content: none;
        }

        footer {
            background-color: var(--dark-color);
            color: var(--white-color);
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        /* ======================================= */
        /* MEDIA QUERY UNTUK MOBILE (Maks. 768px) */
        /* ======================================= */
        @media (max-width: 768px) {
            /* Tampilkan Ikon Hamburger */
            .menu-icon {
                display: block;
            }

            /* Tampilan Header di Mobile */
            header {
                padding: 15px 20px;
                flex-wrap: wrap; 
                justify-content: space-between;
            }
            
            /* Navigasi (Nav-links) */
            .nav-links {
                width: 100%; 
                max-height: 0; 
                overflow: hidden;
                transition: max-height 0.4s ease-in-out;
                background-color: var(--dark-color);
                position: absolute;
                top: 55px; 
                left: 0;
                z-index: 999;
            }
            
            .nav-links ul {
                flex-direction: column;
                padding: 10px 0;
            }

            .nav-links ul li {
                margin: 0;
                text-align: center;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            .nav-links ul li:first-child {
                border-top: none;
            }

            .nav-links ul li a {
                padding: 10px 0;
                display: block;
            }
            
            /* LOGIKA HAMBURGER/X (Saat Checkbox DICENTANG) */
            #menu-toggle:checked ~ .nav-links {
                max-height: 300px; 
            }

            #menu-toggle:checked ~ .menu-icon .bar:nth-child(1) {
                transform: rotate(-45deg) translate(-5px, 6px);
            }

            #menu-toggle:checked ~ .menu-icon .bar:nth-child(2) {
                opacity: 0; 
            }

            #menu-toggle:checked ~ .menu-icon .bar:nth-child(3) {
                transform: rotate(45deg) translate(-5px, -6px);
            }
            
            /* Penyesuaian Konten */
            .hero h1 { font-size: 2em; }
            .hero p { font-size: 1em; }
            .main-content { padding: 20px; }
            
            .profile-info ul li strong {
                width: auto; 
                display: block; 
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">AZURE POWER FITNESS</div>
        
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
            <div class="bar"></div> <div class="bar"></div> <div class="bar"></div> </label>
        
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

    <div class="hero">
        <h1>Profil Siswa dan Tujuan Proyek</h1>
        <p>Halaman ini menyajikan identitas pembuat website sebagai bagian dari tugas sekolah.</p>
    </div>

    <div class="main-content">
        <h2>Informasi Pribadi</h2>
        <div class="profile-info">
            <ul>
                <li><strong>Nama Lengkap:</strong> Arka Tegar Ardiansyah</li>
                <li><strong>Kelas:</strong> X RPL 2</li>
                <li><strong>Sekolah:</strong> SMK N 1 SANDEN</li>
                <li><strong>Jurusan:</strong> Rekayasa Perangkat Lunak (RPL)</li>
            </ul>
        </div>
        
        <div class="explanation">
            <h2>Tujuan Proyek</h2>
            <p>
                Website ini dikembangkan dengan profesionalisme tinggi **untuk memenuhi penugasan proyek mata pelajaran Basis Data** yang diberikan oleh Bapak/Ibu Guru.
                Proyek ini bertujuan untuk mengaplikasikan dan mendemonstrasikan pemahaman mendalam mengenai integrasi Basis Data dengan antarmuka web
                menggunakan PHP, khususnya dalam pengelolaan sesi (login/logout) dan tampilan antarmuka pengguna yang responsif.
                Setiap komponen dirancang agar fungsional dan sesuai dengan standar industri web modern.
            </p>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 AZURE POWER FITNESS - Arka Tegar Ardiansyah. Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>
