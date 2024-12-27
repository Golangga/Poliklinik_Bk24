<?php
session_start();
require_once '../../config/koneksi.php';

// Cek apakah pasien sudah login  
if (!isset($_SESSION['pasien_id'])) {
    header("Location: login_pasien.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pasien = $_SESSION['pasien_id'];
    $id_jadwal = $_POST['id_jadwal'];
    $keluhan = $_POST['keluhan'];

    // Validasi ID Jadwal  
    $check_jadwal_query = "SELECT * FROM jadwal_periksa WHERE id = '$id_jadwal' AND status_aktif = 1";
    $check_result = mysqli_query($mysqli, $check_jadwal_query);

    if (mysqli_num_rows($check_result) == 0) {
        echo "Error: ID jadwal tidak ditemukan atau tidak aktif.";
        exit;
    }

    // Ambil nomor antrian berikutnya  
    $query_antrian = "SELECT COALESCE(MAX(no_antrian), 0) + 1 AS antrian FROM daftar_poli";
    $result_antrian = mysqli_query($mysqli, $query_antrian);
    $antrian = mysqli_fetch_assoc($result_antrian)['antrian'];

    // Simpan ke dalam tabel daftar_poli  
    $query_daftar = "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian)   
                     VALUES ('$id_pasien', '$id_jadwal', '$keluhan', '$antrian')";

    if (mysqli_query($mysqli, $query_daftar)) {
        // Redirect ke halaman konfirmasi  
        header("Location: konfirmasi_pendaftaran.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
}
