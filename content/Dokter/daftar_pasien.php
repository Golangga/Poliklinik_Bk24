<?php
// Koneksi ke Database   
require_once '../../config/koneksi.php'; // Ganti dengan path koneksi Anda  

$query = "SELECT id, nama, alamat, no_ktp, no_hp, no_rm FROM pasien";
$result = mysqli_query($mysqli, $query);
?>

<table class="min-w-full bg-white border">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b border-gray-300 text-left">No</th>
            <th class="py-2 px-4 border-b border-gray-300 text-left">Nama Pasien</th>
            <th class="py-2 px-4 border-b border-gray-300 text-left">Alamat</th>
            <th class="py-2 px-4 border-b border-gray-300 text-left">No. KTP</th>
            <th class="py-2 px-4 border-b border-gray-300 text-left">No. Telepon</th>
            <th class="py-2 px-4 border-b border-gray-300 text-left">No. RM</th>
            <th class="py-2 px-4 border-b border-gray-300 text-left">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td class="py-2 px-4 border-b border-gray-300"><?= $no++; ?></td>
                <td class="py-2 px-4 border-b border-gray-300"><?= htmlspecialchars($row['nama']); ?></td>
                <td class="py-2 px-4 border-b border-gray-300"><?= htmlspecialchars($row['alamat']); ?></td>
                <td class="py-2 px-4 border-b border-gray-300"><?= htmlspecialchars($row['no_ktp']); ?></td>
                <td class="py-2 px-4 border-b border-gray-300"><?= htmlspecialchars($row['no_hp']); ?></td>
                <td class="py-2 px-4 border-b border-gray-300"><?= htmlspecialchars($row['no_rm']); ?></td>
                <td class="py-2 px-4 border-b border-gray-300">
                    <a href="content/dokter/riwayat_pasien.php?id=<?= $row['id']; ?>" class="text-blue-500">Detail</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>