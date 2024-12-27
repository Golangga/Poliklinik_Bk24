<?php
session_start();

// Cek apakah user sudah login sebagai dokter  
if (!isset($_SESSION['username']) || $_SESSION['akses'] != 'dokter') {
    header("Location: login_dokter.php");
    exit();
}

// Koneksi ke Database  
require_once '../../config/koneksi.php';

// Ambil ID dokter dari session  
$dokter_id = $_SESSION['id'];

// Ambil daftar pasien yang terdaftar untuk pemeriksaan  
$query_pasien = "  
    SELECT dp.id, p.nama AS pasien_nama, dp.keluhan, jp.hari, jp.jam_mulai, jp.jam_selesai, dp.status_periksa   
    FROM daftar_poli dp  
    JOIN jadwal_periksa jp ON dp.id_jadwal = jp.id  
    JOIN pasien p ON dp.id_pasien = p.id  
    WHERE jp.id_dokter = '$dokter_id'  
    ORDER BY jp.hari, jp.jam_mulai";

$result_pasien = mysqli_query($mysqli, $query_pasien);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Periksa Pasien - Poliklinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Daftar Pasien untuk Diperiksa</h2>

        <!-- Tabel Daftar Pasien -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg mb-6">
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="border-b py-3 px-4 text-left">No</th>
                        <th class="border-b py-3 px-4 text-left">Nama Pasien</th>
                        <th class="border-b py-3 px-4 text-left">Keluhan</th>
                        <th class="border-b py-3 px-4 text-left">Jadwal</th>
                        <th class="border-b py-3 px-4 text-left">Status</th>
                        <th class="border-b py-3 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($pasien = mysqli_fetch_assoc($result_pasien)): ?>
                        <tr class="<?= $no % 2 ? 'bg-gray-50' : 'bg-white' ?>">
                            <td class="border py-2 px-4"><?= $no++; ?></td>
                            <td class="border py-2 px-4"><?= htmlspecialchars($pasien['pasien_nama']); ?></td>
                            <td class="border py-2 px-4"><?= htmlspecialchars($pasien['keluhan']); ?></td>
                            <td class="border py-2 px-4"><?= htmlspecialchars($pasien['hari']) . ' ' . htmlspecialchars($pasien['jam_mulai']) . ' - ' . htmlspecialchars($pasien['jam_selesai']); ?></td>

                            <!-- Kolom Status -->
                            <td class="border py-2 px-4 text-center">
                                <?php if ($pasien['status_periksa'] == 'Sudah Diperiksa'): ?>
                                    <span class="text-green-600 font-bold"> Sudah Diperiksa</span>
                                <?php else: ?>
                                    <span class="text-red-600 font-bold"> Belum Diperiksa</span>
                                <?php endif; ?>
                            </td>

                            <td class="border py-2 px-4">
                                <a href="content/Dokter/detail_periksa.php?id=<?= $pasien['id'] ?>" class="bg-blue-600 text-white py-1 px-3 rounded hover:bg-blue-700 transition duration-300">Periksa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if ($no === 1): ?>
                        <tr>
                            <td colspan="6" class="border text-center py-2">Tidak ada pasien untuk diperiksa.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>