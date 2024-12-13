<?php
session_start();
require '../../config/koneksi.php';

// Cek apakah user sudah login sebagai pasien  
if (!isset($_SESSION['pasien_id'])) {
    header("location: ../../login_pasien.php");
    exit();
}

// Ambil data pasien  
$query = "SELECT * FROM pasien WHERE id = ?";
$stmt = mysqli_prepare($mysqli, $query);
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['pasien_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pasien = mysqli_fetch_assoc($result);

// Ambil jumlah poli  
$query_poli = "SELECT COUNT(*) as total_poli FROM poli";
$result_poli = mysqli_query($mysqli, $query_poli);
$total_poli = mysqli_fetch_assoc($result_poli)['total_poli'];
$query = "SELECT p.*, d.nama AS nama_dokter, pol.nama_poli   
          FROM daftar_poli p   
          JOIN dokter d ON p.id_jadwal = d.id   
          JOIN poli pol ON d.id_poli = pol.id   
          WHERE p.id_pasien = ?   
          ORDER BY p.id DESC   
          LIMIT 1";


$stmt = mysqli_prepare($mysqli, $query);
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['pasien_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pendaftaran = mysqli_fetch_assoc($result);




// Jika tidak ada pendaftaran, tampilkan pesan  

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Sidebar Navigasi -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <div class="text-center">
                        <div class="w-32 h-32 rounded-full bg-blue-100 mx-auto mb-4 flex items-center justify-center shadow-md">
                            <i data-feather="user" class="w-16 h-16 text-blue-500"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($pasien['nama']) ?></h2>
                        <p class="text-gray-600 mt-2">Pasien Terdaftar</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <nav>
                        <ul class="space-y-4">
                            <li>
                                <a href="dashboard_pasien.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200 group">
                                    <i data-feather="home" class="mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="profil_saya.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200 group">
                                    <i data-feather="user" class="mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                    Profil Saya
                                </a>
                            </li>
                            <li>
                                <a href="jadwal_konsultasi.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200 group">
                                    <i data-feather="calendar" class="mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                    Jadwal Konsultasi
                                </a>
                            </li>
                            <li>
                                <a href="daftar_poli.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200 group">
                                    <i data-feather="clipboard" class="mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                    Pilih Poli
                                </a>
                            </li>
                            <li>
                                <a href="pilih_dokter.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200 group">
                                    <i data-feather="user" class="mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                    Pilih Dokter
                                </a>
                            </li>
                            <li>
                                <a href="jadwal_dokter.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200 group">
                                    <i data-feather="calendar" class="mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                    Jadwal Dokter
                                </a>
                            </li>
                            <li>
                                <a href="konfirmasi_pendaftaran.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200 group">
                                    <i data-feather="check-circle" class="mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                    Konfirmasi Pendaftaran
                                </a>
                            </li>
                            <li>
                                <a href="konfirmasi_berhasil.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200 group">
                                    <i data-feather="check-circle" class="mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                    Konfirmasi Berhasil
                                </a>
                            </li>
                            <li>
                                <a href="../../logout.php" class="flex items-center text-red-500 hover:text-red-600 transition duration-200 group">
                                    <i data-feather="log-out" class="mr-3 text-red-400 group-hover:text-red-500"></i>
                                    Keluar
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="md:col-span-2 space-y-6">
                <!-- Kartu Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-gray-500 text-sm uppercase">Total Poli</h3>
                                <p class="text-3xl font-bold text-blue-600"><?= $total_poli ?></p>
                            </div>
                            <i data-feather="layers" class="text-blue-500 w-10 h-10"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-gray-500 text-sm uppercase">Nomor Rekam Medis</h3>
                                <p class="text-3xl font-bold text-green-600"><?= htmlspecialchars($pasien['no_rm']) ?></p>
                            </div>
                            <i data-feather="clipboard" class="text-green-500 w-10 h-10"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-gray-500 text-sm uppercase">Status</h3>
                                <p class="text-xl font-bold text-purple-600">Aktif</p>
                            </div>
                            <i data-feather="check-circle" class="text-purple-500 w-10 h-10"></i>
                        </div>
                    </div>
                </div>

                <!-- Daftar Poli
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class=" justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold mb-4">Informasi Pendaftaran</h2>
                        <p><strong>Poli:</strong> <?= htmlspecialchars($pendaftaran['nama_poli']) ?></p>
                        <p><strong>Dokter:</strong> <?= htmlspecialchars($pendaftaran['nama_dokter']) ?></p>
                        <p><strong>Keluhan:</strong> <?= htmlspecialchars($pendaftaran['keluhan']) ?></p>
                        <p><strong>Nomor Antrian:</strong> <?= htmlspecialchars($pendaftaran['no_antrian']) ?></p>
                        <p><strong>Status:</strong> Pendaftaran berhasil.</p>
                    </div>
                </div> -->

                <!-- Informasi Pribadi -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Informasi Pribadi</h2>
                        <a href="#" class="text-blue-500 hover:underline text-sm">Edit Profil</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-700">Nama Lengkap</h3>
                            <p class="text-gray-600"><?= htmlspecialchars($pasien['nama']) ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700">Nomor KTP</h3>
                            <p class="text-gray-600"><?= htmlspecialchars($pasien['no_ktp'] ?? 'Tidak tersedia') ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700">Alamat</h3>
                            <p class="text-gray-600"><?= htmlspecialchars($pasien['alamat'] ?? 'Tidak tersedia') ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700">Tanggal Terdaftar</h3>
                            <p class="text-gray-600">
                                <?= !empty($pasien['created_at']) ? date('d M Y', strtotime($pasien['created_at'])) : 'Tidak tersedia' ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Aktifkan ikon Feather  
        feather.replace();
    </script>
</body>

</html>