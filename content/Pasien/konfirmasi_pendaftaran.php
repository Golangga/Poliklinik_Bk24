<?php
session_start();
require '../../config/koneksi.php';

// Cek apakah user sudah login sebagai pasien  
if (!isset($_SESSION['pasien_id'])) {
    header("location: ../../login_pasien.php");
    exit();
}

// Ambil id_jadwal dan id_poli dari form  
$id_jadwal = $_POST['id_jadwal'] ?? null;
$id_poli = $_POST['id_poli'] ?? null;

if (!$id_jadwal || !$id_poli) {
    header("location: daftar_poli.php");
    exit();
}

// Simpan pendaftaran  
$keluhan = "Keluhan pasien"; // Anda bisa mengganti ini dengan input dari pasien  
$query = "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($mysqli, $query);
$no_antrian = 1; // Anda bisa menambahkan logika untuk menghitung nomor antrian  
mysqli_stmt_bind_param($stmt, 'iisi', $_SESSION['pasien_id'], $id_jadwal, $keluhan, $no_antrian);
mysqli_stmt_execute($stmt);

// Ambil data pendaftaran terakhir  
$pendaftaran_id = mysqli_insert_id($mysqli);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4 text-center">Pendaftaran Berhasil</h1>
        <p class="text-center">Pendaftaran Anda dengan ID: <?= htmlspecialchars($pendaftaran_id) ?> berhasil.</p>
        <div class="mt-6 text-center">
            <a href="dashboard_pasien.php" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>

</html>