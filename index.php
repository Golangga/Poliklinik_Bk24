<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poliklinik Udinus</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        section {
            height: 100vh;
            /* Setiap section menjadi satu layar penuh */
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full z-10">
        <div class="container mx-auto flex justify-between items-center p-4">
            <div class="flex items-center">
                <a href="#home">
                    <img src="./asset/hospital.svg" alt="Logo" class="size-12 text-center items-center m-4">
                </a>
                <h1 class="text-[#64B9FC] text-xl flex items-center font-bold">
                    P
                    <img src="./asset/medicine.svg" class="size-4 mx-1" style="vertical-align: middle;">
                    liklinik
                </h1>
            </div>
            <ul class="flex space-x-6">
                <li><a href="#home" class="text-gray-700 hover:text-blue-600">Home</a></li>
                <li><a href="#services" class="text-gray-700 hover:text-blue-600">Layanan</a></li>
                <li><a href="#contact" class="text-gray-700 hover:text-blue-600">Kontak</a></li>
                <li>
                    <a href="#login" class="bg-[#64B9FC] text-white px-4 py-2 rounded hover:bg-white hover:text-gray-700 hover:ring-2 transition duration-200">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="bg-[#64B9FC] py-20 text-center flex items-center justify-center">
        <div>
            <h2 class="text-3xl font-semibold text-white">Selamat Datang di Poliklinik Udinus</h2>
            <p class="mt-4 text-gray-100">Kami siap memberikan layanan kesehatan terbaik untuk Anda.</p>
            <a href="#services" class="mt-6 inline-block bg-white text-black px-6 py-2 rounded hover:border-black transition duration-500 hover:shadow-xl">Lihat Layanan Kami</a>
        </div>
    </section>

    <!-- Pilihan Login -->
    <section id="login" class="bg-white m-auto pt-32">
        <div class="container mx-auto flex flex-col items-center justify-center">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Pilih Login Sebagai</h2>
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <div class="bg-white p-6 rounded shadow flex-1 text-center">
                    <img src="./asset/doctor.svg" alt="Dokter" class="w-20 mx-auto mb-4">
                    <h4 class="text-lg font-semibold mb-2">Dokter</h4>
                    <p class="text-gray-600">Dapatkan layanan kesehatan terbaik dari dokter profesional.</p>
                    <a href="login_dokter.php" class="mt-4 inline-block bg-[#64B9FC] text-white px-6 py-2 rounded hover:bg-white hover:text-gray-700 hover:ring-2 transition duration-200">Login</a>
                </div>
                <div class="bg-white p-6 rounded shadow flex-1 text-center">
                    <img src="./asset/zambia.svg" alt="Pasien" class="w-20 mx-auto mb-4">
                    <h4 class="text-lg font-semibold mb-2">Pasien</h4>
                    <p class="text-gray-600">Dapatkan layanan kesehatan dari dokter profesional dan pasien lainnya.</p>
                    <a href="login_pasien.php" class="mt-4 inline-block bg-[#64B9FC] text-white px-6 py-2 rounded hover:bg-white hover:text-gray-700 hover:ring-2 transition duration-200">Login</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Informasi Layanan -->
    <section id="services" class="container mx-auto pt-32">
        <img src="./asset/communications.svg" alt="layanan" class="size-32 mx-auto">
        <h3 class="text-2xl font-semibold text-center text-gray-800 mb-6">Layanan Kami</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded shadow ">
                <h4 class="font-bold text-lg text-gray-800">Konsultasi Dokter</h4>
                <p class="text-gray-600">Dapatkan konsultasi dari dokter berpengalaman untuk kesehatan Anda.</p>
            </div>
            <div class="bg-white p-8 rounded shadow ">
                <h4 class="font-bold text-lg text-gray-800">Pemeriksaan Kesehatan</h4>
                <p class="text-gray-600">Lakukan pemeriksaan kesehatan secara menyeluruh untuk menjaga kesehatan Anda.</p>
            </div>
            <div class="bg-white p-8 rounded shadow ">
                <h4 class="font-bold text-lg text-gray-800">Pelayanan Obat</h4>
                <p class="text-gray-600">Kami menyediakan obat-obatan yang Anda butuhkan dengan kualitas terbaik.</p>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <footer id="contact" class="bg-gray-200 flex items-center justify-center">
        <div class="text-center p-10">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Kontak Kami</h3>
            <p class="text-gray-600">Jika Anda memiliki pertanyaan, silakan hubungi kami di:</p>
            <p class="text-gray-800 font-bold">Email: info@poliklinikudinus.com</p>
            <p class="text-gray-800 font-bold">Telepon: (021) 123-4567</p>
        </div>
    </footer>

    <!-- Footer -->
    <footer class="bg-white py-4">
        <div class="container mx-auto text-center">
            <p class="text-gray-600">© 2024 Poliklinik Udinus. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navbar links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

</body>

</html>