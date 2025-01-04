<?php
session_start();
require_once '../../config/koneksi.php';

// Cek apakah pasien sudah login  
if (!isset($_SESSION['pasien_id'])) {
    header("Location: login_pasien.php");
    exit;
}

// Ambil data pasien  
$pasien_id = $_SESSION['pasien_id'];
$query_pasien = "SELECT * FROM pasien WHERE id = '$pasien_id'";
$result_pasien = mysqli_query($mysqli, $query_pasien);
$pasien = mysqli_fetch_assoc($result_pasien);

// Ambil daftar poli  
$query_poli = "SELECT * FROM poli";
$result_poli = mysqli_query($mysqli, $query_poli);
if (!$result_poli) {
    die("Error fetching poli: " . mysqli_error($mysqli));
}

$selected_poli_id = isset($_POST['id_poli']) ? $_POST['id_poli'] : '';
$selected_jadwal_id = isset($_POST['id_jadwal']) ? $_POST['id_jadwal'] : '';

// Ambil jadwal jika poli dipilih  
$jadwal_array = [];
if ($selected_poli_id) {
    $query_jadwal = "  
        SELECT jp.id AS jadwal_id, p.nama_poli, d.nama AS dokter_nama, jp.hari, jp.jam_mulai, jp.jam_selesai  
        FROM jadwal_periksa jp  
        JOIN dokter d ON jp.id_dokter = d.id  
        JOIN poli p ON d.id_poli = p.id  
        WHERE jp.status_aktif = 1 AND p.id = '$selected_poli_id'";

    $result_jadwal = mysqli_query($mysqli, $query_jadwal);
    if (!$result_jadwal) {
        die("Error fetching jadwal: " . mysqli_error($mysqli));
    }

    while ($jadwal = mysqli_fetch_assoc($result_jadwal)) {
        $jadwal_array[] = $jadwal;
    }
}

// Proses pendaftaran  
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($selected_jadwal_id)) {
    $keluhan = $_POST['keluhan'];

    // Memvalidasi ID jadwal  
    $check_jadwal_query = "SELECT * FROM jadwal_periksa WHERE id = '$selected_jadwal_id' AND status_aktif = 1";
    $check_result = mysqli_query($mysqli, $check_jadwal_query);

    if (mysqli_num_rows($check_result) == 0) {
        echo "Error: ID jadwal tidak ditemukan atau tidak aktif.";
        exit;
    }

    // Ambil nomor antrian berikutnya  
    $query_antrian = "SELECT COALESCE(MAX(no_antrian), 0) + 1 AS antrian FROM daftar_poli";
    $result_antrian = mysqli_query($mysqli, $query_antrian);
    $antrian = mysqli_fetch_assoc($result_antrian)['antrian'];

    // Simpan ke dalam tabel daftar_poli  
    $query_daftar = "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian) VALUES ('$pasien_id', '$selected_jadwal_id', '$keluhan', '$antrian')";

    if (mysqli_query($mysqli, $query_daftar)) {
        header("Location: konfirmasi_pendaftaran.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Poli</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        select,
        textarea {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }
    </style>
</head>

<body class="flex items-center justify-center p-6">
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-8 max-w-md w-full shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-hospital-user text-4xl text-indigo-600"></i>
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Pendaftaran Poli
            </h2>
        </div>

        <form method="POST" class="space-y-6">
            <div>
                <label for="poli" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-clinic-medical mr-2"></i>Pilih Poli
                </label>
                <select id="poli" name="id_poli" onchange="this.form.submit()" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all appearance-none">
                    <option value="">Pilih Poli</option>
                    <?php while ($poli = mysqli_fetch_assoc($result_poli)): ?>
                        <option value="<?= htmlspecialchars($poli['id']); ?>"
                            <?= ($poli['id'] == $selected_poli_id) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($poli['nama_poli']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label for="jadwal" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt mr-2"></i>Pilih Jadwal
                </label>
                <select id="jadwal" name="id_jadwal" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all appearance-none">
                    <option value="">Pilih Jadwal</option>
                    <?php if (empty($jadwal_array)): ?>
                        <option value="">Tidak ada jadwal tersedia</option>
                    <?php else: ?>
                        <?php foreach ($jadwal_array as $jadwal): ?>
                            <option value="<?= htmlspecialchars($jadwal['jadwal_id']); ?>"
                                <?= ($jadwal['jadwal_id'] == $selected_jadwal_id) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($jadwal['dokter_nama']) . ' - ' .
                                    htmlspecialchars($jadwal['hari']) . ' ' .
                                    htmlspecialchars($jadwal['jam_mulai']) . ' - ' .
                                    htmlspecialchars($jadwal['jam_selesai']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label for="keluhan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-notes-medical mr-2"></i>Keluhan
                </label>
                <textarea id="keluhan" name="keluhan" rows="3"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all"
                    placeholder="Deskripsikan keluhan Anda..." required></textarea>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 px-6 rounded-lg
                hover:opacity-90 transition-all duration-300 flex items-center justify-center">
                <i class="fas fa-paper-plane mr-2"></i>
                Daftar Sekarang
            </button>
        </form>
    </div>
</body>

</html>