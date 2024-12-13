<?php
require_once './config/koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($mysqli, $_POST['nama']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    // Query untuk mengambil data pasien berdasarkan nama  
    $query = "SELECT * FROM pasien WHERE nama = '$nama'";
    $result = mysqli_query($mysqli, $query);
    $pasien = mysqli_fetch_assoc($result);

    // Verifikasi pasien  
    if ($pasien && password_verify($password, $pasien['password'])) {
        $_SESSION['pasien_id'] = $pasien['id']; // Simpan ID pasien di session  
        header("Location: dashboard_pasien.php"); // Arahkan ke dashboard pasien  
        exit;
    } else {
        echo "<script>alert('Nama atau password salah.'); history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Login Pasien</h2>

        <form action="process_login_pasien.php" method="POST">
            <div class="mb-4">
                <label for="nama" class="block text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-500" placeholder="Masukkan nama">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-500" placeholder="Masukkan password">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition duration-200">Login</button>
        </form>

        <div class="mt-4 text-center">
            <a href="index.php" class="text-blue-500 hover:underline">Kembali ke Beranda</a>
            <p href="index.php" class="">belum punya akun? <a href="./daftar_pasien.php" class="hover:underline text-blue-500">Daftar</a></p>
        </div>
    </div>

</body>

</html>