<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Presensi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeUp {
            animation: fadeUp 0.6s ease forwards;
        }

        .animate-scaleIn {
            animation: scaleIn 0.5s ease forwards;
        }
    </style>
</head>

<body class="bg-[#E8EDF5] min-h-screen flex items-center justify-center p-4">

    <div
        class="w-full max-w-[380px] bg-[#F4F7FB] rounded-[36px] border-[6px] border-slate-300 shadow-xl overflow-hidden animate-scaleIn">



        <!-- Header -->
        <div class="flex justify-between items-center px-6 pt-5">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 bg-[#1849A9] rounded-lg flex items-center justify-center text-white text-sm font-bold">
                    ⏱
                </div>
                <span class="text-sm font-semibold text-[#1849A9]">Yifang Attendance System</span>
            </div>

        </div>

        <!-- Content -->
        <div class="px-5 pt-4 flex flex-col items-center">

            <!-- Illustration -->
            <div class="w-full rounded-2xl bg-[#1849A9] mb-5 overflow-hidden animate-fadeUp">
                <!-- (SVG tetap, tidak diubah) -->
                <svg width="100%" viewBox="0 0 312 210" fill="none">
                    <rect width="312" height="210" fill="#1849A9" />
                    <circle cx="280" cy="30" r="60" fill="#1557CC" opacity="0.5" />
                    <circle cx="30" cy="180" r="50" fill="#1040A0" opacity="0.4" />
                </svg>
            </div>

            <!-- Text -->
            <div class="w-full mb-4 animate-fadeUp" style="animation-delay:0.1s">

                <div class="inline-block bg-blue-100 text-blue-700 text-[10px] font-semibold px-2 py-1 rounded mb-2">
                    Sistem Presensi Digital
                </div>

                <h1 class="text-[20px] font-bold text-[#0F2D5E] leading-tight mb-1">
                    Kelola Kehadiran <br>
                    <span class="text-[#1849A9]">Lebih Efisien</span>
                </h1>

                <p class="text-[13px] text-[#5A7499]">
                    Solusi absensi karyawan berbasis digital — akurat, aman, dan fleksibel.
                </p>
            </div>

            <!-- Features -->
            <div class="w-full space-y-2 mb-5 animate-fadeUp" style="animation-delay:0.2s">

                <div class="flex items-center gap-2 text-sm text-[#2D4E7A]">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">📊</div>
                    Rekap kehadiran harian & bulanan
                </div>

                <div class="flex items-center gap-2 text-sm text-[#2D4E7A]">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">⏰</div>
                    Pencatatan jam masuk & keluar
                </div>

                <div class="flex items-center gap-2 text-sm text-[#2D4E7A]">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">📈</div>
                    Laporan otomatis & akurat
                </div>

            </div>
        </div>

        <!-- Bottom -->
        <div class="px-6 pb-6 space-y-3 animate-fadeUp" style="animation-delay:0.3s">

            @auth
                <a href="{{ route('presensi') }}"
                    class="block w-full py-3 bg-[#1849A9] text-white rounded-xl text-center font-semibold hover:scale-[1.02] active:scale-[0.98] transition">
                    Masuk ke Presensi
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="block w-full py-3 bg-[#1849A9] text-white rounded-xl text-center font-semibold hover:scale-[1.02] active:scale-[0.98] transition">
                    Mulai Sekarang
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="block w-full py-3 border border-blue-200 text-[#1849A9] rounded-xl text-center font-medium hover:bg-blue-50 transition">
                        Masuk ke Akun
                    </a>
                @endif
            @endauth

            <p class="text-[11px] text-center text-[#94A9C3]">
                Dengan melanjutkan, Anda menyetujui syarat & ketentuan
            </p>
        </div>

    </div>

</body>

</html>
