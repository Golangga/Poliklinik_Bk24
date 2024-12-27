<?php
require_once './config/koneksi.php';

$success_message = ''; // Variabel untuk menyimpan pesan sukses  
$error_message = ''; // Variabel untuk menyimpan pesan kesalahan  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($mysqli, $_POST['nama']);
    $alamat = mysqli_real_escape_string($mysqli, $_POST['alamat']);
    $no_ktp = mysqli_real_escape_string($mysqli, $_POST['no_ktp']);
    $no_hp = mysqli_real_escape_string($mysqli, $_POST['no_hp']);

    // Cek apakah pasien sudah terdaftar berdasarkan no KTP  
    $query = "SELECT * FROM pasien WHERE no_ktp = '$no_ktp'";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        $error_message = 'Pasien sudah terdaftar.';
    } else {
        // Generate No RM  
        $year_month = date('Ym'); // Format tahun dan bulan  
        $query_count = "SELECT COUNT(*) as total FROM pasien WHERE created_at >= DATE_FORMAT(NOW() ,'%Y-%m-01')";
        $result_count = mysqli_query($mysqli, $query_count);
        $data_count = mysqli_fetch_assoc($result_count);
        $urutan = $data_count['total'] + 1; // Urutan pasien  

        // Format No RM  
        $no_rm = $year_month . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        // Query untuk menambah pasien  
        $query_insert = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm')";

        if (mysqli_query($mysqli, $query_insert)) {
            // Set pesan sukses  
            $success_message = "Pendaftaran berhasil!";
        } else {
            $error_message = 'Gagal mendaftar: ' . mysqli_error($mysqli);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function validateForm() {
            const nama = document.getElementById('nama').value;
            const noKtp = document.getElementById('no_ktp').value;
            const noHp = document.getElementById('no_hp').value;

            if (!nama || !noKtp || !noHp) {
                alert('Semua field harus diisi!');
                return false;
            }
            return true;
        }
    </script>
</head>

<body class="bg-gray-200">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold text-center mb-6 text-blue-600">Pendaftaran Pasien</h2>
            <form action="" method="POST" class="space-y-4" onsubmit="return validateForm()">
                <div>
                    <label class="block text-gray-700" for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700" for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700" for="no_ktp">No KTP</label>
                    <input type="text" id="no_ktp" name="no_ktp" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700" for="no_hp">No HP</label>
                    <input type="text" id="no_hp" name="no_hp" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <!-- Hapus bagian input password -->
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">Daftar</button>
            </form>

            <?php if ($success_message): ?>
                <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                    <?= $success_message; ?>
                    <a href="./login_pasien.php">
                        <button class="bg-green-500 text-white px-4 py-2 rounded mt-2">Ayo login</button>
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
                    <?= $error_message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>