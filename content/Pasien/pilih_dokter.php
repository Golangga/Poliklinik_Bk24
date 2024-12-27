<?php
session_start();
require_once '../../config/koneksi.php';

// Cek apakah pasien sudah terdaftar  
if (!isset($_SESSION['pasien_id'])) {
    header("Location: daftar_pasien.php");
    exit;
}

// Ambil ID poli dari parameter GET  
$poli_id = $_GET['poli_id'] ?? null;

if (!$poli_id) {
    header("Location: pilih_poli.php");
    exit;
}

// Ambil daftar dokter berdasarkan poli  
$query = "  
    SELECT d.*, p.nama_poli   
    FROM dokter d  
    JOIN poli p ON d.id_poli = p.id  
    WHERE d.id_poli = '$poli_id'  
";
$result = mysqli_query($mysqli, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Dokter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-green-500 text-white p-4">
                <h1 class="text-2xl font-bold">Pilih Dokter</h1>
            </div>
            <div class="p-6">
                <form action="konfirmasi_pendaftaran.php" method="GET">
                    <input type="hidden" name="poli_id" value="<?= htmlspecialchars($poli_id) ?>">
                    <?php while ($dokter = mysqli_fetch_assoc($result)): ?>
                        <div class="mb-4">
                            <input type="radio" name="dokter_id" value="<?= $dokter['id'] ?>" required>
                            <label class="text-gray-700"><?= htmlspecialchars($dokter['nama']) ?></label>
                        </div>
                    <?php endwhile; ?>
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded">Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>