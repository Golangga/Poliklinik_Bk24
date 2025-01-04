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
$query_periksa = "SELECT dp.keluhan, dp.status_periksa, jp.hari, jp.jam_mulai, jp.jam_selesai, 
                         d.nama AS dokter_nama, po.nama_poli, p.tgl_periksa, p.catatan, p.biaya_periksa  
                  FROM daftar_poli dp  
                  JOIN jadwal_periksa jp ON dp.id_jadwal = jp.id  
                  JOIN dokter d ON jp.id_dokter = d.id  
                  JOIN poli po ON d.id_poli = po.id  
                  LEFT JOIN periksa p ON dp.id = p.id_daftar_poli  
                  WHERE dp.id = ?";

$stmt = $mysqli->prepare($query_periksa);
$stmt->bind_param("i", $id_daftar_poli);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Cek jika detail periksa tidak ditemukan  
if (!$data) {
    die("Detail pemeriksaan tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemeriksaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
    </style>
</head>

<body class="flex items-center justify-center p-6">
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-8 max-w-2xl w-full shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-file-medical text-4xl text-indigo-600"></i>
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Detail Pemeriksaan
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2"><i class="fas fa-clinic-medical mr-2"></i>Poli</h3>
                    <p class="text-gray-600"><?= htmlspecialchars($data['nama_poli'] ?? '-') ?></p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2"><i class="fas fa-user-md mr-2"></i>Dokter</h3>
                    <p class="text-gray-600"><?= htmlspecialchars($data['dokter_nama'] ?? '-') ?></p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2"><i class="fas fa-calendar-day mr-2"></i>Jadwal</h3>
                    <p class="text-gray-600">
                        <?= htmlspecialchars($data['hari'] ?? '-') ?><br>
                        <?= htmlspecialchars($data['jam_mulai'] ?? '-') ?> - <?= htmlspecialchars($data['jam_selesai'] ?? '-') ?>
                    </p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2"><i class="fas fa-calendar-check mr-2"></i>Tanggal Pemeriksaan</h3>
                    <p class="text-gray-600"><?= $data['tgl_periksa'] ? date('d/m/Y', strtotime($data['tgl_periksa'])) : '-' ?></p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2"><i class="fas fa-notes-medical mr-2"></i>Keluhan</h3>
                    <p class="text-gray-600"><?= htmlspecialchars($data['keluhan'] ?? '-') ?></p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2"><i class="fas fa-clipboard-check mr-2"></i>Status Pemeriksaan</h3>
                    <span class="px-3 py-1 rounded-full text-sm <?= $data['status_periksa'] == 'Sudah Diperiksa' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                        <?= $data['status_periksa'] == 'Sudah Diperiksa' ? 'Sudah Diperiksa' : 'Belum Diperiksa' ?>
                    </span>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2"><i class="fas fa-file-medical-alt mr-2"></i>Catatan</h3>
                    <p class="text-gray-600"><?= htmlspecialchars($data['catatan'] ?? 'Tidak ada catatan.') ?></p>
                </div>

                <?php if ($data['biaya_periksa']): ?>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-gray-700 mb-2"><i class="fas fa-money-bill-wave mr-2"></i>Biaya</h3>
                        <p class="text-gray-600">Rp <?= number_format($data['biaya_periksa'], 0, ',', '.') ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="dashboard_pasien.php" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Riwayat
            </a>
        </div>
    </div>
</body>

</html>