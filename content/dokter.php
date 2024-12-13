<?php
// Sambungkan ke file koneksi  
require_once '../config/koneksi.php';

// Query untuk mengambil data dokter dengan informasi poli  
$query = "SELECT dokter.*, poli.nama_poli   
          FROM dokter   
          LEFT JOIN poli ON dokter.id_poli = poli.id   
          ORDER BY dokter.nama";
$result = mysqli_query($mysqli, $query);
?>

<div class="bg-white shadow-xl rounded-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-white flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Manajemen Dokter
        </h2>
        <a href="./content/tambah_dokter.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition duration-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fillRule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clipRule="evenodd" />
            </svg>
            Tambah Dokter
        </a>
    </div>

    <!-- Tabel Daftar Dokter -->
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="py-3 px-4 text-left rounded-tl-lg">No</th>
                        <th class="py-3 px-4 text-left">Nama</th>
                        <th class="py-3 px-4 text-left">Poli</th>
                        <th class="py-3 px-4 text-left">Alamat</th>
                        <th class="py-3 px-4 text-right rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)):
                    ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200">
                            <td class="py-4 px-4"><?= $no++ ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($row['nama']) ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($row['nama_poli'] ?? 'Belum Ditentukan') ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($row['alamat']) ?></td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <a href="content/edit_dokter.php?id=<?= $row['id'] ?>" class="text-blue-500 hover:text-blue-700 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <a href="./proses/dokter_aksi.php?aksi=hapus&id=<?= $row['id'] ?>" class="text-red-500 hover:text-red-700 transition duration-200" onclick="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');">
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