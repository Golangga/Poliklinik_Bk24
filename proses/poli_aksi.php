<?php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['aksi'] == 'tambah') {
        // Tambah poli  
        $nama_poli = $_POST['nama_poli'];
        $keterangan = $_POST['keterangan'];

        // Simpan data poli  
        $stmt = $mysqli->prepare("INSERT INTO poli (nama_poli, keterangan) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama_poli, $keterangan);

        if ($stmt->execute()) {
            echo "<script>alert('Poli berhasil ditambahkan.'); window.location.href='../dashboard_admin.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan poli.'); window.location.href='../dashboard_admin.php';</script>";
        }

        $stmt->close();
    } elseif ($_POST['aksi'] == 'edit') {
        // Edit poli  
        $id = $_POST['id'];
        $nama_poli = $_POST['nama_poli'];
        $keterangan = $_POST['keterangan'];

        // Update data poli  
        $stmt = $mysqli->prepare("UPDATE poli SET nama_poli = ?, keterangan = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nama_poli, $keterangan, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Data poli berhasil diperbarui.'); window.location.href='../dashboard_admin.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data poli.'); window.location.href='../dashboard_admin.php';</script>";
        }

        $stmt->close();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['aksi'] == 'hapus') {
    // Hapus poli  
    $id = $_GET['id'];

    // Hapus data poli  
    $stmt = $mysqli->prepare("DELETE FROM poli WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data poli berhasil dihapus.'); window.location.href='../dashboard_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data poli.'); window.location.href='../dashboard_admin.php';</script>";
    }

    $stmt->close();
}

$mysqli->close();
