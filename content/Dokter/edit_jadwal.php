<?php
session_start();
require_once '../../config/koneksi.php';

// Pastikan hanya dokter yang bisa mengakses  
if (!isset($_SESSION['id']) || $_SESSION['akses'] != 'dokter') {
    header("Location: ../login.php");
    exit();
}

// Ambil ID jadwal dari query string  
$id_jadwal = $_GET['id'];

// Ambil data jadwal saat ini  
$query_cek_jadwal = "SELECT * FROM jadwal_periksa   
                     WHERE id = '$id_jadwal' AND id_dokter = '{$_SESSION['id']}'";
$result_cek = mysqli_query($mysqli, $query_cek_jadwal);
$jadwal = mysqli_fetch_assoc($result_cek);

if (!$jadwal) {
    // Jika jadwal tidak ditemukan atau bukan milik dokter  
    header("Location: jadwal_periksa.php");
    exit();
}

// Toggle status aktif  
$status_baru = $jadwal['status_aktif'] == 1 ? 0 : 1;

$error = ""; // Inisialisasi variabel error  

// Cek apakah ada jadwal aktif lainnya  
if ($status_baru == 0) {
    $query_active_count = "SELECT COUNT(*) as aktif_count   
                            FROM jadwal_periksa   
                            WHERE id_dokter = '{$_SESSION['id']}' AND status_aktif = 1";
    $result_active_count = mysqli_query($mysqli, $query_active_count);
    $active_count = mysqli_fetch_assoc($result_active_count)['aktif_count'];

    // Jika hanya ada satu jadwal aktif, jangan izinkan untuk dinonaktifkan  
    if ($active_count <= 1) {
        $error = "Anda harus memiliki setidaknya satu jadwal yang aktif.";
    }
}

// Jika tidak ada error dan status baru adalah aktif, nonaktifkan semua jadwal aktif lainnya  
if ($status_baru == 1 && empty($error)) {
    $query_disable_others = "UPDATE jadwal_periksa   
                              SET status_aktif = 0   
                              WHERE id_dokter = '{$_SESSION['id']}' AND status_aktif = 1";
    mysqli_query($mysqli, $query_disable_others);
}

// Update status jika tidak ada error  
if (empty($error)) {
    $update_query = "UPDATE jadwal_periksa   
                     SET status_aktif = '$status_baru'   
                     WHERE id = '$id_jadwal'";

    if (mysqli_query($mysqli, $update_query)) {
        // Redirect ke dashboard dokter setelah berhasil  
        header("Location: ../../dashboard_dokter.php");
        exit();
    } else {
        // Tampilkan error jika gagal  
        $error = "Gagal mengubah status jadwal: " . mysqli_error($mysqli);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ubah Status Jadwal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <?php if (!empty($error)): ?>
            <div class="bg-red-200 p-4 rounded mb-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <a href="../../dashboard_dokter.php" class="text-blue-500 underline">Kembali ke Dashboard Dokter</a>
    </div>
</body>

</html>