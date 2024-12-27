<?php
require_once './config/koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($mysqli, $_POST['nama']);
    $alamat = mysqli_real_escape_string($mysqli, $_POST['alamat']); // Mengganti password dengan alamat  

    // Query untuk mengambil data pasien berdasarkan nama  
    $query = "SELECT * FROM pasien WHERE nama = '$nama'";
    $result = mysqli_query($mysqli, $query);
    $pasien = mysqli_fetch_assoc($result);

    // Verifikasi pasien menggunakan alamat  
    if ($pasien && $alamat === $pasien['alamat']) {
        $_SESSION['pasien_id'] = $pasien['id']; // Simpan ID pasien di session  
        header("Location: ./content/Pasien/dashboard_pasien.php"); // Arahkan ke dashboard pasien  
        exit;
    } else {
        echo "<script>alert('Nama atau alamat salah.'); window.location.href='login_pasien.php';</script>";
    }
} else {
    // Jika bukan POST, arahkan kembali ke halaman login  
    header("Location: login_pasien.php");
    exit;
}
