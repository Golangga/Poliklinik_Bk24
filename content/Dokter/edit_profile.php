<?php
session_start();
require_once '../../config/koneksi.php';

// Pastikan hanya dokter yang bisa mengakses  
if (!isset($_SESSION['id']) || $_SESSION['akses'] != 'dokter') {
    header("Location: ../login.php");
    exit();
}

// Ambil data dokter berdasarkan id yang ada di session  
$id_dokter = $_SESSION['id'];
$query = "SELECT * FROM dokter WHERE id = '$id_dokter'";
$result = mysqli_query($mysqli, $query);
$dokter = mysqli_fetch_assoc($result);

// Periksa apakah dokter ditemukan  
if (!$dokter) {
    die("Dokter tidak ditemukan.");
}

// Ambil data poli berdasarkan id_poli dokter  
$id_poli = $dokter['id_poli'];
$poli_query = "SELECT * FROM poli WHERE id = '$id_poli'";
$poli_result = mysqli_query($mysqli, $poli_query);
$poli = mysqli_fetch_assoc($poli_result);

// Periksa apakah poli ditemukan  
if (!$poli) {
    die("Data poli tidak ditemukan untuk ID Poli: " . htmlspecialchars($id_poli));
}

// Proses update profil  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $no_hp = trim($_POST['no_hp']);

    if (empty($nama) || empty($alamat)) {
        $error = "Nama dan alamat tidak boleh kosong.";
    } else {
        // Query untuk memperbarui data  
        $update_query = "UPDATE dokter SET   
            nama = '$nama',   
            alamat = '$alamat',   
            no_hp = '$no_hp'   
            WHERE id = '$id_dokter'";

        // Eksekusi query untuk memperbarui data  
        if (mysqli_query($mysqli, $update_query)) {
            $sukses = "Profil berhasil diperbarui";
            header("Location: ../../dashboard_dokter.php"); // Redirect ke profil dokter  
            exit();
        } else {
            $error = "Gagal memperbarui profil: " . mysqli_error($mysqli);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Profil Dokter</h1>

        <?php if (isset($sukses)): ?>
            <div class="bg-green-200 p-4 rounded mb-4"><?= htmlspecialchars($sukses) ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="bg-red-200 p-4 rounded mb-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label class="block mb-2">Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($dokter['nama']) ?>" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2">Alamat</label>
                <input type="text" name="alamat" value="<?= htmlspecialchars($dokter['alamat']) ?>" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2">Nomor HP</label>
                <input type="text" name="no_hp" value="<?= htmlspecialchars($dokter['no_hp']) ?>" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block mb-2">Poli</label>
                <span class="block p-2 border rounded bg-gray-200">
                    <?= htmlspecialchars($poli['nama_poli']) ?>
                </span>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Perbarui Profil</button>
        </form>
    </div>
</body>

</html>