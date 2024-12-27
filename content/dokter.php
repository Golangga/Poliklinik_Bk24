<?php
// Sambungkan ke file koneksi  
require_once '../config/koneksi.php';

// Fungsi untuk memformat nomor telepon  
function formatPhoneNumber($number)
{
    $number = preg_replace('/\D/', '', $number); // Menghapus karakter non-digit  

    if (strlen($number) == 11 && $number[0] == '0') {
        return '+62 ' . substr($number, 1); // Menghapus angka 0 di depan  
    } elseif (strlen($number) == 12 && substr($number, 0, 2) == '62') {
        return '+' . $number; // Sudah dalam format internasional  
    }
    return $number; // Kembalikan nomor asli jika tidak sesuai  
}

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
            Manajemen Dokter
        </h2>
        <a href="./content/tambah_dokter.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition duration-300 flex items-center">
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
                        <th class="py-3 px-4 text-left">Nomor Handphone</th>
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
                            <td class="py-4 px-4"><?= htmlspecialchars(formatPhoneNumber($row['no_hp'])) ?></td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <a href="content/edit_dokter.php?id=<?= $row['id'] ?>" class="text-blue-500 hover:text-blue-700 transition duration-200">Edit</a>
                                    <a href="./proses/dokter_aksi.php?aksi=hapus&id=<?= $row['id'] ?>" class="text-red-500 hover:text-red-700 transition duration-200" onclick="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>