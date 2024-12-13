<?php
session_start();

// Cek apakah user sudah login sebagai admin  
if (!isset($_SESSION['username']) || $_SESSION['akses'] != 'admin') {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat - Poliklinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Obat Baru</h1>
            </div>

            <form action="../proses/obat_aksi.php" method="POST" class="p-6">
                <input type="hidden" name="aksi" value="tambah">

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="nama_obat">
                        Nama Obat <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_obat"
                        name="nama_obat"
                        required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan nama obat">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="kemasan">
                        Kemasan <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="kemasan"
                        name="kemasan"
                        required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukan Kemasan">
                    </label>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="harga">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="harga"
                        name="harga"
                        required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukan Harga Obat">
                    </label>
                </div>
                <div class="flex justify-between items-center mt-6">
                    <a
                        href="../dashboard_admin.php"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                        Kembali
                    </a>
                    <button
                        type="submit"
                        class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>