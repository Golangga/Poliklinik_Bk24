<?php
require_once '../config/koneksi.php';

// Cek apakah ID dokter ada di URL  
if (!isset($_GET['id'])) {
    header("Location: dokter.php");
    exit();
}

// Ambil ID dari URL dan bersihkan dari kemungkinan SQL injection  
$id = $mysqli->real_escape_string(intval($_GET['id']));

// Ambil data dokter dari database  
$query = "SELECT * FROM dokter WHERE id = '$id'";
$result = mysqli_query($mysqli, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: dokter.php");
    exit();
}

$dokter = mysqli_fetch_assoc($result);

// Ambil data poliklinik  
$query_poli = "SELECT id, nama_poli FROM poli"; // Ambil id dan nama_poli  
$result_poli = mysqli_query($mysqli, $query_poli);
$poliklinik = [];
while ($row = mysqli_fetch_assoc($result_poli)) {
    $poliklinik[] = $row;
}

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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokter - Poliklinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Edit Dokter</h1>
            </div>

            <form action="../proses/dokter_aksi.php" method="POST" class="p-6">
                <input type="hidden" name="aksi" value="edit">
                <input type="hidden" name="id" value="<?= $dokter['id'] ?>">

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="nama">
                        Nama Dokter <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($dokter['nama']) ?>" required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan nama Dokter">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="nama_poli">
                        Nama Poli <span class="text-red-500">*</span>
                    </label>
                    <select id="id_poli" name="id_poli" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php foreach ($poliklinik as $poli): ?>
                            <option value="<?= htmlspecialchars($poli['id']) ?>" <?php if ($dokter['id_poli'] == $poli['id']) echo 'selected'; ?>>
                                <?= htmlspecialchars($poli['nama_poli']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="alamat">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="alamat" name="alamat" value="<?= htmlspecialchars($dokter['alamat']) ?>" required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan Alamat Lengkap">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="no_hp">
                        No. Telp <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="no_hp" name="no_hp" value="<?= htmlspecialchars(formatPhoneNumber($dokter['no_hp'])) ?>" required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan No Telp">
                </div>

                <div class="flex justify-between items-center mt-6">
                    <a href="../dashboard_admin.php" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                        Kembali
                    </a>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>