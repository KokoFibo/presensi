<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Presensi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen flex flex-col">

    <!-- Header -->
    <header class="w-full lg:max-w-4xl max-w-[335px] mx-auto text-sm mb-6 p-4">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-3">
                @auth
                    <a href="{{ url('/presensi') }}"
                        class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition">
                        Presensi
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Masuk
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            Daftar
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-4">

        <div class="w-full max-w-md bg-white/80 dark:bg-white/5 backdrop-blur-xl rounded-3xl shadow-xl p-6 text-center">

            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div
                    class="w-16 h-16 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">
                    ⏱
                </div>
            </div>

            <!-- Judul -->
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-2">
                Sistem Presensi Modern
            </h1>

            <!-- Deskripsi -->
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                Kelola kehadiran dengan mudah, cepat, dan efisien. Dirancang untuk kebutuhan kerja masa kini.
            </p>

            <!-- Auth Section -->
            @auth
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span>
                </p>

                <a href="/presensi"
                    class="block w-full py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                    Masuk ke Presensi
                </a>
            @else
                <div class="space-y-3">
                    <a href="{{ route('login') }}"
                        class="block w-full py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                        Mulai Sekarang
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="block w-full py-3 rounded-xl border border-gray-300 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            Buat Akun
                        </a>
                    @endif
                </div>
            @endauth

            <!-- Footer -->
            <p class="text-xs text-gray-400 mt-6">
                Presensi lebih praktis untuk aktivitas kerja harian Anda
            </p>

        </div>

    </main>

</body>

</html>
