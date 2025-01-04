<?php
require_once './config/koneksi.php';
session_start();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .login-container {
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
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-4">
    <div class="login-container bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl w-96">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-hospital-user text-4xl text-indigo-600"></i>
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Login Pasien</h2>
            <p class="text-gray-500 mt-2">Silakan masuk ke akun Anda</p>
        </div>

        <form action="process_login_pasien.php" method="POST" class="space-y-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-user mr-2"></i>Nama
                </label>
                <input type="text" id="nama" name="nama" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all"
                    placeholder="Masukkan Nama">
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <input type="password" id="alamat" name="alamat" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all"
                    placeholder="Masukkan Password">
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 rounded-lg hover:opacity-90 transition-all duration-300 flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Masuk
            </button>
        </form>

        <div class="mt-6 text-center space-y-2">
            <a href="index.php"
                class="block text-indigo-600 hover:text-indigo-800 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
            </a>
            <p class="text-gray-600">
                Belum punya akun?
                <a href="./daftar_pasien.php"
                    class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline transition-all">
                    Daftar
                </a>
            </p>
        </div>
    </div>
</body>

</html>