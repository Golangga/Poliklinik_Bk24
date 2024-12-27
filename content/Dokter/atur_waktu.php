<?php
require_once '../../config/koneksi.php';
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id'])) {
    header("Location: ../../login_dokter.php");
    exit();
}

if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_dokter = $_SESSION['id'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    if (strtotime($jam_mulai) >= strtotime($jam_selesai)) {
        echo "<script>alert('Jam mulai harus lebih awal dari jam selesai!'); window.location.href='atur_waktu.php';</script>";
        exit();
    }

    $stmt = $mysqli->prepare("INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param("isss", $id_dokter, $hari, $jam_mulai, $jam_selesai);

    if ($stmt->execute()) {
        echo "<script>alert('Jadwal berhasil diatur!'); window.location.href='atur_waktu.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan jadwal: " . $stmt->error . "'); window.location.href='atur_waktu.php';</script>";
    }

    $stmt->close();
    exit();
}

// Mengambil jadwal yang sudah ada  
$id_dokter = $_SESSION['id'];
$query = "SELECT * FROM jadwal_periksa WHERE id_dokter = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id_dokter);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Waktu Periksa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <div class="container mx-auto bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Atur Waktu Periksa</h1>
        <form method="POST" action="">
            <div class="mb-4">
                <label class="block text-gray-700">Hari:</label>
                <select name="hari" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <?php
                    $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    foreach ($daysOfWeek as $day) {
                        echo "<option value='$day'>$day</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Jam Mulai:</label>
                <input type="time" name="jam_mulai" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Jam Selesai:</label>
                <input type="time" name="jam_selesai" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>
            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Atur Jadwal</button>
        </form>
        <h2 class="text-xl font-semibold mt-6">Jadwal yang Sudah Dibuat</h2>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden mt-4">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">No</th>
                    <th class="py-3 px-4 text-left">Hari</th>
                    <th class="py-3 px-4 text-left">Jam Mulai</th>
                    <th class="py-3 px-4 text-left">Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($result->num_rows > 0) {
                    while ($jadwal = $result->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-4"><?= $no++ ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($jadwal['hari']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($jadwal['jam_mulai']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($jadwal['jam_selesai']) ?></td>
                        </tr>
                <?php endwhile;
                } else {
                    echo "<tr><td colspan='4' class='text-center py-4'>Belum ada jadwal</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>