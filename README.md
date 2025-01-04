## Instalasi  

1. Clone Repository

  
   git clone https://github.com/Golangga/Poliklinik_Bk24
2. Menjalankan Server XAMPP
   Pastikan Apache dan MySQL berjalan di XAMPP Control Panel.
3. Mengkopi Databass
   Buka phpMyAdmin di http://localhost/phpmyadmin.
   Buat database baru dengan nama poli.
   Import file poli.sql dari folder proyek (database/poli.sql) ke dalam database yang baru dibuat.
   Menjalankan Aplikasi

4. Tempatkan folder proyek Anda di dalam folder htdocs XAMPP:

   C:\xampp\htdocs\Epol  
5. Konfigurasi
   Konfigurasi Database: Pastikan file koneksi database di config/koneksi.php telah diatur dengan benar sesuai pengaturan server lokal Anda:

   $host = "localhost";  
   $user = "root"; // username database  
   $password = ""; // password database  
   $db_name = "poli"; // nama database  
6. Cara Menggunakan
   Login sebagai Dokter/Admin: Gunakan halaman login untuk masuk ke sistem.
   Pendaftaran Pasien: Dokter/admin dapat mendaftar pasien baru.
   Pemeriksaan Pasien: Dokter dapat memeriksa pasien, memberikan obat, dan mencatat biaya.
7. Teknologi yang Digunakan
   - PHP
   - MySQL
   - HTML/CSS
   - JavaScript
   - Tailwind CSS
