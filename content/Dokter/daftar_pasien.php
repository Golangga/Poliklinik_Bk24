<?php
session_start();
require '../../config/koneksi.php';

// Cek apakah user sudah login sebagai dokter  
if (!isset($_SESSION['username']) || $_SESSION['akses'] != 'dokter') {
    header("location: login_dokter.php");
    exit();
}

// Ambil daftar pasien yang dijadwalkan untuk dokter ini  
$id_dokter = $_SESSION['id'];
$query = "SELECT p.*, jp.waktu FROM pasien p  
          JOIN jadwal_periksa jp ON p.id = jp.id_pasien  
          WHERE jp.id_dokter = ? AND jp.status = 'pending'";
$stmt = mysqli_prepare($mysqli, $query);
mysqli_stmt_bind_param($stmt, 'i', $id_dokter);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pasien - Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Daftar Pasien</h1>
            </div>
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">#</th>
                        <th class="py-2 px-4 border-b">Nama Pasien</th>
                        <th class="py-2 px-4 border-b">Waktu Periksa</th>
                        <th class="py-2 px-4 border-b">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pasien = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?= $pasien['id'] ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($pasien['nama']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($pasien['waktu']) ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="riwayat_pasien.php?id=<?= $pasien['id'] ?>" class="text-blue-500 hover:underline">Lihat Riwayat</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>