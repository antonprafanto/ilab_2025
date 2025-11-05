<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lacak Permohonan Layanan - {{ config('app.name', 'iLab UNMUL') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <i class="fas fa-search text-5xl mb-4"></i>
                    <h1 class="text-3xl font-bold mb-2">Lacak Permohonan Layanan</h1>
                    <p class="text-blue-100">Masukkan nomor permohonan untuk melihat status terkini</p>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
            {{-- Search Form --}}
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <form method="POST" action="{{ route('service-requests.tracking') }}" class="space-y-4">
                    @csrf

                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <div>
                        <label for="request_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Permohonan
                        </label>
                        <input
                            type="text"
                            name="request_number"
                            id="request_number"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                            placeholder="Contoh: SR-20251023-0001"
                            value="{{ old('request_number') }}"
                            required
                            autofocus
                        />
                        <p class="mt-2 text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>Format: SR-YYYYMMDD-XXXX
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center"
                    >
                        <i class="fas fa-search mr-2"></i>Lacak Permohonan
                    </button>
                </form>
            </div>

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-paper-plane text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Ajukan Permohonan</h3>
                    <p class="text-sm text-gray-600">Login untuk mengajukan permohonan layanan baru</p>
                </div>

                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-search text-green-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Lacak Status</h3>
                    <p class="text-sm text-gray-600">Pantau perkembangan permohonan Anda secara real-time</p>
                </div>

                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clock text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Akses 24/7</h3>
                    <p class="text-sm text-gray-600">Lacak permohonan kapan saja tanpa perlu login</p>
                </div>
            </div>

            {{-- Help Section --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <h3 class="font-semibold text-blue-900 mb-3">
                    <i class="fas fa-question-circle mr-2"></i>Butuh Bantuan?
                </h3>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li><i class="fas fa-check mr-2"></i>Nomor permohonan dikirim ke email Anda setelah pengajuan</li>
                    <li><i class="fas fa-check mr-2"></i>Simpan nomor permohonan untuk tracking di kemudian hari</li>
                    <li><i class="fas fa-check mr-2"></i>Hubungi lab terkait jika ada pertanyaan lebih lanjut</li>
                </ul>
            </div>

            {{-- Login Link --}}
            <div class="text-center pb-12">
                <p class="text-gray-600 mb-4">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login ke Dashboard
                </a>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="bg-gray-800 text-white py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'iLab UNMUL') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
