<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hasil Tracking - {{ config('app.name', 'iLab UNMUL') }}</title>

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
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-1">Status Permohonan</h1>
                        <p class="text-blue-100">{{ $serviceRequest->request_number }}</p>
                    </div>
                    <a href="{{ route('service-requests.tracking') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 transition">
                        <i class="fas fa-search mr-2"></i>Lacak Lagi
                    </a>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Status Card --}}
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 mb-2">
                                    {{ $serviceRequest->title ?? 'Permohonan Layanan' }}
                                </h2>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($serviceRequest->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($serviceRequest->status === 'verified') bg-blue-100 text-blue-800
                                    @elseif($serviceRequest->status === 'approved') bg-green-100 text-green-800
                                    @elseif($serviceRequest->status === 'in_progress') bg-purple-100 text-purple-800
                                    @elseif($serviceRequest->status === 'testing') bg-indigo-100 text-indigo-800
                                    @elseif($serviceRequest->status === 'completed') bg-green-100 text-green-800
                                    @elseif($serviceRequest->status === 'ready_for_pickup') bg-teal-100 text-teal-800
                                    @elseif($serviceRequest->status === 'delivered') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    <i class="fas fa-circle text-xs mr-2"></i>
                                    {{ ucfirst(str_replace('_', ' ', $serviceRequest->status)) }}
                                </span>
                            </div>
                        </div>

                        @if($serviceRequest->description)
                        <p class="text-gray-600 mb-4">{{ $serviceRequest->description }}</p>
                        @endif
                    </div>

                    {{-- Service Info --}}
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-flask text-blue-600 mr-2"></i>Informasi Layanan
                        </h3>

                        <div class="bg-blue-50 rounded-lg p-4 mb-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-16 h-16 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-microscope text-white text-2xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $serviceRequest->service?->name ?? '-' }}</h4>
                                    <p class="text-sm text-gray-600">{{ $serviceRequest->service?->service_code ?? '-' }}</p>
                                    <div class="mt-2 flex items-center text-sm text-gray-700">
                                        <span class="mr-4">
                                            <i class="fas fa-building mr-1"></i>{{ $serviceRequest->service?->laboratory?->name ?? '-' }}
                                        </span>
                                        <span>
                                            <i class="fas fa-clock mr-1"></i>{{ $serviceRequest->service->duration_days }} hari
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Timeline --}}
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-history text-blue-600 mr-2"></i>Timeline Permohonan
                        </h3>

                        <div class="space-y-4">
                            @if($serviceRequest->created_at)
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-paper-plane text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">Permohonan Diajukan</h4>
                                    <p class="text-sm text-gray-600">{{ $serviceRequest->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($serviceRequest->verified_at)
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">Permohonan Diverifikasi</h4>
                                    <p class="text-sm text-gray-600">{{ $serviceRequest->verified_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($serviceRequest->approved_at)
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check-double text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">Permohonan Disetujui</h4>
                                    <p class="text-sm text-gray-600">{{ $serviceRequest->approved_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($serviceRequest->in_progress_at)
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-cog text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">Proses Dimulai</h4>
                                    <p class="text-sm text-gray-600">{{ $serviceRequest->in_progress_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($serviceRequest->completed_at)
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-flag-checkered text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">Permohonan Selesai</h4>
                                    <p class="text-sm text-gray-600">{{ $serviceRequest->completed_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Quick Info --}}
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Cepat</h3>

                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Pengajuan</p>
                                <p class="font-semibold text-gray-900">{{ $serviceRequest->created_at->format('d M Y') }}</p>
                            </div>

                            @if($serviceRequest->expected_completion_date)
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Diharapkan</p>
                                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($serviceRequest->expected_completion_date)->format('d M Y') }}</p>
                            </div>
                            @endif

                            <div>
                                <p class="text-sm text-gray-600">Estimasi Biaya</p>
                                <p class="font-semibold text-gray-900">Rp {{ number_format($serviceRequest->estimated_cost ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Sample Info --}}
                    @if($serviceRequest->number_of_samples)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sampel</h3>

                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">Jumlah Sampel</p>
                                <p class="font-semibold text-gray-900">{{ $serviceRequest->number_of_samples }} sampel</p>
                            </div>

                            @if($serviceRequest->sample_type)
                            <div>
                                <p class="text-sm text-gray-600">Jenis Sampel</p>
                                <p class="font-semibold text-gray-900">{{ $serviceRequest->sample_type }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Contact Info --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="font-semibold text-blue-900 mb-3">
                            <i class="fas fa-phone mr-2"></i>Butuh Bantuan?
                        </h3>
                        <p class="text-sm text-blue-800 mb-3">
                            Hubungi laboratorium terkait untuk informasi lebih lanjut tentang permohonan Anda.
                        </p>
                        <p class="text-sm font-semibold text-blue-900">
                            {{ $serviceRequest->service?->laboratory?->name ?? 'iLab UNMUL' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="bg-gray-800 text-white py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'iLab UNMUL') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
