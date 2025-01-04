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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .form-container {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        input:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6">
    <div class="form-container bg-white/95 backdrop-blur-sm rounded-2xl p-8 max-w-md w-full shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-plus text-4xl text-indigo-600"></i>
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Pendaftaran Pasien
            </h2>
            <p class="text-gray-500 mt-2">Silakan lengkapi data diri Anda</p>
        </div>

        <?php if ($success_message): ?>
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-700"><?= $success_message ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-700"><?= $error_message ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-user mr-2"></i>Nama Lengkap
                </label>
                <input type="text" name="nama" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all"
                    placeholder="Masukkan nama lengkap">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-id-card mr-2"></i>Nomor KTP
                </label>
                <input type="text" name="no_ktp" required pattern="[0-9]{16}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all"
                    placeholder="Masukkan 16 digit nomor KTP">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-phone mr-2"></i>Nomor HP
                </label>
                <input type="tel" name="no_hp" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all"
                    placeholder="Masukkan nomor HP">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fa-solid fa-location-dot mr-2"></i>Alamat
                </label>
                <input type="text" name="alamat" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all"
                    placeholder="Masukkan alamat">
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 rounded-lg hover:opacity-90 transition-all duration-300 flex items-center justify-center">
                <i class="fas fa-user-plus mr-2"></i>
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="login_pasien.php" class="text-indigo-600 hover:text-indigo-800 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Login
            </a>
        </div>
    </div>
</body>

</html>