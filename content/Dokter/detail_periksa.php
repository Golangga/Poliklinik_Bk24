<?php
session_start();

// Cek apakah user sudah login sebagai dokter  
if (!isset($_SESSION['username']) || $_SESSION['akses'] != 'dokter') {
    header("Location: login_dokter.php");
    exit();
}

// Koneksi ke Database  
require_once '../../config/koneksi.php';

// Ambil ID pasien dari URL  
$pasien_id = $_GET['id'];

// Ambil detail pasien berdasarkan ID  
$query_pasien = "  
    SELECT dp.id AS daftar_id, p.nama AS pasien_nama, dp.keluhan  
    FROM daftar_poli dp  
    JOIN pasien p ON dp.id_pasien = p.id  
    WHERE dp.id = '$pasien_id'";
$result_pasien = mysqli_query($mysqli, $query_pasien);
$pasien = mysqli_fetch_assoc($result_pasien);

// Inisialisasi variabel untuk biaya  
$total_biaya = 150000; // Biaya jasa dokter  
$biaya_obat = 0; // Biaya sementara untuk obat  
$selected_obats = [];

// Cek apakah sudah ada pemeriksaan sebelumnya  
$query_periksa = "SELECT * FROM periksa WHERE id_daftar_poli = '{$pasien['daftar_id']}'";
$result_periksa = mysqli_query($mysqli, $query_periksa);
$periksa = mysqli_fetch_assoc($result_periksa);

// Jika sudah pernah diperiksa, ambil data yang ada  
if ($periksa) {
    $catatan = $periksa['catatan'];
    $total_biaya = $periksa['biaya_periksa'];

    // Ambil obat yang sudah diberikan  
    $query_detail_obat = "SELECT id_obat FROM detail_periksa WHERE id_periksa = '{$periksa['id']}'";
    $result_detail_obat = mysqli_query($mysqli, $query_detail_obat);
    while ($row = mysqli_fetch_assoc($result_detail_obat)) {
        $selected_obats[] = $row['id_obat']; // Simpan ID obat terpilih  
    }
}

// Proses form hasil pemeriksaan  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catatan = $_POST['catatan'];
    $obat_ids = $_POST['obat_ids']; // Obat yang dipilih  
    $tgl_periksa = $_POST['tgl_periksa']; // Jadwal periksa dari input  

    // Menghitung biaya obat  
    $biaya_obat = 0; // Reset biaya obat  
    if ($obat_ids) {
        foreach ($obat_ids as $obat_id) {
            $query_obat = "SELECT harga FROM obat WHERE id = '$obat_id'";
            $result_obat = mysqli_query($mysqli, $query_obat);
            $obat = mysqli_fetch_assoc($result_obat);

            $biaya_obat += $obat['harga'];
            $selected_obats[] = $obat_id; // Simpan ID obat terpilih  
        }
    }

    // Total biaya pemeriksaan  
    $total_biaya = 150000 + $biaya_obat; // Total biaya = biaya dokter + biaya obat  

    if ($periksa) {
        // Memperbarui data ke tabel pemeriksaan  
        $update_query = "  
            UPDATE periksa SET  
                tgl_periksa = '$tgl_periksa',  
                catatan = '$catatan',  
                biaya_periksa = '$total_biaya'   
            WHERE id = '{$periksa['id']}'";

        mysqli_query($mysqli, $update_query);
        $periksa_id = $periksa['id']; // Ambil ID pemeriksaan yang ada  
    } else {
        // Memasukkan data baru ke tabel pemeriksaan  
        $insert_query = "  
            INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa)   
            VALUES ('{$pasien['daftar_id']}', '$tgl_periksa', '$catatan', '$total_biaya')";

        mysqli_query($mysqli, $insert_query);
        $periksa_id = mysqli_insert_id($mysqli); // Ambil ID pemeriksaan yang baru dimasukkan  
    }

    // Menghapus detail obat lama  
    mysqli_query($mysqli, "DELETE FROM detail_periksa WHERE id_periksa = '$periksa_id'");

    // Menyimpan detail obat baru  
    foreach ($selected_obats as $obat_id) {
        mysqli_query($mysqli, "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES ('$periksa_id', '$obat_id')");
    }

    // Update status pada tabel daftar_poli jika ada pemeriksaan baru  
    if (!$periksa) {
        $update_query = "  
            UPDATE daftar_poli SET  
                status_periksa = 'Sudah Diperiksa'  
            WHERE id = '{$pasien['daftar_id']}'";
        mysqli_query($mysqli, $update_query);
    }

    // Redirect ke halaman daftar pasien  
    header("Location: ../../dashboard_dokter.php");
    exit();
}

// Mengambil daftar obat dari tabel obat  
$query_obat = "SELECT id, nama_obat, harga FROM obat";
$result_obat = mysqli_query($mysqli, $query_obat);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Periksa - Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function updateTotal() {
            var totalBiaya = 150000; // Biaya dokter  
            var checkboxes = document.querySelectorAll('input[name="obat_ids[]"]:checked');
            checkboxes.forEach((checkbox) => {
                var harga = parseInt(checkbox.getAttribute('data-harga'));
                totalBiaya += harga;
            });
            document.getElementById('total_biaya').value = totalBiaya.toLocaleString('id-ID');
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Detail Pemeriksaan Pasien</h2>

        <!-- Informasi Pasien -->
        <div class="bg-white shadow-lg rounded-lg p-4 mb-6">
            <h3 class="text-lg font-semibold">Informasi Pasien</h3>
            <p><strong>Nama Pasien:</strong> <?= htmlspecialchars($pasien['pasien_nama']); ?></p>
            <p><strong>Keluhan:</strong> <?= htmlspecialchars($pasien['keluhan']); ?></p>
        </div>

        <!-- Formulir Hasil Pemeriksaan -->
        <div class="bg-white shadow-lg rounded-lg p-4">
            <h3 class="text-lg font-semibold">Formulir Hasil Pemeriksaan</h3>
            <form action="" method="POST">
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" required><?= htmlspecialchars($catatan ?? ''); ?></textarea>
                </div>
                <div class="mb-4">
                    <h4 class="text-md font-semibold">Obat yang diresepkan</h4>
                    <?php while ($obat = mysqli_fetch_assoc($result_obat)): ?>
                        <div>
                            <input type="checkbox" id="obat_<?= $obat['id'] ?>" name="obat_ids[]" value="<?= $obat['id'] ?>" data-harga="<?= $obat['harga'] ?>" onchange="updateTotal()" <?= in_array($obat['id'], $selected_obats) ? 'checked' : ''; ?>>
                            <label for="obat_<?= $obat['id'] ?>"><?= htmlspecialchars($obat['nama_obat']) . ' - Rp. ' . htmlspecialchars(number_format($obat['harga'], 0, ',', '.')); ?></label>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="mb-4">
                    <label for="tgl_periksa" class="block text-sm font-medium text-gray-700">Tanggal Periksa</label>
                    <input type="date" id="tgl_periksa" name="tgl_periksa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" value="<?= htmlspecialchars($periksa['tgl_periksa'] ?? ''); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="total_biaya" class="block text-sm font-medium text-gray-700">Total Biaya Periksa</label>
                    <input type="text" id="total_biaya" name="total_biaya" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" value="<?= number_format($total_biaya, 0, ',', '.') ?>" readonly>
                </div>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">Simpan</button>
            </form>
        </div>
    </div>
</body>

</html>