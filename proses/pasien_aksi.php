<?php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['aksi'] == 'tambah') {
        // Tambah pasien  
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_ktp = $_POST['no_ktp'];
        $no_hp = $_POST['no_hp'];

        // Validasi nomor KTP  
        if (!preg_match('/^[1-9][0-9]{15}$/', $no_ktp)) {
            echo "<script>alert('Nomor KTP harus 16 digit dan tidak boleh diawali dengan nol.'); window.location.href='../dashboard_admin.php';</script>";
            exit();
        }

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
            $urutan = 1; // Urutan pasien baru  
            $no_rm = $year_month . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

            // Cek apakah No RM sudah ada  
            while (true) {
                $query_check_rm = "SELECT * FROM pasien WHERE no_rm = ?";
                $stmt_check_rm = $mysqli->prepare($query_check_rm);
                $stmt_check_rm->bind_param("s", $no_rm);
                $stmt_check_rm->execute();
                $result_check_rm = $stmt_check_rm->get_result();

                if ($result_check_rm->num_rows == 0) {
                    // No RM unik, keluar dari loop  
                    break;
                }

                // Jika tidak unik, tambahkan urutan dan buat No RM baru  
                $urutan++;
                $no_rm = $year_month . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
            }

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

        // Validasi nomor KTP  
        if (!preg_match('/^[1-9][0-9]{15}$/', $no_ktp)) {
            echo "<script>alert('Nomor KTP harus 16 digit dan tidak boleh diawali dengan nol.'); window.location.href='../dashboard_admin.php';</script>";
            exit();
        }

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

    // Mulai transaksi  
    $mysqli->begin_transaction();

    try {
        // Pertama, hapus catatan terkait di tabel daftar_poli  
        $stmt_daftar_poli = $mysqli->prepare("DELETE FROM daftar_poli WHERE id_pasien = ?");
        $stmt_daftar_poli->bind_param("i", $id);
        $stmt_daftar_poli->execute();
        $stmt_daftar_poli->close();

        // Kemudian hapus data pasien  
        $stmt_pasien = $mysqli->prepare("DELETE FROM pasien WHERE id = ?");
        $stmt_pasien->bind_param("i", $id);
        $stmt_pasien->execute();
        $stmt_pasien->close();

        // Konfirmasi transaksi  
        $mysqli->commit();

        echo "<script>  
            alert('Data pasien berhasil dihapus.');  
            window.location.href='../dashboard_admin.php';  
        </script>";
    } catch (Exception $e) {
        // Batalkan transaksi jika terjadi kesalahan  
        $mysqli->rollback();

        echo "<script>  
            alert('Gagal menghapus data pasien: " . addslashes($e->getMessage()) . "');  
            window.location.href='../dashboard_admin.php';  
        </script>";
    }
}

$mysqli->close();
