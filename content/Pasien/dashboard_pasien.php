<?php
session_start();
require_once '../../config/koneksi.php';

// Cek apakah pasien sudah login  
if (!isset($_SESSION['pasien_id'])) {
    header("Location: login_pasien.php");
    exit;
}

// Ambil data pasien dari database  
$pasien_id = $_SESSION['pasien_id'];
$query_pasien = "SELECT * FROM pasien WHERE id = '$pasien_id'";
$result_pasien = mysqli_query($mysqli, $query_pasien);
$pasien = mysqli_fetch_assoc($result_pasien);

// Ambil riwayat pendaftaran pasien  
$query_riwayat = "  
    SELECT dp.id, p.nama_poli, d.nama AS dokter_nama, dp.keluhan, dp.no_antrian, jp.hari, jp.jam_mulai, jp.jam_selesai, dp.status_periksa  
    FROM daftar_poli dp  
    JOIN jadwal_periksa jp ON dp.id_jadwal = jp.id  
    JOIN dokter d ON jp.id_dokter = d.id  
    JOIN poli p ON d.id_poli = p.id  
    WHERE dp.id_pasien = '$pasien_id'   
    ORDER BY dp.id DESC";
$result_riwayat = mysqli_query($mysqli, $query_riwayat);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-gradient-to-r from-teal-500 to-blue-500 shadow-lg">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-3xl font-extrabold text-white">Dashboard Pasien</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-200"><?= htmlspecialchars($pasien['nama']); ?></span>
                    <a href="../../logout.php" class="text-white hover:text-teal-200 transition duration-200">Logout</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-6 py-8">

            <!-- Riwayat Pendaftaran Poli -->
            <h2 class="text-xl font-semibold mb-4">Riwayat Pendaftaran Poli</h2>
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg mb-6">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="border-b py-3 px-4 text-left">No</th>
                            <th class="border-b py-3 px-4 text-left">Poli</th>
                            <th class="border-b py-3 px-4 text-left">Dokter</th>
                            <th class="border-b py-3 px-4 text-left">Keluhan</th>
                            <th class="border-b py-3 px-4 text-left">No Antrian</th>
                            <th class="border-b py-3 px-4 text-left">Jadwal</th>
                            <th class="border-b py-3 px-4 text-left">Status</th>
                            <th class="border-b py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($riwayat = mysqli_fetch_assoc($result_riwayat)): ?>
                            <tr class="<?= $no % 2 ? 'bg-gray-50' : 'bg-white' ?> hover:bg-teal-100 transition duration-150">
                                <td class="border py-2 px-4"><?= $no++; ?></td>
                                <td class="border py-2 px-4"><?= htmlspecialchars($riwayat['nama_poli']); ?></td>
                                <td class="border py-2 px-4"><?= htmlspecialchars($riwayat['dokter_nama']); ?></td>
                                <td class="border py-2 px-4"><?= htmlspecialchars($riwayat['keluhan']); ?></td>
                                <td class="border py-2 px-4"><?= htmlspecialchars($riwayat['no_antrian']); ?></td>
                                <td class="border py-2 px-4"><?= htmlspecialchars($riwayat['hari']) . ' ' . htmlspecialchars($riwayat['jam_mulai']) . ' - ' . htmlspecialchars($riwayat['jam_selesai']); ?></td>
                                <td class="border py-2 px-4"><?= htmlspecialchars($riwayat['status_periksa']) ?></td>
                                <td class="border py-2 px-4">
                                    <a href="detail_periksa.php?id=<?= $riwayat['id'] ?>" class="bg-blue-600 text-white py-1 px-3 rounded hover:bg-blue-700 transition duration-300">Detail</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Aksi Selanjutnya -->
            <h2 class="text-xl font-semibold mt-8 mb-4">Aksi Selanjutnya</h2>
            <div class="flex flex-wrap space-x-4 mb-6">
                <a href="daftar_poli.php" class="bg-blue-600 text-white py-3 px-5 rounded-lg shadow hover:bg-blue-700 transition duration-300">Daftar Poli <i class="fas fa-plus-circle"></i></a>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow-md border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-sm text-gray-500">
                    © <?= date('Y') ?> Sistem Informasi Pasien. Hak Cipta Dilindungi.
                </p>
            </div>
        </footer>
    </div>
</body>

</html>