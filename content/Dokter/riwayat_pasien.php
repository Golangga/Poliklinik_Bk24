<?php
session_start();

// Pastikan ID pasien tersedia  
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID pasien tidak ditemukan.");
}

// Ambil ID pasien dari URL  
$pasien_id = $_GET['id'];

// Koneksi ke Database   
require_once '../../config/koneksi.php';

// Ambil data pasien  
$query_pasien = "SELECT * FROM pasien WHERE id = '$pasien_id'";
$result_pasien = mysqli_query($mysqli, $query_pasien);
$pasien = mysqli_fetch_assoc($result_pasien);

// Ambil riwayat pemeriksaan pasien  
$query_history = "  
    SELECT   
        p.tgl_periksa,  
        d.nama AS nama_dokter,  -- Mengambil nama dokter dari tabel dokter  
        dp.keluhan,  
        p.catatan,  
        GROUP_CONCAT(o.nama_obat SEPARATOR ', ') AS obat,  
        p.biaya_periksa  
    FROM   
        periksa p  
    JOIN   
        daftar_poli dp ON p.id_daftar_poli = dp.id  
    JOIN   
        jadwal_periksa j ON dp.id_jadwal = j.id  -- Menghubungkan dengan tabel jadwal  
    JOIN   
        dokter d ON j.id_dokter = d.id  -- Menghubungkan dengan tabel dokter  
    LEFT JOIN   
        detail_periksa dp_obat ON p.id = dp_obat.id_periksa  
    LEFT JOIN   
        obat o ON dp_obat.id_obat = o.id  
    WHERE   
        dp.id_pasien = '$pasien_id'  
    GROUP BY   
        p.id  
    ORDER BY   
        p.tgl_periksa DESC  
";

$result_history = mysqli_query($mysqli, $query_history);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Riwayat Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Detail Riwayat Pasien</h2>

        <?php if ($pasien): ?>
            <h3 class="text-lg font-semibold">Nama Pasien: <?= htmlspecialchars($pasien['nama']); ?></h3>
            <!-- Detail tambahan lainnya bisa ditambahkan di sini -->
            <div class="bg-white shadow-lg rounded-lg p-4">
                <?php if (mysqli_num_rows($result_history) > 0): ?>
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-300 text-left">No</th>
                                <th class="py-2 px-4 border-b border-gray-300 text-left">Tanggal Periksa</th>
                                <th class="py-2 px-4 border-b border-gray-300 text-left">Nama Dokter</th>
                                <th class="py-2 px-4 border-b border-gray-300 text-left">Keluhan</th>
                                <th class="py-2 px-4 border-b border-gray-300 text-left">Catatan</th>
                                <th class="py-2 px-4 border-b border-gray-300 text-left">Obat</th>
                                <th class="py-2 px-4 border-b border-gray-300 text-left">Biaya Periksa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($row = mysqli_fetch_assoc($result_history)): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-300"><?= $no++; ?></td>
                                    <td class="py-2 px-4 border-b border-gray-300"><?= date('d-m-Y', strtotime($row['tgl_periksa'])) ?></td>
                                    <td class="py-2 px-4 border-b border-gray-300"><?= htmlspecialchars($row['nama_dokter']) ?></td>
                                    <td class="py-2 px-4 border-b border-gray-300"><?= htmlspecialchars($row['keluhan']) ?></td>
                                    <td class="py-2 px-4 border-b border-gray-300"><?= htmlspecialchars($row['catatan']) ?></td>
                                    <td class="py-2 px-4 border-b border-gray-300"><?= htmlspecialchars($row['obat']) ?: 'Tidak ada obat' ?></td>
                                    <td class="py-2 px-4 border-b border-gray-300">Rp. <?= number_format($row['biaya_periksa'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Tidak ada riwayat pemeriksaan untuk pasien ini.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>Data pasien tidak ditemukan.</p>
        <?php endif; ?>

        <div class="mt-4">
            <a href="../../dashboard_dokter.php" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Kembali ke Daftar Pasien</a>
        </div>
    </div>
</body>

</html>