<?php
session_start();

// Cek apakah user sudah login sebagai admin  
if (!isset($_SESSION['username']) || $_SESSION['akses'] != 'admin') {
    header("location: login.php");
    exit();
}

// Sambungkan ke file koneksi  
require_once '../config/koneksi.php';

// Query untuk mengambil daftar poli  
$query_poli = "SELECT * FROM poli";
$result_poli = mysqli_query($mysqli, $query_poli);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dokter - Poliklinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Dokter Baru</h1>
            </div>

            <form action="../proses/dokter_aksi.php" method="POST" class="p-6">
                <input type="hidden" name="aksi" value="tambah">

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
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan nama lengkap dokter">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="id_poli">
                            Spesialisasi Poli <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="id_poli"
                            name="id_poli"
                            required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Poli</option>
                            <?php while ($poli = mysqli_fetch_assoc($result_poli)): ?>
                                <option value="<?= $poli['id'] ?>">
                                    <?= htmlspecialchars($poli['nama_poli']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
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
                            placeholder="Masukkan alamat lengkap (opsional)"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="password">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Minimal 8 karakter"
                            minlength="8">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="konfirmasi_password">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            id="konfirmasi_password"
                            name="konfirmasi_password"
                            required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ulangi password"
                            minlength="8">
                    </div>
                </div>

                <!-- Tombol Aksi -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const password = document.getElementById('password');
            const konfirmasiPassword = document.getElementById('konfirmasi_password');

            // Validasi konfirmasi password  
            form.addEventListener('submit', function(e) {
                if (password.value !== konfirmasiPassword.value) {
                    e.preventDefault();
                    alert('Konfirmasi password tidak cocok!');
                    konfirmasiPassword.focus();
                    return;
                }
            });
        });
    </script>
</body>

</html>