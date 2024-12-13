<?php
session_start();
require 'config/koneksi.php'; // Pastikan koneksi database sudah benar  

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Di sini password akan diisi dengan alamat  

    // Cek login untuk admin  
    if ($username == "Admin" && password_verify($password, password_hash("admin", PASSWORD_DEFAULT))) {
        $_SESSION['username'] = $username;
        $_SESSION['akses'] = "admin";
        header("location: dashboard_admin.php");
        exit;
    } else {
        // Cek login untuk dokter  
        $query = "SELECT * FROM dokter WHERE nama = ?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);

            // Verifikasi alamat sebagai password  
            if ($password === $data['alamat']) {
                $_SESSION['id'] = $data['id'];
                $_SESSION['username'] = $data['nama'];
                $_SESSION['id_poli'] = $data['id_poli'];
                $_SESSION['akses'] = "dokter";

                header("location: dashboard_dokter.php");
                exit;
            } else {
                echo '<script>alert("Username atau password salah");location.href="login_dokter.php";</script>';
            }
        } else {
            echo '<script>alert("Username atau password salah");location.href="login_dokter.php";</script>';
        }
    }
}
