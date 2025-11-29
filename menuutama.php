<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
}
$currentusername = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" >
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>AZURE POWER FITNESS - Selamat Datang di Pusat Kebugaran Anda</title>
<style>
/* ================================================= */
/* GAYA CSS DIADAPTASI DARI membership.php */
/* ================================================= */

/* Variabel Warna dan Gaya Dasar */
:root {
    --primary-color: #007bff; 
    --secondary-color: #0056b3; 
    --background-color: #f8f9fa;
    --text-color: #333; 
    --white-color: #ffffff;
    --dark-color: #212529; 
    --success-color: #28a745; 
    --accent-color: #ffc107; /* Tambahan dari menuutama */
}

body {
    font-family: 'Arial', sans-serif; /* Diperbarui */
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
    position: relative; /* Penting untuk mobile nav */
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
    display: none; /* Sembunyikan checkbox */
}

.menu-icon {
    display: none; /* Sembunyikan secara default (Desktop) */
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

/* Konten Utama (Hero Section) */
.hero {
    background: linear-gradient(rgba(0, 123, 255, 0.8), rgba(0, 86, 179, 0.8)), url('gym-background.jpg'); /* Ilustrasi background */
    background-size: cover;
    background-position: center;
    color: var(--white-color);
    text-align: center;
    padding: 60px 20px;
    min-height: 250px; 
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.hero h1 {
    font-size: 3em;
    margin-bottom: 10px;
    color: var(--white-color);
}

.hero p {
    font-size: 1.2em;
    margin-bottom: 30px;
}

/* Tombol Logout di Nav-bar */
.cta-button {
    display: inline-block;
    background-color: #dc3545; /* Warna merah untuk Logout */
    color: var(--white-color);
    padding: 8px 16px; /* Diperkecil sedikit untuk nav */
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.nav-links ul li a.cta-button:hover {
    background-color: #c82333;
    border-bottom: none; /* Penting untuk menimpa hover border */
}

/* Tombol CTA Utama di Hero */
.main-cta {
    display: inline-block;
    background-color: var(--primary-color); /* Warna utama */
    color: var(--white-color);
    padding: 15px 35px;
    font-size: 1.1em;
    border-radius: 8px;
    text-decoration: none;
    transition: background-color 0.3s ease;
    margin-top: 10px;
}

.main-cta:hover {
    background-color: var(--secondary-color);
}


/* Konten Utama */
.main-content {
    padding: 40px;
    max-width: 1000px;
    margin: 0 auto;
    text-align: center;
}

.main-content h2 {
    color: var(--secondary-color);
    margin-bottom: 30px;
    font-size: 2.2em; /* Diperbesar */
    position: relative;
    color: var(--primary-color); /* Ubah warna agar konsisten */
    text-align: center;
}

.main-content h2::after {
    content: "";
    display: block;
    width: 50px;
    height: 3px;
    background: var(--primary-color);
    margin: 10px auto 0;
}

/* Grid Fitur */
.feature-grid {
    display: flex;
    justify-content: space-around;
    gap: 20px;
    margin-top: 30px;
}

.feature-item {
    flex: 1;
    background-color: var(--white-color);
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Shadow dari membership */
    text-align: center;
    border-top: 5px solid var(--accent-color);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-5px); /* Efek hover dari membership */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.feature-item h3 {
    color: var(--secondary-color); /* Ubah warna agar konsisten */
    margin-bottom: 10px;
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
        max-height: 0; /* Sembunyikan menu secara default */
        overflow: hidden;
        transition: max-height 0.4s ease-in-out;
        background-color: var(--dark-color);
        position: absolute;
        top: 55px; /* Sesuaikan dengan tinggi header */
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
    /* Tampilkan menu saat #menu-toggle dicentang */
    #menu-toggle:checked ~ .nav-links {
        max-height: 300px; /* Buka menu */
    }

    /* Mengubah bar menjadi X */
    #menu-toggle:checked ~ .menu-icon .bar:nth-child(1) {
        transform: rotate(-45deg) translate(-5px, 6px); /* Diperbaiki dari menuutama.php sebelumnya */
    }

    #menu-toggle:checked ~ .menu-icon .bar:nth-child(2) {
        opacity: 0; /* Hilangkan bar tengah */
    }

    #menu-toggle:checked ~ .menu-icon .bar:nth-child(3) {
        transform: rotate(45deg) translate(-5px, -6px); /* Diperbaiki dari menuutama.php sebelumnya */
    }
    
    /* Penyesuaian Konten */
    .hero {
        padding: 40px 20px;
    }
    .hero h1 { font-size: 2.2em; }
    .hero p { font-size: 1.1em; }
    .main-content { padding: 20px; }
    
    .feature-grid {
        flex-direction: column;
    }
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
            <li><a href="kontak.php">Kontak</a></li> <li><a href="logout.php" class="cta-button">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="hero">
    <p style="font-size: 1.5em; margin-bottom: 5px;">Halo, Selamat Datang <?php echo $currentusername; ?>!</p>
    <h1>MULAI PERJALANAN KEBUGARAN ANDA HARI INI</h1>
    <p>Kami menyediakan fasilitas gym terbaik dan program latihan yang disesuaikan untuk mencapai target Anda.</p>
    <a href="membership.php" class="cta-button main-cta">Lihat Paket Membership</a>
</div>

<div class="main-content">
    <h2>Kenapa Memilih AZURE POWER FITNESS?</h2>
    <div class="feature-grid">
        <div class="feature-item">
            <h3>Fasilitas Modern</h3>
            <p>Peralatan terbaru, area latihan yang luas, dan lingkungan yang higienis untuk sesi latihan optimal.</p>
        </div>
        <div class="feature-item">
            <h3>Pelatih Profesional</h3>
            <p>Dukungan dari Personal Trainer bersertifikat untuk memandu Anda mencapai hasil maksimal dengan aman.</p>
        </div>
        <div class="feature-item">
            <h3>Kelas Beragam</h3>
            <p>Berbagai pilihan kelas seperti Yoga, Zumba, dan HIIT yang dapat dipilih sesuai minat dan jadwal Anda.</p>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2025 AZURE POWER FITNESS - Arka Tegar Ardiansyah. Hak Cipta Dilindungi.</p> </footer>
</body>
</html>
