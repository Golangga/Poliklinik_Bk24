<?php
session_start();
require_once '../../config/koneksi.php';

// Cek apakah pasien sudah login  
if (!isset($_SESSION['pasien_id'])) {
    header("Location: login_pasien.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">
    <div class="container mx-auto p-6 max-w-md">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Pendaftaran Berhasil!</h2>
            <p class="mb-4">Anda telah berhasil mendaftar ke poli. Nomor antrian Anda akan diinformasikan melalui sistem.</p>
            <a href="dashboard_pasien.php" class="block bg-blue-500 hover:bg-blue-600 text-white text-center px-4 py-2 rounded-lg">Kembali ke Dashboard</a>
        </div>
    </div>
</body>

</html>