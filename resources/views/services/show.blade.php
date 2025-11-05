<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Layanan') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('services.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <a href="{{ route('services.edit', $service) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('services.destroy', $service) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Yakin ingin menghapus layanan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Header Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            @php
                                // Badge dengan warna yang JELAS TERLIHAT (sama dengan index)
                                $badgeStyles = [
                                    'kimia' => 'bg-blue-600 text-white',
                                    'biologi' => 'bg-green-600 text-white',
                                    'fisika' => 'bg-purple-600 text-white',
                                    'mikrobiologi' => 'bg-pink-600 text-white',
                                    'material' => 'bg-gray-700 text-white',
                                    'lingkungan' => 'bg-teal-600 text-white',
                                    'pangan' => 'bg-orange-600 text-white',
                                    'farmasi' => 'bg-red-600 text-white',
                                ];
                                $badgeClass = $badgeStyles[$service->category] ?? 'bg-gray-700 text-white';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }} mb-3">
                                {{ $service->category_label }}
                            </span>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $service->name }}</h1>
                            <p class="text-sm text-gray-500 mb-2">Kode: {{ $service->code }}</p>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-flask mr-2"></i>{{ $service->laboratory->name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Dilihat</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $service->popularity }}x</p>
                        </div>
                    </div>

                    @if($service->description)
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Deskripsi</h3>
                            <p class="text-gray-600">{{ $service->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Main Info --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Categorization --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-tag mr-2 text-blue-500"></i>Kategori & Metode
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Kategori</p>
                                    <p class="font-medium">{{ $service->category_label }}</p>
                                </div>
                                @if($service->subcategory)
                                    <div>
                                        <p class="text-sm text-gray-500">Sub-kategori</p>
                                        <p class="font-medium">{{ $service->subcategory }}</p>
                                    </div>
                                @endif
                                @if($service->method)
                                    <div class="md:col-span-2">
                                        <p class="text-sm text-gray-500">Metode</p>
                                        <p class="font-medium">{{ $service->method }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Requirements --}}
                    @if($service->requirements && count($service->requirements) > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    <i class="fas fa-check-circle mr-2 text-green-500"></i>Persyaratan
                                </h3>
                                <ul class="list-disc list-inside space-y-2">
                                    @foreach($service->requirements as $requirement)
                                        <li class="text-gray-600">{{ $requirement }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Equipment Needed --}}
                    @if($service->equipment_needed && count($service->equipment_needed) > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    <i class="fas fa-toolbox mr-2 text-orange-500"></i>Peralatan Dibutuhkan
                                </h3>
                                <p class="text-sm text-gray-600">Equipment IDs: {{ implode(', ', $service->equipment_needed) }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Sample Preparation --}}
                    @if($service->sample_preparation)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    <i class="fas fa-flask mr-2 text-purple-500"></i>Preparasi Sampel
                                </h3>
                                <p class="text-gray-600 whitespace-pre-line">{{ $service->sample_preparation }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Deliverables --}}
                    @if($service->deliverables && count($service->deliverables) > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    <i class="fas fa-file-alt mr-2 text-blue-500"></i>Hasil yang Diterima
                                </h3>
                                <ul class="list-disc list-inside space-y-2">
                                    @foreach($service->deliverables as $deliverable)
                                        <li class="text-gray-600">{{ $deliverable }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">

                    {{-- Duration --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-clock mr-2 text-blue-500"></i>Durasi
                            </h3>
                            <p class="text-3xl font-bold text-blue-600 mb-2">{{ $service->duration_days }}</p>
                            <p class="text-sm text-gray-500">hari kerja</p>
                        </div>
                    </div>

                    {{-- Pricing --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-money-bill-wave mr-2 text-green-500"></i>Harga
                            </h3>
                            <div class="space-y-3">
                                <div class="p-3 bg-blue-50 rounded-lg">
                                    <p class="text-xs text-gray-500 mb-1">Internal (Mahasiswa/Dosen UNMUL)</p>
                                    <p class="text-xl font-bold text-blue-600">
                                        Rp {{ number_format($service->price_internal, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="p-3 bg-green-50 rounded-lg">
                                    <p class="text-xs text-gray-500 mb-1">External Edu (Universitas Lain)</p>
                                    <p class="text-xl font-bold text-green-600">
                                        Rp {{ number_format($service->price_external_edu, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="p-3 bg-orange-50 rounded-lg">
                                    <p class="text-xs text-gray-500 mb-1">External (Industri/Umum)</p>
                                    <p class="text-xl font-bold text-orange-600">
                                        Rp {{ number_format($service->price_external, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            @if($service->urgent_surcharge_percent > 0)
                                <div class="mt-3 p-3 bg-red-50 rounded-lg">
                                    <p class="text-xs text-gray-500 mb-1">Biaya Urgent</p>
                                    <p class="text-lg font-bold text-red-600">+{{ $service->urgent_surcharge_percent }}%</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Sample Limits --}}
                    @if($service->min_sample || $service->max_sample)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    <i class="fas fa-vial mr-2 text-purple-500"></i>Batas Sampel
                                </h3>
                                <div class="space-y-2">
                                    @if($service->min_sample)
                                        <div>
                                            <p class="text-sm text-gray-500">Minimum</p>
                                            <p class="text-lg font-bold">{{ $service->min_sample }} sampel</p>
                                        </div>
                                    @endif
                                    @if($service->max_sample)
                                        <div>
                                            <p class="text-sm text-gray-500">Maksimum per Batch</p>
                                            <p class="text-lg font-bold">{{ $service->max_sample }} sampel</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Status --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-info-circle mr-2 text-gray-500"></i>Status
                            </h3>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-sm text-gray-500">Status Aktif</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Ditambahkan</p>
                                    <p class="text-sm">{{ $service->created_at->format('d M Y') }}</p>
                                </div>
                                @if($service->updated_at != $service->created_at)
                                    <div>
                                        <p class="text-sm text-gray-500">Terakhir Diperbarui</p>
                                        <p class="text-sm">{{ $service->updated_at->format('d M Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
