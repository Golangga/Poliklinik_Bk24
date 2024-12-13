<?php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['aksi'] == 'tambah') {
        // Tambah pasien  
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_ktp = $_POST['no_ktp'];
        $no_hp = $_POST['no_hp'];

        // Cek apakah pasien sudah ada di database  
        $query = "SELECT * FROM pasien WHERE no_ktp = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $no_ktp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Pasien dengan nomor KTP ini sudah terdaftar.'); window.location.href='../dashboard_admin.php';</script>";
        } else {
            // Pasien baru, buat No RM  
            $year_month = date('Ym'); // Format tahun dan bulan  
            $query_count = "SELECT COUNT(*) as total FROM pasien WHERE created_at >= DATE_FORMAT(NOW() ,'%Y-%m-01')";
            $result_count = $mysqli->query($query_count);
            $row_count = $result_count->fetch_assoc();
            $urutan = $row_count['total'] + 1; // Urutan pasien baru  

            // Format No RM  
            $no_rm = $year_month . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

            // Simpan data pasien  
            $stmt = $mysqli->prepare("INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nama, $alamat, $no_ktp, $no_hp, $no_rm);

            if ($stmt->execute()) {
                echo "<script>alert('Pasien berhasil ditambahkan dengan No RM: $no_rm'); window.location.href='../dashboard_admin.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan pasien.'); window.location.href='../dashboard_admin.php';</script>";
            }
        }

        $stmt->close();
    } elseif ($_POST['aksi'] == 'edit') {
        // Edit pasien  
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_ktp = $_POST['no_ktp'];
        $no_hp = $_POST['no_hp'];

        // Update data pasien  
        $stmt = $mysqli->prepare("UPDATE pasien SET nama = ?, alamat = ?, no_ktp = ?, no_hp = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nama, $alamat, $no_ktp, $no_hp, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Data pasien berhasil diperbarui.'); window.location.href='../dashboard_admin.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data pasien.'); window.location.href='../dashboard_admin.php';</script>";
        }

        $stmt->close();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['aksi'] == 'hapus') {
    // Hapus pasien  
    $id = $_GET['id'];

    // Hapus data pasien  
    $stmt = $mysqli->prepare("DELETE FROM pasien WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data pasien berhasil dihapus.'); window.location.href='../dashboard_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data pasien.'); window.location.href='../dashboard_admin.php';</script>";
    }

    $stmt->close();
}

$mysqli->close();
