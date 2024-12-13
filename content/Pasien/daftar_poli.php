<?php
session_start();
require '../../config/koneksi.php';

// Cek apakah user sudah login sebagai pasien  
if (!isset($_SESSION['pasien_id'])) {
    header("location: ../../login_pasien.php");
    exit();
}

// Ambil data poli  
$query = "SELECT * FROM poli";
$result = mysqli_query($mysqli, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Poli</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4 text-center">Daftar Poli</h1>
        <form action="pilih_dokter.php" method="POST">
            <div class="space-y-4">
                <?php while ($poli = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <label>
                            <input type="radio" name="id_poli" value="<?= $poli['id'] ?>" required>
                            <?= htmlspecialchars($poli['nama_poli']) ?>
                        </label>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="mt-6 text-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                    Pilih Dokter
                </button>
            </div>
        </form>
    </div>
</body>

</html>