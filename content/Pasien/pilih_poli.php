<?php
session_start();
require '../../config/koneksi.php';

// Cek login pasien  
if (!isset($_SESSION['pasien_id'])) {
    header("location: ../../login_pasien.php");
    exit();
}

// Ambil daftar poli  
$query_poli = "SELECT * FROM poli";
$result_poli = mysqli_query($mysqli, $query_poli);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Poli</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Pilih Poli</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($poli = mysqli_fetch_assoc($result_poli)): ?>
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                    <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($poli['nama_poli']) ?></h2>
                    <p class="text-gray-600 mb-4"><?= htmlspecialchars($poli['keterangan']) ?></p>
                    <a href="pilih_dokter.php?poli_id=<?= $poli['id'] ?>" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                        Pilih Dokter
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>