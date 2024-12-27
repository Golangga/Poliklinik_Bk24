<?php
session_start();

// Cek apakah user sudah login sebagai admin  
if (!isset($_SESSION['username']) || $_SESSION['akses'] != 'admin') {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Poliklinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
</head>

<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-gradient-to-b from-gray-800 to-gray-900 text-white shadow-2xl">
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center justify-center space-x-3">
                <a href="./dashboard_admin.php" class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    <h1 class="text-2xl font-bold">Poliklinik</h1>
                </a>
            </div>
            <p class="text-center text-gray-400 mt-2">Dashboard Admin</p>
        </div>

        <nav class="p-4">
            <ul class="space-y-2">
                <?php
                $menuItems = [

                    ['icon' => '<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />', 'text' => 'Manajemen Dokter', 'href' => 'content/dokter.php'],
                    ['icon' => '<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a4 4 0 00-4-4H8a4 4 0 00-4 4v6h12v-6a4 4 0 00-4-4h-1z" />', 'text' => 'Manajemen Pasien', 'href' => 'content/pasien.php'],
                    ['icon' => '<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />', 'text' => 'Manajemen Poli', 'href' => 'content/poli.php'],
                    ['icon' => '<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.12 1.12.293 3.414-1.415 3.414H4.828c-1.707 0-2.535-2.293-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />', 'text' => 'Obat', 'href' => 'content/obat.php']
                ];

                foreach ($menuItems as $item):
                ?>
                    <li>
                        <a href="#"
                            hx-get="<?= $item['href'] ?>"
                            hx-target="#content-area"
                            class="flex items-center py-2 px-4 rounded-lg hover:bg-gray-700 transition group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <?= $item['icon'] ?>
                            </svg>
                            <?= $item['text'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="absolute bottom-0 left-0 w-64 p-4">
            <a href="logout.php" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 text-center transition flex items-center justify-center">
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
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
            <?php include './content/dashboard_overview.php'; ?>

        </div>
    </div>

    <script>
        // Active state pada menu  
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('nav a').forEach(a => {
                    a.classList.remove('bg-gray-700');
                    a.querySelector('svg').classList.remove('text-white');
                    a.querySelector('svg').classList.add('text-gray-400');
                });
                this.classList.add('bg-gray-700');
                this.querySelector('svg').classList.remove('text-gray-400');
                this.querySelector('svg').classList.add('text-white');
            });
        });
    </script>
</body>

</html>