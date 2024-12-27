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

// Ambil data poli untuk ditampilkan  
$poli_query = "SELECT * FROM poli WHERE id = (SELECT id_poli FROM dokter WHERE id = '$id_dokter')";
$poli_result = mysqli_query($mysqli, $poli_query);
$poli = mysqli_fetch_assoc($poli_result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Profil Dokter</h1>

        <div class="mb-4">
            <label class="block mb-2">Nama</label>
            <span class="block p-2 border rounded bg-gray-200">
                <?= htmlspecialchars($dokter['nama']) ?>
            </span>
        </div>
        <div class="mb-4">
            <label class="block mb-2">Alamat</label>
            <span class="block p-2 border rounded bg-gray-200">
                <?= htmlspecialchars($dokter['alamat']) ?>
            </span>
        </div>
        <div class="mb-4">
            <label class="block mb-2">Nomor HP</label>
            <span class="block p-2 border rounded bg-gray-200">
                <?= htmlspecialchars($dokter['no_hp']) ?>
            </span>
        </div>
        <div class="mb-4">
            <label class="block mb-2">Poli</label>
            <span class="block p-2 border rounded bg-gray-200">
                <?= htmlspecialchars($poli['nama_poli']) ?>
            </span>
        </div>

        <a href="content/Dokter/edit_profile.php" class="bg-blue-500 text-white px-4 py-2 rounded">Edit Profil</a>
    </div>
</body>

</html>