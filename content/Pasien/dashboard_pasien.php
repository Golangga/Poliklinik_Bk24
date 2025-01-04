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
    <script src="//unpkg.com/alpinejs" defer></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="dashboard.php" class="flex items-center">
                            <i class="fas fa-hospital-user text-2xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"></i>
                            <span class="ml-2 text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">E-Poli</span>
                        </a>
                    </div>

                    <!-- Navigation -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="dashboard_pasien.php" class="px-3 py-2 text-indigo-600 font-semibold">
                            <i class="fas fa-home mr-1"></i>Dashboard
                        </a>
                        <a href="daftar_poli.php" class="px-3 py-2 text-gray-700 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-plus-circle mr-1"></i>Daftar Poli
                        </a>
                        <a href="#riwayat" class="px-3 py-2 text-gray-700 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-history mr-1"></i>Riwayat
                        </a>

                        <!-- User Menu -->
                        <div class="relative ml-3" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 bg-gray-50 hover:bg-gray-100 rounded-full px-4 py-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-user text-indigo-600"></i>
                                </div>
                                <span class="text-gray-700"><?= htmlspecialchars($pasien['nama']); ?></span>
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border">

                                <hr class="my-1">
                                <a href="../../logout.php" class="block px-4 py-2 text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-6 py-8">

            <!-- Riwayat Pendaftaran Poli -->
            <h2 id="riwayat" class="text-xl font-semibold mb-4">Riwayat Pendaftaran Poli</h2>
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg mb-6">
                <table class="min-w-full bg-white rounded-xl overflow-hidden shadow-lg">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">No</th>
                            <th class="py-3 px-4 text-left">Poli</th>
                            <th class="py-3 px-4 text-left">Dokter</th>
                            <th class="py-3 px-4 text-left">Keluhan</th>
                            <th class="py-3 px-4 text-left">No. Antrian</th>
                            <th class="py-3 px-4 text-left">Jadwal</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($riwayat = mysqli_fetch_assoc($result_riwayat)): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all duration-200">
                                <td class="py-3 px-4"><?= $no++; ?></td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-clinic-medical text-indigo-600 mr-2"></i>
                                        <?= htmlspecialchars($riwayat['nama_poli']); ?>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-md text-indigo-600 mr-2"></i>
                                        <?= htmlspecialchars($riwayat['dokter_nama']); ?>
                                    </div>
                                </td>
                                <td class="py-3 px-4"><?= htmlspecialchars($riwayat['keluhan']); ?></td>
                                <td class="py-3 px-4">
                                    <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-2.5 py-0.5 rounded">
                                        <?= htmlspecialchars($riwayat['no_antrian']); ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-indigo-600 mr-2"></i>
                                        <?= htmlspecialchars($riwayat['hari']) . '<br>' .
                                            htmlspecialchars($riwayat['jam_mulai']) . ' - ' .
                                            htmlspecialchars($riwayat['jam_selesai']); ?>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-full text-sm 
                                        <?= $riwayat['status_periksa'] == 'Sudah Diperiksa' ?
                                            'bg-green-100 text-green-800' :
                                            'bg-yellow-100 text-yellow-800' ?>">
                                        <?= $riwayat['status_periksa'] == 'Sudah Diperiksa' ? 'Selesai' : 'Menunggu' ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="detail_periksa.php?id=<?= $riwayat['id'] ?>"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all duration-200 text-sm">
                                        <i class="fas fa-eye mr-2"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Aksi Selanjutnya -->
            <div class="mt-8 space-y-4">
                <h2 class="text-2xl font-bold text-gray-800">Aksi Selanjutnya</h2>
                <div class="flex flex-wrap gap-4">
                    <a href="daftar_poli.php"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Daftar Poli
                    </a>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-12 py-6 bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col items-center justify-center">
                    <p class="text-gray-600">
                        © <?= date('Y') ?> Sistem Informasi Pasien
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Hak Cipta Dilindungi
                    </p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>