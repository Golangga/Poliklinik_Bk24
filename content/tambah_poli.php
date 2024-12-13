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
    <title>Tambah Poli - Poliklinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Poli Baru</h1>
            </div>

            <form action="../proses/poli_aksi.php" method="POST" class="p-6">
                <input type="hidden" name="aksi" value="tambah">

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="nama_poli">
                            Nama Poli <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama_poli"
                            name="nama_poli"
                            required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan nama poli"
                            maxlength="25">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="keterangan">
                            Keterangan
                        </label>
                        <textarea
                            id="keterangan"
                            name="keterangan"
                            rows="3"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan keterangan (opsional)"></textarea>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-6">
                    <a href="../dashboard_admin.php" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Kembali</a>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>