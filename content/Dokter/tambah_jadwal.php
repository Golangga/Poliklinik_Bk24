<?php
session_start();
require_once '../../config/koneksi.php';

// Pastikan hanya dokter yang bisa mengakses  
if (!isset($_SESSION['id']) || $_SESSION['akses'] != 'dokter') {
    header("Location: ../login.php");
    exit();
}

// Proses tambah jadwal  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $id_dokter = $_SESSION['id']; // Ambil ID dokter dari session  

    // Validasi waktu  
    if (strtotime($jam_mulai) >= strtotime($jam_selesai)) {
        $error = "Jam mulai harus lebih awal dari jam selesai.";
    } else {
        // Cek jika ada jadwal yang tumpang tindih  
        $query_check = "SELECT * FROM jadwal_periksa WHERE id_dokter = '$id_dokter' AND hari = '$hari' AND (  
                            (jam_mulai < '$jam_selesai' AND jam_selesai > '$jam_mulai')  
                        )";
        $result_check = mysqli_query($mysqli, $query_check);

        if (mysqli_num_rows($result_check) > 0) {
            $error = "Jadwal ini sudah ada. Silakan pilih waktu yang berbeda.";
        } else {
            // Nonaktifkan semua jadwal aktif milik dokter tersebut sebelum menambah yang baru  
            $query_disable_others = "UPDATE jadwal_periksa SET status_aktif = 0 WHERE id_dokter = '$id_dokter' AND status_aktif = 1";
            mysqli_query($mysqli, $query_disable_others);

            // Query untuk menambah jadwal  
            $insert_query = "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai, status_aktif)   
                             VALUES ('$id_dokter', '$hari', '$jam_mulai', '$jam_selesai', 1)";

            if (mysqli_query($mysqli, $insert_query)) {
                // Redirect ke dashboard dokter dengan pesan sukses  
                header("Location: ../../dashboard_dokter.php?message=jadwal_tambah_sukses");
                exit();
            } else {
                $error = "Gagal menambahkan jadwal: " . mysqli_error($mysqli);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Periksa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-blue-500 text-white p-4">
                <h1 class="text-2xl font-bold">Tambah Jadwal Periksa</h1>
            </div>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="p-6">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Hari</label>
                    <select name="hari" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="w-full p-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="w-full p-2 border rounded" required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Tambah Jadwal
                    </button>
                    <a href="../../dashboard_dokter.php" class="text-blue-500 hover:text-blue-700">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Validasi form sebelum submit  
        document.querySelector('form').addEventListener('submit', function(e) {
            const hari = document.querySelector('select[name="hari"]').value;
            const jamMulai = document.querySelector('input[name="jam_mulai"]').value;
            const jamSelesai = document.querySelector('input[name="jam_selesai"]').value;

            if (!hari) {
                e.preventDefault();
                alert('Silakan pilih hari.');
                return;
            }

            if (!jamMulai || !jamSelesai) {
                e.preventDefault();
                alert('Silakan isi jam mulai dan jam selesai.');
                return;
            }

            if (new Date('1990-01-01T' + jamMulai) >= new Date('1990-01-01T' + jamSelesai)) {
                e.preventDefault();
                alert('Jam mulai harus lebih awal dari jam selesai.');
            }
        });
    </script>
</body>

</html>