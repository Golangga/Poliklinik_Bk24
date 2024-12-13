<?php
require_once './config/koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($mysqli, $_POST['nama']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    // Query untuk mengambil data pasien berdasarkan nama  
    $query = "SELECT * FROM pasien WHERE nama = '$nama'";
    $result = mysqli_query($mysqli, $query);
    $pasien = mysqli_fetch_assoc($result);

    // Verifikasi pasien  
    if ($pasien && password_verify($password, $pasien['password'])) {
        $_SESSION['pasien_id'] = $pasien['id']; // Simpan ID pasien di session  
        header("Location: ./content/Pasien/dashboard_pasien.php"); // Arahkan ke dashboard pasien  
        exit;
    } else {
        echo "<script>alert('Nama atau password salah.'); window.location.href='login_pasien.php';</script>";
    }
} else {
    // Jika bukan POST, arahkan kembali ke halaman login  
    header("Location: login_pasien.php");
    exit;
}
