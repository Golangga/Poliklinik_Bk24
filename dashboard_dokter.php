<?php
session_start();

// Cek apakah user sudah login sebagai dokter  
if (!isset($_SESSION['username']) || $_SESSION['akses'] != 'dokter') {
    header("location: login_dokter.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - Poliklinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
</head>

<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-gradient-to-b from-blue-800 to-blue-900 text-white shadow-2xl">
        <div class="p-6 border-b border-blue-700">
            <div class="flex items-center justify-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h1 class="text-2xl font-bold">Poliklinik</h1>
            </div>
            <p class="text-center text-blue-300 mt-2">Dashboard Dokter</p>
        </div>

        <nav class="p-4">
            <ul class="space-y-2">
                <?php
                $menuItems = [
                    ['icon' => '<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />', 'text' => 'Dashboard', 'href' => 'content/Dokter/dashboard_overview.php'],
                    ['icon' => '<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />', 'text' => 'Daftar Pasien', 'href' => 'content/Dokter/daftar_pasien.php'],
                    ['icon' => '<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />', 'text' => 'Atur Waktu Periksa', 'href' => 'content/Dokter/atur_waktu.php'],
                    ['icon' => '<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />', 'text' => 'Riwayat Pasien', 'href' => 'content/Dokter/riwayat_pasien.php']
                ];

                foreach ($menuItems as $item):
                ?>
                    <li>
                        <a href="#"
                            hx-get="<?= $item['href'] ?>"
                            hx-target="#content-area"
                            class="flex items-center py-2 px-4 rounded-lg hover:bg-blue-700 transition group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <?= $item['icon'] ?>
                            </svg>
                            <?= $item['text'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="absolute bottom-0 left-0 w-64 p-4">
            <a href="logout.php" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 text-center block transition flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L14.586 9H7a1 1 0 110-2h7.586l-1.293-1.293a1 1 0 010-1.414z" clipRule="evenodd" />
                </svg>
                Logout
            </a>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <div class="bg-white shadow-md p-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h2 class="text-xl font-semibold">Selamat Datang, <?php echo $_SESSION['username']; ?></h2>
                    <p class="text-gray-500 text-sm"><?php echo date('l, d F Y'); ?></p>
                </div>
            </div>
        </div>

        <!-- Area Konten Dinamis -->
        <div id="content-area" class="flex-1 overflow-auto p-6">
            <!-- Konten default atau overview -->
            <?php include 'content/Dokter/dashboard_overview.php'; ?>
        </div>
    </div>

    <script>
        // Active state pada menu  
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('nav a').forEach(a => {
                    a.classList.remove('bg-blue-700');
                    a.querySelector('svg').classList.remove('text-white');
                    a.querySelector('svg').classList.add('text-blue-400');
                });
                this.classList.add('bg-blue-700');
                this.querySelector('svg').classList.remove('text-blue-400');
                this.querySelector('svg').classList.add('text-white');
            });
        });
    </script>
</body>

</html>