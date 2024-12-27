<?php
session_start();
require_once '../../config/koneksi.php';

// Pastikan hanya dokter yang bisa mengakses  
if (!isset($_SESSION['id']) || $_SESSION['akses'] != 'dokter') {
    header("Location: ../login.php");
    exit();
}

// Ambil ID dokter dari session  
$id_dokter = $_SESSION['id'];

// Ambil jadwal periksa dokter  
$query_jadwal = "SELECT * FROM jadwal_periksa WHERE id_dokter = '$id_dokter'";
$result_jadwal = mysqli_query($mysqli, $query_jadwal);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Jadwal Periksa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Jadwal Periksa</h1>
            <a href="content/dokter/tambah_jadwal.php" class="bg-blue-500 text-white px-4 py-2 rounded">
                Tambah Jadwal Baru
            </a>
        </div>

        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">Hari</th>
                    <th class="p-3 text-left">Jam Mulai</th>
                    <th class="p-3 text-left">Jam Selesai</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($jadwal = mysqli_fetch_assoc($result_jadwal)): ?>
                    <tr class="border-b">
                        <td class="p-3"><?= htmlspecialchars($jadwal['hari']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($jadwal['jam_mulai']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($jadwal['jam_selesai']) ?></td>
                        <td class="p-3">
                            <?= $jadwal['status_aktif'] == 1
                                ? '<span class="text-green-500">Aktif</span>'
                                : '<span class="text-red-500">Tidak Aktif</span>'
                            ?>
                        </td>
                        <td class="p-3">
                            <a href="content/dokter/edit_jadwal.php?id=<?= $jadwal['id'] ?>&status=<?= $jadwal['status_aktif'] == 1 ? 0 : 1 ?>" class="text-blue-500">
                                <?= $jadwal['status_aktif'] == 1 ? 'Nonaktifkan' : 'Aktifkan' ?>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>