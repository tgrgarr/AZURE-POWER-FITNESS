<?php
session_start();

// 1. Proteksi Halaman: Hanya boleh diakses jika user login
if (!isset($_SESSION['username'])) {
    // Redirect ke login jika belum login
    header('Location: index.php');
    exit;
}

// 2. Proteksi Metode: Hanya proses jika request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['nama']) || !isset($_POST['email'])) {
    // Redirect ke kontak.php jika bukan form submit yang valid
    header('Location: kontak.php');
    exit;
}

// Ambil dan bersihkan data
$nama = htmlspecialchars(trim($_POST['nama']));
$email = htmlspecialchars(trim($_POST['email']));
$subjek = isset($_POST['subjek']) ? htmlspecialchars(trim($_POST['subjek'])) : 'Tidak Ada Subjek';
$pesan = isset($_POST['pesan']) ? htmlspecialchars(trim($_POST['pesan'])) : 'Pesan Kosong';
$username = htmlspecialchars($_SESSION['username']);

// Konstruksi pesan untuk Telegram
$text = "🔔 *Pesan Baru dari Website*

"
      . "👤 *Nama:* $nama
"
      . "📧 *Email:* $email
"
      . "📝 *Subjek:* $subjek
"
      . "💬 *Pesan:* $pesan
"
      . "🧑 *User Login:* $username
"
      . "⏰ *Waktu:* " . date('d/m/Y H:i:s') . " WIB";

// Konfigurasi Telegram
$botToken = "7519973051:AAGFZCUjGnWZATN7yXzm6kKj9z2Ydgh5APs";
$chatId = "5731451750";
$telegramUrl = "https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$chatId}&parse_mode=Markdown&text=" . urlencode($text);

// Kirim pesan ke Telegram
// Menggunakan file_get_contents dengan error handling sederhana
$response = @file_get_contents($telegramUrl);

if ($response === false) {
    // Gagal terhubung/mengirim pesan
    header('Location: kontak.php?status=error');
    exit;
} else {
    // Berhasil (diasumsikan berhasil jika koneksi sukses)
    header('Location: kontak.php?status=success');
    exit;
}

?>
