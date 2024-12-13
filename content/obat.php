<?php
require_once '../config/koneksi.php';

// Ambil data obat dari database  
$query = "SELECT * FROM obat";
$result = mysqli_query($mysqli, $query);
?>

<div class="bg-white shadow-xl rounded-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-white flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.12 1.12.293 3.414-1.415 3.414H4.828c-1.707 0-2.535-2.293-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
            Manajemen Obat
        </h2>
        <a href="./content/tambah_obat.php" class="bg-white text-teal-600 px-4 py-2 rounded-lg hover:bg-teal-50 transition duration-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fillRule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clipRule="evenodd" />
            </svg>
            Tambah Obat
        </a>
    </div>

    <!-- Tabel Daftar Obat -->
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="py-3 px-4 text-left rounded-tl-lg">No</th>
                        <th class="py-3 px-4 text-left">Nama Obat</th>
                        <th class="py-3 px-4 text-left">Kemasan</th>
                        <th class="py-3 px-4 text-left">Harga</th>
                        <th class="py-3 px-4 text-right rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php
                    $no = 1;
                    while ($obat = mysqli_fetch_assoc($result)):
                    ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200">
                            <td class="py-4 px-4"><?= $no++ ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($obat['nama_obat']) ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($obat['kemasan']) ?></td>
                            <td class="py-4 px-4 font-semibold text-green-600">
                                Rp <?= number_format($obat['harga'], 0, ',', '.') ?>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <a href="content/edit_obat.php?id=<?= $obat['id'] ?>" class="text-blue-500 hover:text-blue-700 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <a href="./proses/obat_aksi.php?aksi=hapus&id=<?= $obat['id'] ?>" class="text-red-500 hover:text-red-700 transition duration-200" onclick="return confirm('Apakah Anda yakin ingin menghapus obat ini?');">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fillRule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clipRule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>