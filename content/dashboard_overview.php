<?php
// Sambungkan ke file koneksi  
require_once './config/koneksi.php';
?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold mb-4">Total Dokter</h3>
        <div class="text-3xl font-bold text-blue-600">
            <?php
            // Ambil jumlah dokter dari database  
            $query_dokter = "SELECT COUNT(*) as total_dokter FROM dokter";
            $result_dokter = mysqli_query($mysqli, $query_dokter);
            $total_dokter = mysqli_fetch_assoc($result_dokter)['total_dokter'];
            echo htmlspecialchars($total_dokter);
            ?>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold mb-4">Total Pasien</h3>
        <div class="text-3xl font-bold text-green-600">
            <?php
            // Ambil jumlah pasien dari database  
            $query_pasien = "SELECT COUNT(*) as total_pasien FROM pasien";
            $result_pasien = mysqli_query($mysqli, $query_pasien);
            $total_pasien = mysqli_fetch_assoc($result_pasien)['total_pasien'];
            echo htmlspecialchars($total_pasien);
            ?>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold mb-4">Total Poli</h3>
        <div class="text-3xl font-bold text-purple-600">
            <?php
            // Ambil jumlah poli dari database  
            $query_poli = "SELECT COUNT(*) as total_poli FROM poli";
            $result_poli = mysqli_query($mysqli, $query_poli);
            $total_poli = mysqli_fetch_assoc($result_poli)['total_poli'];
            echo htmlspecialchars($total_poli);
            ?>
        </div>
    </div>
</div>