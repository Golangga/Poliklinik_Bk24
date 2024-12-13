<?php
session_start();
require '../../config/koneksi.php';

// Cek apakah user sudah login sebagai pasien  
if (!isset($_SESSION['pasien_id'])) {
    header("location: ../../login_pasien.php");
    exit();
}

$dokter_id = $_GET['dokter_id'] ?? null;
if (!$dokter_id) {
    header("location: pilih_poli.php");
    exit();
}

// Ambil data dokter berdasarkan ID  
$query_dokter = "SELECT * FROM dokter WHERE id = ?";
$stmt_dokter = mysqli_prepare($mysqli, $query_dokter);
mysqli_stmt_bind_param($stmt_dokter, 'i', $dokter_id);
mysqli_stmt_execute($stmt_dokter);
$result_dokter = mysqli_stmt_get_result($stmt_dokter);
$dokter = mysqli_fetch_assoc($result_dokter);

// Cek apakah dokter ditemukan  
if (!$dokter) {
    echo "Dokter tidak ditemukan.";
    exit();
}

// Ambil jadwal dokter  
$query_jadwal = "SELECT * FROM jadwal_periksa WHERE id_dokter = ?";
$stmt_jadwal = mysqli_prepare($mysqli, $query_jadwal);
mysqli_stmt_bind_param($stmt_jadwal, 'i', $dokter_id);
mysqli_stmt_execute($stmt_jadwal);
$result_jadwal = mysqli_stmt_get_result($stmt_jadwal);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold">Jadwal Dr. <?= htmlspecialchars($dokter['nama']) ?></h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($jadwal = mysqli_fetch_assoc($result_jadwal)): ?>
                <div class="bg-white rounded-lg p-4 shadow-md">
                    <h3 class="font-semibold"><?= htmlspecialchars($jadwal['hari']) ?></h3>
                    <p><?= htmlspecialchars($jadwal['jam_mulai']) ?> - <?= htmlspecialchars($jadwal['jam_selesai']) ?></p>
                    <a href="konfirmasi_pendaftaran.php?jadwal_id=<?= $jadwal['id'] ?>" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                        Pilih Jadwal
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>