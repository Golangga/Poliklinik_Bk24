<?php
require_once '../config/koneksi.php';

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    if ($aksi == 'hapus') {
        $id = $mysqli->real_escape_string(intval($_GET['id']));
        $stmt = $mysqli->prepare("DELETE FROM dokter WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: ../dashboard_admin.php?success=Data dokter berhasil dihapus");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aksi = $_POST['aksi'];
    $nama_dokter = $_POST['nama'];
    $id_poli = $_POST['id_poli'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($aksi == 'tambah') {
        $stmt = $mysqli->prepare("INSERT INTO dokter (nama, id_poli, alamat, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama_dokter, $id_poli, $alamat, $hashed_password);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: ../dashboard_admin.php?success=Data dokter berhasil ditambahkan");
            exit;
        } else {
            // Tangani error jika query gagal  
            header("Location: ../content/tambah_dokter.php?error=Gagal menambahkan dokter");
            exit;
        }
    } else if ($aksi == 'edit') {
        $id = $mysqli->real_escape_string(intval($_POST['id']));
        $stmt = $mysqli->prepare("UPDATE dokter SET nama = ?, id_poli = ?, alamat = ?, no_hp = ? WHERE id = ?");
        $stmt->bind_param("sissi", $nama_dokter, $id_poli, $alamat, $no_hp, $id); // Perubahan di sini  
        $stmt->execute();
        $stmt->close();
        header("Location: ../dashboard_admin.php?success=Data dokter berhasil diperbarui");
        exit;
    }
}

// Menangani error koneksi database  
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->close();
