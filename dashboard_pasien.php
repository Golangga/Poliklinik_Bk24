<?php
session_start();
require_once './config/koneksi.php';

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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden animate-fade-in">
            <!-- Header Dashboard -->
            <div class="bg-blue-600 text-white p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Dashboard Pasien</h2>
                    <p class="text-blue-100">Selamat datang di sistem informasi pasien</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm">
                        <i class="ri-user-line mr-2"></i>
                        <?= htmlspecialchars($pasien['nama']); ?>
                    </span>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-300 flex items-center">
                        <i class="ri-logout-circle-line mr-2"></i>Keluar
                    </a>
                </div>
            </div>

            <!-- Informasi Pasien -->
            <div class="grid md:grid-cols-2 gap-6 p-6">
                <!-- Kartu Profil -->
                <div class="bg-blue-50 rounded-xl p-6 space-y-4">
                    <div class="text-center">
                        <i class="ri-user-3-line text-6xl text-blue-500 mb-4 block"></i>
                        <h3 class="text-xl font-semibold text-blue-800"><?= htmlspecialchars($pasien['nama']); ?></h3>
                        <p class="text-blue-600">No Rekam Medis: <?= htmlspecialchars($pasien['no_rm']); ?></p>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="ri-map-pin-line mr-3 text-blue-500 text-xl"></i>
                            <span class="text-gray-700"><?= htmlspecialchars($pasien['alamat']); ?></span>
                        </div>
                        <div class="flex items-center">
                            <i class="ri-smartphone-line mr-3 text-blue-500 text-xl"></i>
                            <span class="text-gray-700"><?= htmlspecialchars($pasien['no_hp']); ?></span>
                        </div>
                        <div class="flex items-center">
                            <i class="ri-id-card-line mr-3 text-blue-500 text-xl"></i>
                            <span class="text-gray-700"><?= htmlspecialchars($pasien['no_ktp']); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Kartu Aksi -->
                <div class="bg-blue-50 rounded-xl p-6 space-y-4">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">
                        <i class="ri-settings-3-line mr-2 text-blue-500"></i>Aksi Tersedia
                    </h3>

                    <div class="space-y-3">
                        <a href="edit_profil.php" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg flex items-center justify-center transition duration-300">
                            <i class="ri-edit-line mr-2"></i>Edit Profil
                        </a>

                        <a href="ubah_password.php" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg flex items-center justify-center transition duration-300">
                            <i class="ri-lock-line mr-2"></i>Ubah Password
                        </a>

                        <button onclick="window.print()" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg flex items-center justify-center transition duration-300">
                            <i class="ri-printer-line mr-2"></i>Cetak Profil
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-blue-100 p-4 text-center text-blue-800">
                <p>© <?= date('Y') ?> Sistem Informasi Pasien. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </div>
</body>

</html>