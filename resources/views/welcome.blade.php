<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iLab UNMUL - Pusat Unggulan Studi Tropis</title>
    <meta name="description" content="Sistem Manajemen Laboratorium Terpadu Universitas Mulawarman - Pusat Unggulan Studi Tropis">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <link rel="apple-touch-icon" href="/images/favicon.png">

    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="iLab UNMUL - Pusat Unggulan Studi Tropis">
    <meta property="og:description" content="Sistem Manajemen Laboratorium Terpadu Universitas Mulawarman dengan 7+ Laboratorium, 25+ Layanan Analisis, dan 20+ Peralatan Modern">
    <meta property="og:image" content="{{ url('/images/og-image.jpg') }}">
    <meta property="og:site_name" content="iLab UNMUL">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="iLab UNMUL - Pusat Unggulan Studi Tropis">
    <meta name="twitter:description" content="Sistem Manajemen Laboratorium Terpadu Universitas Mulawarman">
    <meta name="twitter:image" content="{{ url('/images/og-image.jpg') }}">

    <!-- Additional SEO Meta Tags -->
    <meta name="keywords" content="iLab UNMUL, Laboratorium UNMUL, Universitas Mulawarman, Studi Tropis, Laboratorium Kalimantan Timur, Penelitian Tropis">
    <meta name="author" content="iLab UNMUL - Universitas Mulawarman">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .delay-100 { animation-delay: 0.1s; opacity: 0; }
        .delay-200 { animation-delay: 0.2s; opacity: 0; }
        .delay-300 { animation-delay: 0.3s; opacity: 0; }
        .delay-400 { animation-delay: 0.4s; opacity: 0; }
        .delay-500 { animation-delay: 0.5s; opacity: 0; }
        .delay-600 { animation-delay: 0.6s; opacity: 0; }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #0066CC 0%, #4CAF50 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #0066CC;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #004999;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="antialiased bg-white">

    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-gradient-to-br from-[#0066CC] to-[#4CAF50] z-[100] flex items-center justify-center">
        <div class="text-center">
            <!-- Logo Animation -->
            <div class="mb-8">
                <div class="relative w-24 h-24 mx-auto">
                    <!-- Outer Ring -->
                    <div class="absolute inset-0 border-4 border-white/30 rounded-full animate-ping"></div>
                    <!-- Inner Circle -->
                    <div class="absolute inset-0 bg-white rounded-full flex items-center justify-center">
                        <span class="text-[#0066CC] font-bold text-3xl">iL</span>
                    </div>
                </div>
            </div>

            <!-- Loading Text -->
            <h2 class="text-white text-2xl font-bold mb-4">iLab UNMUL</h2>
            <p class="text-white/90 mb-6">Pusat Unggulan Studi Tropis</p>

            <!-- Progress Bar -->
            <div class="w-64 mx-auto bg-white/20 rounded-full h-2 overflow-hidden">
                <div id="loading-progress" class="h-full bg-white rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>

            <!-- Loading Percentage -->
            <p class="text-white/80 mt-4 text-sm">
                <span id="loading-percentage">0</span>%
            </p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-sm z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo Section with UNMUL & BLU Logos -->
                <div class="flex items-center space-x-4">
                    <!-- Logo UNMUL (Left) -->
                    <div class="flex items-center">
                        <img src="/images/logo-unmul.png" alt="Logo UNMUL" class="h-10 w-auto" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="h-10 w-10 bg-[#0066CC] rounded-full items-center justify-center text-white font-bold text-xs hidden">UNMUL</div>
                    </div>

                    <!-- Divider -->
                    <div class="h-10 w-px bg-gray-300"></div>

                    <!-- iLab UNMUL Text -->
                    <div class="flex items-center space-x-3">
                        <div>
                            <h1 class="font-bold text-[#0066CC] text-lg">iLab UNMUL</h1>
                            <p class="text-xs text-gray-500 hidden sm:block">Pusat Unggulan Studi Tropis</p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="h-10 w-px bg-gray-300 hidden sm:block"></div>

                    <!-- Logo BLU (Right) -->
                    <div class="hidden sm:flex items-center">
                        <img src="/images/logo-blu.png" alt="Logo BLU" class="h-10 w-auto" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="h-10 w-10 bg-[#FF9800] rounded-full items-center justify-center text-white font-bold text-xs hidden">BLU</div>
                    </div>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-700 hover:text-[#0066CC] transition-colors font-medium">Beranda</a>
                    <a href="#fitur" class="text-gray-700 hover:text-[#0066CC] transition-colors font-medium">Fitur</a>
                    <a href="#informasi" class="text-gray-700 hover:text-[#0066CC] transition-colors font-medium">Informasi</a>
                    <a href="#tentang" class="text-gray-700 hover:text-[#0066CC] transition-colors font-medium">Tentang</a>
                    <a href="#kontak" class="text-gray-700 hover:text-[#0066CC] transition-colors font-medium">Kontak</a>
                </div>

                <!-- Action Buttons (Desktop) -->
                <div class="hidden md:flex items-center space-x-3">
                    <a href="/tracking" class="text-[#0066CC] hover:text-[#004999] font-medium transition-colors">
                        Lacak Permohonan
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-[#0066CC] text-white rounded-lg hover:bg-[#004999] transition-colors font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-[#0066CC] text-white rounded-lg hover:bg-[#004999] transition-colors font-medium">
                            Masuk
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="md:hidden pb-4"
                 style="display: none;">
                <div class="flex flex-col space-y-3 pt-4 border-t border-gray-200">
                    <a href="#beranda" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#0066CC] transition-colors font-medium px-4 py-2">Beranda</a>
                    <a href="#fitur" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#0066CC] transition-colors font-medium px-4 py-2">Fitur</a>
                    <a href="#informasi" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#0066CC] transition-colors font-medium px-4 py-2">Informasi</a>
                    <a href="#tentang" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#0066CC] transition-colors font-medium px-4 py-2">Tentang</a>
                    <a href="#kontak" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#0066CC] transition-colors font-medium px-4 py-2">Kontak</a>
                    <a href="/tracking" @click="mobileMenuOpen = false" class="text-[#0066CC] hover:text-[#004999] font-medium px-4 py-2">Lacak Permohonan</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="mx-4 px-4 py-2 bg-[#0066CC] text-white rounded-lg hover:bg-[#004999] transition-colors font-medium text-center">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="mx-4 px-4 py-2 bg-[#0066CC] text-white rounded-lg hover:bg-[#004999] transition-colors font-medium text-center">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Beta Floating Bubble -->
    <div id="beta-bubble" class="fixed hidden" style="bottom: 6rem !important; right: 2rem !important; z-index: 9999 !important; position: fixed !important;">
        <!-- Floating Button (Minimized State) -->
        <div id="beta-bubble-btn" class="bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-full shadow-2xl cursor-pointer hover:shadow-orange-500/50 transition-all duration-300 hover:scale-110" onclick="toggleBetaBubble()">
            <div class="flex items-center justify-center w-14 h-14">
                <span class="text-2xl animate-pulse">🚀</span>
            </div>
        </div>

        <!-- Expanded Bubble Content -->
        <div id="beta-bubble-content" class="hidden absolute bottom-0 right-0 w-96 bg-gradient-to-br from-amber-500 via-orange-500 to-amber-600 text-white rounded-2xl shadow-2xl p-5">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">🚀</span>
                    <h3 class="font-bold text-lg">Beta Version</h3>
                </div>
                <button onclick="toggleBetaBubble()" class="text-white hover:text-gray-200 transition-colors flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-white/90 mb-3 leading-relaxed">
                Platform dalam Versi Beta - Fitur baru ditambahkan setiap minggu!
            </p>
            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                <p class="font-semibold mb-2 flex items-center text-xs">
                    <span class="mr-2">💡</span> Info:
                </p>
                <p class="text-white/90 text-xs" style="line-height: 1.5;">Sistem sedang dalam pengembangan aktif. Kami terus menambahkan fitur baru untuk meningkatkan pengalaman Anda.</p>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-24 pb-32 bg-gradient-to-br from-[#0066CC] via-[#0066CC] to-[#4CAF50] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-6">
                    <div class="animate-fade-in-up">
                        <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-4">
                            Sistem Manajemen Laboratorium Terpadu
                        </span>
                    </div>

                    <h1 class="text-5xl md:text-6xl font-bold leading-tight animate-fade-in-up delay-100">
                        iLab UNMUL
                    </h1>

                    <p class="text-2xl md:text-3xl font-semibold text-[#FFD700] animate-fade-in-up delay-200">
                        Pusat Unggulan Studi Tropis
                    </p>

                    <p class="text-lg text-white/90 leading-relaxed animate-fade-in-up delay-300">
                        Platform manajemen laboratorium modern yang mengintegrasikan layanan analisis, booking peralatan, dan penelitian untuk mendukung pengembangan ilmu pengetahuan tropis di Kalimantan Timur.
                    </p>

                    <div class="flex flex-wrap gap-4 animate-fade-in-up delay-400">
                        <a href="#fitur" class="px-8 py-3 bg-white text-[#0066CC] rounded-lg font-semibold hover:bg-gray-100 transition-all hover:scale-105 shadow-lg">
                            Jelajahi Fitur
                        </a>
                        <a href="#tentang" class="px-8 py-3 bg-white/10 backdrop-blur-sm text-white rounded-lg font-semibold hover:bg-white/20 transition-all border-2 border-white/30">
                            Tentang Kami
                        </a>
                    </div>
                </div>

                <!-- Right Content - Statistics -->
                <div class="grid grid-cols-2 gap-6 animate-fade-in-up delay-500">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all hover:scale-105">
                        <div class="text-4xl font-bold mb-2">{{ $stats['laboratories'] }}+</div>
                        <div class="text-white/80">Laboratorium</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all hover:scale-105">
                        <div class="text-4xl font-bold mb-2">{{ $stats['services'] }}+</div>
                        <div class="text-white/80">Layanan Analisis</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all hover:scale-105">
                        <div class="text-4xl font-bold mb-2">{{ $stats['equipment'] }}+</div>
                        <div class="text-white/80">Peralatan Modern</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all hover:scale-105">
                        <div class="text-4xl font-bold mb-2">{{ $stats['users'] }}+</div>
                        <div class="text-white/80">Peneliti Aktif</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Decoration -->
        <div class="absolute bottom-0 left-0 right-0 w-full -mb-1">
            <svg class="w-full h-auto block" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-white -mt-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Fitur <span class="gradient-text">Unggulan</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Platform lengkap untuk kebutuhan penelitian dan manajemen laboratorium Anda
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-white p-8 rounded-2xl border border-blue-100 hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="w-14 h-14 bg-[#0066CC] rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Katalog Layanan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Jelajahi 25+ layanan analisis dengan informasi lengkap harga, durasi, dan spesifikasi teknis.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gradient-to-br from-green-50 to-white p-8 rounded-2xl border border-green-100 hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="w-14 h-14 bg-[#4CAF50] rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Permohonan Layanan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Ajukan permohonan analisis dengan wizard 4 langkah yang mudah dan lacak status secara real-time.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gradient-to-br from-orange-50 to-white p-8 rounded-2xl border border-orange-100 hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="w-14 h-14 bg-[#FF9800] rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Booking Peralatan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Reservasi peralatan laboratorium dengan kalender interaktif dan konfirmasi otomatis.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gradient-to-br from-purple-50 to-white p-8 rounded-2xl border border-purple-100 hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pelacakan Publik</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Lacak status permohonan Anda tanpa login dengan nomor permohonan yang diberikan.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gradient-to-br from-red-50 to-white p-8 rounded-2xl border border-red-100 hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="w-14 h-14 bg-red-600 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Monitoring SLA</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pantau waktu penyelesaian layanan dengan sistem SLA otomatis dan notifikasi real-time.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gradient-to-br from-teal-50 to-white p-8 rounded-2xl border border-teal-100 hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="w-14 h-14 bg-teal-600 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Akses</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem keamanan berbasis role dengan kontrol akses multi-level untuk berbagai pengguna.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">
                        Tentang <span class="gradient-text">iLab UNMUL</span>
                    </h2>
                    <div class="space-y-4 text-gray-700 leading-relaxed text-lg">
                        <p>
                            <strong class="text-[#0066CC]">iLab UNMUL</strong> merupakan Pusat Unggulan Studi Tropis yang berkomitmen untuk mendukung penelitian dan pengembangan ilmu pengetahuan, khususnya dalam bidang ekosistem tropis di Kalimantan Timur.
                        </p>
                        <p>
                            Dengan 7 laboratorium yang dilengkapi peralatan modern dan tenaga ahli berpengalaman, kami menyediakan layanan analisis dan penelitian berkualitas tinggi untuk sivitas akademika, instansi pemerintah, dan industri.
                        </p>
                        <p>
                            Melalui platform digital iLab UNMUL, kami menghadirkan transparansi, efisiensi, dan kemudahan akses layanan laboratorium yang terintegrasi dalam satu sistem.
                        </p>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl shadow-md border-2 border-[#0066CC]/20 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-3">
                                <svg class="w-8 h-8 text-[#0066CC] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <div class="text-2xl font-bold text-[#0066CC]">ISO/IEC 17025</div>
                            </div>
                            <div class="text-sm text-gray-600 leading-relaxed">Proses Akreditasi Laboratorium Pengujian & Kalibrasi</div>
                            <div class="mt-2 inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                Dalam Proses
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-xl shadow-md border-2 border-[#4CAF50]/20 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-3">
                                <svg class="w-8 h-8 text-[#4CAF50] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="text-2xl font-bold text-[#4CAF50]">24/7</div>
                            </div>
                            <div class="text-sm text-gray-600 leading-relaxed">Layanan Digital Tersedia Setiap Saat</div>
                            <div class="mt-2 inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                Aktif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Highlights -->
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-[#0066CC] hover:shadow-xl transition-shadow">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Visi</h4>
                        <p class="text-gray-600">
                            Menjadi pusat unggulan riset dan layanan laboratorium berbasis ekosistem tropis yang bereputasi internasional.
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-[#4CAF50] hover:shadow-xl transition-shadow">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Misi</h4>
                        <ul class="text-gray-600 space-y-2">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-[#4CAF50] mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Menyediakan layanan analisis berkualitas tinggi</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-[#4CAF50] mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Mendukung penelitian ekosistem tropis</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-[#4CAF50] mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Mengembangkan SDM dan teknologi laboratorium</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-[#FF9800] hover:shadow-xl transition-shadow">
                        <h4 class="font-bold text-lg text-gray-900 mb-2">Komitmen Kualitas</h4>
                        <p class="text-gray-600">
                            Setiap layanan dilakukan dengan standar internasional, didukung peralatan canggih dan tenaga ahli bersertifikasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information & Regulation Section -->
    <section id="informasi" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Informasi & <span class="gradient-text">Regulasi</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Dokumen resmi terkait tarif layanan dan regulasi laboratorium
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @forelse($publicDocuments as $doc)
                <!-- Document Card -->
                <div class="group relative bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        @if($doc->icon == 'pdf')
                        <svg class="w-24 h-24 text-{{ $doc->color == 'blue' ? 'blue-600' : ($doc->color == 'green' ? 'green-600' : ($doc->color == 'orange' ? 'orange-500' : ($doc->color == 'red' ? 'red-600' : ($doc->color == 'purple' ? 'purple-600' : 'teal-600')))) }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                        @else
                        <svg class="w-24 h-24 text-{{ $doc->color == 'blue' ? 'blue-600' : ($doc->color == 'green' ? 'green-600' : ($doc->color == 'orange' ? 'orange-500' : ($doc->color == 'red' ? 'red-600' : ($doc->color == 'purple' ? 'purple-600' : 'teal-600')))) }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                        @endif
                    </div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-{{ $doc->color }}-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-{{ $doc->color == 'blue' ? 'blue-600' : ($doc->color == 'green' ? 'green-600' : ($doc->color == 'orange' ? 'orange-500' : ($doc->color == 'red' ? 'red-600' : ($doc->color == 'purple' ? 'purple-600' : 'teal-600')))) }} transition-colors duration-300">
                            @if($doc->icon == 'pdf')
                            <svg class="w-8 h-8 text-{{ $doc->color == 'blue' ? 'blue-600' : ($doc->color == 'green' ? 'green-600' : ($doc->color == 'orange' ? 'orange-500' : ($doc->color == 'red' ? 'red-600' : ($doc->color == 'purple' ? 'purple-600' : 'teal-600')))) }} group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            @else
                            <svg class="w-8 h-8 text-{{ $doc->color == 'blue' ? 'blue-600' : ($doc->color == 'green' ? 'green-600' : ($doc->color == 'orange' ? 'orange-500' : ($doc->color == 'red' ? 'red-600' : ($doc->color == 'purple' ? 'purple-600' : 'teal-600')))) }} group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-{{ $doc->color == 'blue' ? 'blue-600' : ($doc->color == 'green' ? 'green-600' : ($doc->color == 'orange' ? 'orange-500' : ($doc->color == 'red' ? 'red-600' : ($doc->color == 'purple' ? 'purple-600' : 'teal-600')))) }} transition-colors">
                            {{ $doc->title }}
                        </h3>
                        
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            {{ $doc->description }}
                        </p>
                        
                        <div class="flex gap-3">
                            <a href="{{ $doc->download_url }}" target="_blank" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-{{ $doc->color == 'blue' ? 'blue-600' : ($doc->color == 'green' ? 'green-600' : ($doc->color == 'orange' ? 'orange-500' : ($doc->color == 'red' ? 'red-600' : ($doc->color == 'purple' ? 'purple-600' : 'teal-600')))) }} text-white rounded-lg hover:opacity-90 transition-colors font-medium text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat PDF
                            </a>
                            <a href="{{ $doc->download_url }}" download class="inline-flex justify-center items-center px-4 py-2 border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors bg-white font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada dokumen publik yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-[#0066CC] to-[#4CAF50] text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">
                Siap Memulai Penelitian Anda?
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Untuk mengakses layanan iLab UNMUL, silakan hubungi admin untuk mendapatkan akun.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="#kontak" class="px-8 py-4 bg-white text-[#0066CC] rounded-lg font-semibold hover:bg-gray-100 transition-all hover:scale-105 shadow-lg text-lg">
                    Hubungi Kami
                </a>
                <a href="/tracking" class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-lg font-semibold hover:bg-white/20 transition-all border-2 border-white/30 text-lg">
                    Lacak Permohonan
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-8">
                <!-- About -->
                <div class="md:col-span-2 lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-[#0066CC] rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">iL</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-lg">iLab UNMUL</h3>
                            <p class="text-sm text-gray-400">Pusat Unggulan Studi Tropis</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-4 leading-relaxed">
                        Sistem Manajemen Laboratorium Terpadu Universitas Mulawarman yang mendukung penelitian dan pengembangan ilmu pengetahuan tropis di Kalimantan Timur.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-[#0066CC] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-[#0066CC] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-[#0066CC] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="#beranda" class="hover:text-[#0066CC] transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-[#0066CC] transition-colors">Fitur</a></li>
                        <li><a href="#tentang" class="hover:text-[#0066CC] transition-colors">Tentang</a></li>
                        <li><a href="/tracking" class="hover:text-[#0066CC] transition-colors">Lacak Permohonan</a></li>
                    </ul>
                </div>

                <!-- Legal Links -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-[#0066CC] transition-colors" onclick="alert('Halaman Privacy Policy sedang dalam pengembangan'); return false;">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-[#0066CC] transition-colors" onclick="alert('Halaman Terms of Service sedang dalam pengembangan'); return false;">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-[#0066CC] transition-colors" onclick="alert('Halaman FAQ sedang dalam pengembangan'); return false;">FAQ</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Kontak</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-[#0066CC] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Jl. Kuaro, Gn. Kelua, Samarinda, Kalimantan Timur</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#0066CC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>antonprafanto@unmul.ac.id</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#0066CC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>0811553393</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} iLab UNMUL - Universitas Mulawarman. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#beranda" class="fixed bottom-8 right-8 w-12 h-12 bg-[#0066CC] text-white rounded-full flex items-center justify-center shadow-lg hover:bg-[#004999] transition-all hover:scale-110 z-40">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </a>

    <!-- Loading Screen Script -->
    <script>
        // Toggle Beta Floating Bubble
        function toggleBetaBubble() {
            const bubbleBtn = document.getElementById('beta-bubble-btn');
            const bubbleContent = document.getElementById('beta-bubble-content');

            if (bubbleBtn && bubbleContent) {
                if (bubbleContent.classList.contains('hidden')) {
                    // Show expanded content
                    bubbleContent.classList.remove('hidden');
                    bubbleBtn.classList.add('hidden');
                    localStorage.setItem('betaBubbleExpanded', 'true');
                } else {
                    // Minimize to button
                    bubbleContent.classList.add('hidden');
                    bubbleBtn.classList.remove('hidden');
                    localStorage.setItem('betaBubbleExpanded', 'false');
                }
            }
        }

        // Check if bubble was previously expanded
        document.addEventListener('DOMContentLoaded', function() {
            const bubbleExpanded = localStorage.getItem('betaBubbleExpanded');
            if (bubbleExpanded === 'true') {
                const bubbleBtn = document.getElementById('beta-bubble-btn');
                const bubbleContent = document.getElementById('beta-bubble-content');
                if (bubbleBtn && bubbleContent) {
                    bubbleContent.classList.remove('hidden');
                    bubbleBtn.classList.add('hidden');
                }
            }
        });

        // Loading Screen Controller
        document.addEventListener('DOMContentLoaded', function() {
            const loadingScreen = document.getElementById('loading-screen');
            const progressBar = document.getElementById('loading-progress');
            const percentageText = document.getElementById('loading-percentage');

            let progress = 0;
            const duration = 1500; // 1.5 seconds
            const interval = 50; // Update every 50ms
            const increment = (100 / (duration / interval));

            // Simulate loading progress
            const loadingInterval = setInterval(() => {
                progress += increment;

                if (progress >= 100) {
                    progress = 100;
                    clearInterval(loadingInterval);

                    // Hide loading screen after reaching 100%
                    setTimeout(() => {
                        loadingScreen.style.opacity = '0';
                        loadingScreen.style.transition = 'opacity 0.5s ease-out';

                        setTimeout(() => {
                            loadingScreen.style.display = 'none';

                            // Show beta bubble after loading screen is hidden
                            const betaBubble = document.getElementById('beta-bubble');
                            if (betaBubble) {
                                betaBubble.classList.remove('hidden');
                            }
                        }, 500);
                    }, 300);
                }

                progressBar.style.width = progress + '%';
                percentageText.textContent = Math.floor(progress);
            }, interval);
        });

        // Hide loading screen immediately if page loads from cache
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                const loadingScreen = document.getElementById('loading-screen');
                const betaBubble = document.getElementById('beta-bubble');
                if (loadingScreen) {
                    loadingScreen.style.display = 'none';
                }
                if (betaBubble) {
                    betaBubble.classList.remove('hidden');
                }
            }
        });

        // Fallback: Hide loading after 3 seconds maximum
        setTimeout(() => {
            const loadingScreen = document.getElementById('loading-screen');
            const betaBubble = document.getElementById('beta-bubble');
            if (loadingScreen && loadingScreen.style.display !== 'none') {
                loadingScreen.style.opacity = '0';
                loadingScreen.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                    // Show beta bubble
                    if (betaBubble) {
                        betaBubble.classList.remove('hidden');
                    }
                }, 500);
            }
        }, 3000);
    </script>

</body>
</html>
