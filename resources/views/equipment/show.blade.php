<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('equipment.index') }}'" class="mr-4" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </x-button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail Alat') }}
                </h2>
            </div>
            <div class="flex gap-2">
                <x-button onclick="window.location.href='{{ route('equipment.edit', $equipment) }}'">
                    <i class="fa fa-edit mr-2"></i>
                    Edit
                </x-button>
                <form action="{{ route('equipment.destroy', $equipment) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger">
                        <i class="fa fa-trash mr-2"></i>
                        Hapus
                    </x-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <x-alert type="success" dismissible="true">
                    {{ session('success') }}
                </x-alert>
            @endif

            {{-- Header Card with Photo --}}
            <x-card>
                <div class="flex flex-col md:flex-row gap-6">
                    {{-- Photo --}}
                    <div class="flex-shrink-0">
                        <img src="{{ $equipment->photo_url }}"
                             alt="{{ $equipment->name }}"
                             class="w-full md:w-64 h-48 object-cover rounded-lg">
                    </div>

                    {{-- Basic Info --}}
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $equipment->name }}</h1>
                                <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">{{ $equipment->code }}</p>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <x-badge :variant="$equipment->status_badge" dot="true">
                                    {{ $equipment->status_label }}
                                </x-badge>
                                <x-badge :variant="$equipment->condition_badge">
                                    {{ $equipment->condition_label }}
                                </x-badge>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Laboratorium</p>
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $equipment->laboratory->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Kategori</p>
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $equipment->category_label }}</p>
                            </div>
                            @if($equipment->brand)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Merk & Model</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $equipment->brand }}
                                        @if($equipment->model)
                                            <span class="text-gray-600 dark:text-gray-400">{{ $equipment->model }}</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                            @if($equipment->serial_number)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Serial Number</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $equipment->serial_number }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Equipment Details --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Description & Location --}}
                <x-card title="Informasi Detail">
                    <div class="space-y-3">
                        @if($equipment->description)
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    <i class="fa fa-info-circle mr-1"></i> Deskripsi
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $equipment->description }}</p>
                            </div>
                        @endif

                        @if($equipment->location_detail)
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    <i class="fa fa-map-marker-alt mr-1"></i> Detail Lokasi
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $equipment->location_detail }}</p>
                            </div>
                        @endif

                        @if($equipment->assignedUser)
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    <i class="fa fa-user mr-1"></i> Ditugaskan Kepada
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $equipment->assignedUser->name }}</p>
                            </div>
                        @endif

                        @if($equipment->status_notes)
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    <i class="fa fa-sticky-note mr-1"></i> Catatan Status
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $equipment->status_notes }}</p>
                            </div>
                        @endif
                    </div>
                </x-card>

                {{-- Purchase Info --}}
                @if($equipment->purchase_date || $equipment->purchase_price || $equipment->supplier)
                    <x-card title="Informasi Pembelian">
                        <div class="space-y-3">
                            @if($equipment->purchase_date)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        <i class="fa fa-calendar mr-1"></i> Tanggal Pembelian
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($equipment->purchase_date)->format('d M Y') }}</p>
                                </div>
                            @endif

                            @if($equipment->purchase_price)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        <i class="fa fa-money-bill-wave mr-1"></i> Harga Pembelian
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-400">Rp {{ number_format($equipment->purchase_price, 0, ',', '.') }}</p>
                                </div>
                            @endif

                            @if($equipment->supplier)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        <i class="fa fa-truck mr-1"></i> Supplier
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $equipment->supplier }}</p>
                                </div>
                            @endif

                            @if($equipment->warranty_period || $equipment->warranty_until)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        <i class="fa fa-shield-alt mr-1"></i> Garansi
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ $equipment->warranty_period ?? '-' }}
                                        @if($equipment->warranty_until)
                                            (sampai {{ \Carbon\Carbon::parse($equipment->warranty_until)->format('d M Y') }})
                                        @endif
                                        @if($equipment->is_under_warranty)
                                            <x-badge variant="success" size="sm" class="ml-2">Aktif</x-badge>
                                        @else
                                            <x-badge variant="danger" size="sm" class="ml-2">Berakhir</x-badge>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </x-card>
                @endif
            </div>

            {{-- Maintenance Schedule --}}
            <x-card title="Jadwal Maintenance & Kalibrasi">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Maintenance --}}
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">
                            <i class="fa fa-tools mr-2"></i> Maintenance
                        </h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-blue-700 dark:text-blue-300">Interval</p>
                                <p class="text-base font-medium text-blue-900 dark:text-blue-100">
                                    {{ $equipment->maintenance_interval_days ?? '-' }} hari
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-blue-700 dark:text-blue-300">Terakhir</p>
                                <p class="text-base font-medium text-blue-900 dark:text-blue-100">
                                    {{ $equipment->last_maintenance ? \Carbon\Carbon::parse($equipment->last_maintenance)->format('d M Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-blue-700 dark:text-blue-300">Berikutnya</p>
                                <p class="text-base font-medium text-blue-900 dark:text-blue-100">
                                    {{ $equipment->next_maintenance ? \Carbon\Carbon::parse($equipment->next_maintenance)->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-3">
                            <i class="fa fa-info-circle mr-1"></i> Fitur riwayat maintenance akan tersedia di Chapter 7B
                        </p>
                    </div>

                    {{-- Calibration --}}
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-3">
                            <i class="fa fa-check-circle mr-2"></i> Kalibrasi
                        </h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-green-700 dark:text-green-300">Interval</p>
                                <p class="text-base font-medium text-green-900 dark:text-green-100">
                                    {{ $equipment->calibration_interval_days ?? '-' }} hari
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-green-700 dark:text-green-300">Terakhir</p>
                                <p class="text-base font-medium text-green-900 dark:text-green-100">
                                    {{ $equipment->last_calibration ? \Carbon\Carbon::parse($equipment->last_calibration)->format('d M Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-green-700 dark:text-green-300">Berikutnya</p>
                                <p class="text-base font-medium text-green-900 dark:text-green-100">
                                    {{ $equipment->next_calibration ? \Carbon\Carbon::parse($equipment->next_calibration)->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-3">
                            <i class="fa fa-info-circle mr-1"></i> Fitur riwayat kalibrasi akan tersedia di Chapter 7B
                        </p>
                    </div>
                </div>
            </x-card>

            {{-- Usage Info --}}
            <x-card title="Informasi Penggunaan">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fa fa-hashtag mr-1"></i> Jumlah Penggunaan
                        </h4>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $equipment->usage_count }} <span class="text-sm font-normal text-gray-600">kali</span></p>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fa fa-clock mr-1"></i> Jam Penggunaan
                        </h4>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $equipment->usage_hours }} <span class="text-sm font-normal text-gray-600">jam</span></p>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
