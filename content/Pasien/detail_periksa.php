<?php
session_start();
require_once '../../config/koneksi.php';

// Cek apakah pasien sudah login  
if (!isset($_SESSION['pasien_id'])) {
    header("Location: login_pasien.php");
    exit;
}

// Ambil ID dari URL  
$id_daftar_poli = $_GET['id'];

// Ambil detail pemeriksaan dari database  
$query_periksa = "  
    SELECT   
        dp.keluhan,  
        dp.status_periksa,  
        jp.hari,  
        jp.jam_mulai,  
        jp.jam_selesai,  
        d.nama AS dokter_nama,  
        po.nama_poli,  
        p.tgl_periksa,  
        p.catatan,  
        p.biaya_periksa  
    FROM   
        daftar_poli dp  
    JOIN   
        jadwal_periksa jp ON dp.id_jadwal = jp.id  
    JOIN   
        dokter d ON jp.id_dokter = d.id  
    JOIN   
        poli po ON d.id_poli = po.id  
    LEFT JOIN   
        periksa p ON dp.id = p.id_daftar_poli  
    WHERE   
        dp.id = '$id_daftar_poli'  
";

$result_periksa = mysqli_query($mysqli, $query_periksa);
$detail_periksa = mysqli_fetch_assoc($result_periksa);

// Cek jika detail periksa tidak ditemukan  
if (!$detail_periksa) {
    die("Detail pemeriksaan tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Periksa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Detail Pemeriksaan</h1>
        <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Pemeriksaan</h2>
            <p class="text-gray-600 mb-2"><strong>Poli:</strong> <?= htmlspecialchars($detail_periksa['nama_poli']) ?></p>
            <p class="text-gray-600 mb-2"><strong>Dokter:</strong> <?= htmlspecialchars($detail_periksa['dokter_nama']) ?></p>
            <p class="text-gray-600 mb-2"><strong>Hari:</strong> <?= htmlspecialchars($detail_periksa['hari']) ?></p>
            <p class="text-gray-600 mb-2"><strong>Jam:</strong> <?= htmlspecialchars($detail_periksa['jam_mulai']) ?> - <?= htmlspecialchars($detail_periksa['jam_selesai']) ?></p>
            <p class="text-gray-600 mb-2"><strong>Tanggal Pemeriksaan:</strong> <?= htmlspecialchars($detail_periksa['tgl_periksa']) ?></p>
            <p class="text-gray-600 mb-2"><strong>Keluhan:</strong> <?= htmlspecialchars($detail_periksa['keluhan']) ?></p>
            <p class="text-gray-600 mb-2"><strong>Status Pemeriksaan:</strong> <?= htmlspecialchars($detail_periksa['status_periksa']) ?></p>
            <p class="text-gray-600 mb-4"><strong>Catatan:</strong> <?= htmlspecialchars($detail_periksa['catatan']) ?: 'Tidak ada catatan.' ?></p>

            <!-- Menampilkan biaya -->
            <div class="bg-gray-100 p-4 rounded-lg">
                <?php if ($detail_periksa['biaya_periksa']): ?>
                    <p class="text-lg font-medium text-gray-800"><strong>Biaya yang Harus Dibayar:</strong> Rp. <?= htmlspecialchars(number_format($detail_periksa['biaya_periksa'], 0, ',', '.')) ?></p>
                <?php else: ?>
                    <p class="text-lg font-medium text-gray-800"><strong>Biaya yang Harus Dibayar:</strong> Belum ada biaya.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-6 text-center">
            <a href="dashboard_pasien.php" class="bg-blue-600 text-white py-3 px-6 rounded-lg shadow-lg hover:bg-blue-700 transition duration-300">Kembali ke Dashboard</a>
        </div>
    </div>
</body>

</html>