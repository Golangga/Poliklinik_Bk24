<?php
session_start();
require '../../config/koneksi.php';

// Cek apakah user sudah login sebagai pasien  
if (!isset($_SESSION['pasien_id'])) {
    header("location: ../../login_pasien.php");
    exit();
}

// Ambil id_poli dari form  
$id_poli = $_POST['id_poli'] ?? null;
if (!$id_poli) {
    header("location: daftar_poli.php");
    exit();
}

// Ambil data dokter berdasarkan poli  
$query = "SELECT * FROM dokter WHERE id_poli = ?";
$stmt = mysqli_prepare($mysqli, $query);
mysqli_stmt_bind_param($stmt, 'i', $id_poli);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4 text-center">Pilih Dokter</h1>
        <form action="konfirmasi_pendaftaran.php" method="POST">
            <input type="hidden" name="id_poli" value="<?= htmlspecialchars($id_poli) ?>">
            <div class="space-y-4">
                <?php while ($dokter = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <label>
                            <input type="radio" name="id_jadwal" value="<?= $dokter['id'] ?>" required>
                            <?= htmlspecialchars($dokter['nama']) ?>
                        </label>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="mt-6 text-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                    Konfirmasi Pendaftaran
                </button>
            </div>
        </form>
    </div>
</body>

</html>