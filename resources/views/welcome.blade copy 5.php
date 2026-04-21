<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="robots" content="noindex, nofollow">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16.png">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-BZ6XPXRVDJ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-BZ6XPXRVDJ');
    </script>


    <!-- ✅ PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0f172a">

    <title>Attendance System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#fcfaf7] text-[#1a1c1e] antialiased">

    <div class="min-h-screen flex flex-col items-center justify-between px-6 py-8 max-w-md mx-auto">

        <!-- TOP -->
        <div class="mt-10 text-center">

            <!-- Logo -->
            <div
                class="w-20 h-20 bg-[#1a1c1e] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl rotate-3 hover:rotate-0 transition duration-300">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#d4af37]" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold tracking-tight mb-2">
                Attendance <span class="text-[#8c7851]">System</span>
            </h1>

            <p class="text-sm text-[#8c7851]/80 font-medium">
                Manajemen kehadiran dalam satu genggaman.
            </p>

        </div>

        <!-- MIDDLE -->
        <div class="relative w-full aspect-square flex items-center justify-center">

            <div class="absolute inset-0 bg-[#8c7851]/5 rounded-full scale-90"></div>

            <div class="absolute inset-0 border border-[#d4af37]/20 rounded-full scale-75 animate-pulse"></div>

            <div class="z-10 text-center px-6">
                <p class="text-xs uppercase tracking-[0.2em] text-[#8c7851] mb-4 italic">
                    Welcome
                </p>

                <h2 class="text-2xl font-serif text-[#1a1c1e]/90">
                    Siap untuk mulai bekerja hari ini?
                </h2>
            </div>

        </div>

        <!-- BOTTOM -->
        <div class="w-full space-y-4 mb-6">

            @auth
                <a href="{{ route('presensi') }}"
                    class="w-full block text-center bg-[#1a1c1e] text-white py-4 rounded-xl font-semibold shadow-lg hover:opacity-90 active:scale-[0.98] transition">
                    Masuk ke Presensi
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="w-full block text-center bg-[#1a1c1e] text-white py-4 rounded-xl font-semibold shadow-lg hover:opacity-90 active:scale-[0.98] transition">
                    Masuk Sekarang
                </a>
            @endauth

            <div class="flex items-center justify-center gap-2 text-sm">
                <span class="text-[#8c7851]/70">Butuh akun?</span>
                <span class="text-[#8c7851] font-semibold">
                    Hubungi HRD
                </span>
            </div>

            <div class="pt-6 text-center">
                <p class="text-[10px] text-[#8c7851]/50 uppercase tracking-widest">
                    © {{ date('Y') }} Attendance System
                </p>
            </div>

        </div>

    </div>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
                .then(() => console.log('Service Worker registered'));
        }
    </script>


</body>

</html>
