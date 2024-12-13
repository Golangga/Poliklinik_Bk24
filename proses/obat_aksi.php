<?php
require_once '../config/koneksi.php';

// Cek aksi yang dilakukan  
if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    if ($aksi == 'hapus') {
        $id = intval($_GET['id']);
        $query = "DELETE FROM obat WHERE id = $id";
        if (mysqli_query($mysqli, $query)) {
            // Arahkan kembali ke halaman obat  
            header("Location: ../dashboard_admin.php");
            exit;
        } else {
            echo "<script>alert('Gagal menghapus data: " . mysqli_error($mysqli) . "'); history.back();</script>";
        }
    }
}

// Proses tambah dan edit obat  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aksi = $_POST['aksi'];
    $nama_obat = mysqli_real_escape_string($mysqli, $_POST['nama_obat']);
    $kemasan = mysqli_real_escape_string($mysqli, $_POST['kemasan']);
    $harga = floatval($_POST['harga']); // Menambahkan harga  

    if ($aksi == 'tambah') {
        $query = "INSERT INTO obat (nama_obat, kemasan, harga) VALUES ('$nama_obat', '$kemasan', $harga)";
    } else if ($aksi == 'edit') {
        $id = intval($_POST['id']);
        $query = "UPDATE obat SET nama_obat = '$nama_obat', kemasan = '$kemasan', harga = $harga WHERE id = $id";
    }

    // Eksekusi query  
    if (mysqli_query($mysqli, $query)) {
        header("Location: ../dashboard_admin.php"); // Arahkan kembali ke halaman obat  
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($mysqli) . "'); history.back();</script>";
    }
}
