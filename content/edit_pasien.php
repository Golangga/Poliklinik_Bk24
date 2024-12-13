<?php
session_start();

// Cek apakah user sudah login sebagai admin  
if (!isset($_SESSION['username']) || $_SESSION['akses'] != 'admin') {
    header("location: login.php");
    exit();
}

// Sambungkan ke file koneksi  
require_once '../config/koneksi.php';

// Ambil ID pasien dari URL  
$id = $_GET['id'] ?? null;

if ($id) {
    // Ambil data pasien dari database  
    $query = "SELECT * FROM pasien WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Pasien tidak ditemukan.";
        exit();
    }

    $pasien = $result->fetch_assoc();
} else {
    echo "ID pasien tidak valid.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pasien - Poliklinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Edit Data Pasien</h1>
            </div>

            <form action="../proses/pasien_aksi.php" method="POST" class="p-6">
                <input type="hidden" name="aksi" value="edit">
                <input type="hidden" name="id" value="<?= htmlspecialchars($pasien['id']) ?>">

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="nama">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            required
                            value="<?= htmlspecialchars($pasien['nama']) ?>"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan nama lengkap pasien"
                            minlength="3"
                            maxlength="255">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="alamat">
                            Alamat Lengkap
                        </label>
                        <textarea
                            id="alamat"
                            name="alamat"
                            rows="3"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan alamat lengkap (opsional)"
                            maxlength="255"><?= htmlspecialchars($pasien['alamat']) ?></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="no_ktp">
                            Nomor KTP <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="no_ktp"
                            name="no_ktp"
                            required
                            value="<?= htmlspecialchars($pasien['no_ktp']) ?>"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan nomor KTP"
                            minlength="16"
                            maxlength="16">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="no_hp">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="tel"
                            id="no_hp"
                            name="no_hp"
                            required
                            value="<?= htmlspecialchars($pasien['no_hp']) ?>"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: 08123456789"
                            minlength="10"
                            maxlength="14">
                    </div>
                </div>

                <div class="flex justify-between items-center mt-6">
                    <a href="../content/pasien.php" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Kembali</a>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>