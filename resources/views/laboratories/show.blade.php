<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('laboratories.index') }}'" class="mr-4" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </x-button>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $laboratory->name }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $laboratory->code }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <x-button onclick="window.location.href='{{ route('laboratories.edit', $laboratory) }}'">
                    <i class="fa fa-edit mr-2"></i>
                    Edit
                </x-button>
                <form action="{{ route('laboratories.destroy', $laboratory) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus laboratorium ini?')">
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

            {{-- Success Alert --}}
            @if(session('success'))
                <x-alert type="success" dismissible="true">
                    {{ session('success') }}
                </x-alert>
            @endif

            {{-- Main Info Card --}}
            <x-card>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Photo --}}
                    <div class="md:col-span-1">
                        <img
                            src="{{ $laboratory->photo_url }}"
                            alt="{{ $laboratory->name }}"
                            class="w-full h-64 object-cover rounded-lg"
                        />
                    </div>

                    {{-- Basic Info --}}
                    <div class="md:col-span-2 space-y-4">
                        <div class="flex gap-2">
                            <x-badge :variant="$laboratory->status_badge" dot="true" size="lg">
                                {{ $laboratory->status_label }}
                            </x-badge>
                            <x-badge variant="primary" size="lg">
                                <i class="fa fa-flask mr-1"></i> {{ $laboratory->type_label }}
                            </x-badge>
                        </div>

                        @if($laboratory->description)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Deskripsi</h3>
                                <p class="text-gray-600 dark:text-gray-400">{{ $laboratory->description }}</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($laboratory->location)
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        <i class="fa fa-map-marker-alt mr-1"></i> Lokasi
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $laboratory->location }}</p>
                                </div>
                            @endif

                            @if($laboratory->headUser)
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        <i class="fa fa-user-tie mr-1"></i> Kepala Laboratorium
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $laboratory->headUser->full_name }}</p>
                                </div>
                            @endif

                            @if($laboratory->area_sqm)
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        <i class="fa fa-ruler-combined mr-1"></i> Luas Ruangan
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">{{ number_format($laboratory->area_sqm, 2) }} m²</p>
                                </div>
                            @endif

                            @if($laboratory->capacity)
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        <i class="fa fa-users mr-1"></i> Kapasitas
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $laboratory->capacity }} orang</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Contact & Operating Hours --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Contact Info --}}
                <x-card title="Informasi Kontak">
                    <div class="space-y-3">
                        @if($laboratory->phone)
                            <div class="flex items-center">
                                <i class="fa fa-phone w-6 text-gray-400"></i>
                                <a href="tel:{{ $laboratory->phone }}" class="text-[#0066CC] hover:underline">
                                    {{ $laboratory->phone }}
                                </a>
                            </div>
                        @endif

                        @if($laboratory->email)
                            <div class="flex items-center">
                                <i class="fa fa-envelope w-6 text-gray-400"></i>
                                <a href="mailto:{{ $laboratory->email }}" class="text-[#0066CC] hover:underline">
                                    {{ $laboratory->email }}
                                </a>
                            </div>
                        @endif

                        @if(!$laboratory->phone && !$laboratory->email)
                            <p class="text-sm text-gray-500 dark:text-gray-400">Informasi kontak belum tersedia</p>
                        @endif
                    </div>
                </x-card>

                {{-- Operating Hours --}}
                <x-card title="Jam Operasional">
                    <div class="space-y-3">
                        @if($laboratory->operating_hours_start && $laboratory->operating_hours_end)
                            <div class="flex items-center">
                                <i class="fa fa-clock w-6 text-gray-400"></i>
                                <span class="text-gray-600 dark:text-gray-400">
                                    {{ $laboratory->operating_hours_start->format('H:i') }} - {{ $laboratory->operating_hours_end->format('H:i') }}
                                </span>
                            </div>
                        @endif

                        @if($laboratory->operating_days && count($laboratory->operating_days) > 0)
                            <div class="flex items-start">
                                <i class="fa fa-calendar w-6 text-gray-400 mt-1"></i>
                                <div class="flex flex-wrap gap-1">
                                    @php
                                        $dayLabels = [
                                            'Monday' => 'Sen', 'Tuesday' => 'Sel', 'Wednesday' => 'Rab',
                                            'Thursday' => 'Kam', 'Friday' => 'Jum', 'Saturday' => 'Sab', 'Sunday' => 'Min'
                                        ];
                                    @endphp
                                    @foreach($laboratory->operating_days as $day)
                                        <x-badge variant="default" size="sm">
                                            {{ $dayLabels[$day] ?? $day }}
                                        </x-badge>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(!$laboratory->operating_hours_start && !$laboratory->operating_hours_end && (!$laboratory->operating_days || count($laboratory->operating_days) === 0))
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jam operasional belum diatur</p>
                        @endif
                    </div>
                </x-card>
            </div>

            {{-- Status Notes --}}
            @if($laboratory->status !== 'active' && $laboratory->status_notes)
                <x-alert type="warning">
                    <div>
                        <h4 class="font-semibold mb-1">Catatan Status</h4>
                        <p>{{ $laboratory->status_notes }}</p>
                    </div>
                </x-alert>
            @endif

            {{-- Tabs for Rooms, Equipment & Services --}}
            <x-tabs style="underline" :tabs="[
                ['id' => 'info', 'label' => 'Informasi Tambahan', 'icon' => 'fa fa-info-circle'],
                ['id' => 'rooms', 'label' => 'Ruangan', 'icon' => 'fa fa-door-open', 'badge' => $laboratory->rooms->count()],
                ['id' => 'equipment', 'label' => 'Peralatan', 'icon' => 'fa fa-microscope', 'badge' => $laboratory->equipment->count()],
                ['id' => 'services', 'label' => 'Layanan', 'icon' => 'fa fa-concierge-bell', 'badge' => '0']
            ]">
                <x-tab-content id="info">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Facilities --}}
                        @if($laboratory->facilities && count($laboratory->facilities) > 0)
                            <x-card title="Fasilitas">
                                <ul class="space-y-2">
                                    @foreach($laboratory->facilities as $facility)
                                        <li class="flex items-center text-gray-600 dark:text-gray-400">
                                            <i class="fa fa-check-circle text-green-500 mr-2"></i>
                                            {{ $facility }}
                                        </li>
                                    @endforeach
                                </ul>
                            </x-card>
                        @endif

                        {{-- Certifications --}}
                        @if($laboratory->certifications && count($laboratory->certifications) > 0)
                            <x-card title="Sertifikasi">
                                <ul class="space-y-2">
                                    @foreach($laboratory->certifications as $cert)
                                        <li class="flex items-center text-gray-600 dark:text-gray-400">
                                            <i class="fa fa-certificate text-[#0066CC] mr-2"></i>
                                            {{ $cert }}
                                        </li>
                                    @endforeach
                                </ul>
                            </x-card>
                        @endif
                    </div>

                    @if((!$laboratory->facilities || count($laboratory->facilities) === 0) && (!$laboratory->certifications || count($laboratory->certifications) === 0))
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                            Belum ada informasi tambahan
                        </p>
                    @endif
                </x-tab-content>

                <x-tab-content id="rooms">
                    @if($laboratory->rooms->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($laboratory->rooms as $room)
                                <x-card class="hover:shadow-lg transition-shadow cursor-pointer" onclick="window.location.href='{{ route('rooms.show', $room) }}'">
                                    <div class="space-y-3">
                                        {{-- Header --}}
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $room->code }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $room->name }}</p>
                                        </div>

                                        {{-- Badges --}}
                                        <div class="flex flex-wrap gap-2">
                                            <x-badge :variant="$room->status_badge" size="sm">
                                                {{ $room->status_label }}
                                            </x-badge>
                                            <x-badge variant="secondary" size="sm">
                                                {{ $room->type_label }}
                                            </x-badge>
                                        </div>

                                        {{-- Info Grid --}}
                                        <div class="grid grid-cols-2 gap-3 text-sm pt-2 border-t border-gray-200 dark:border-gray-700">
                                            @if($room->capacity)
                                                <div>
                                                    <p class="text-gray-500 dark:text-gray-400 text-xs">Kapasitas</p>
                                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                                        <i class="fa fa-users text-xs mr-1"></i>{{ $room->capacity }} orang
                                                    </p>
                                                </div>
                                            @endif
                                            @if($room->area)
                                                <div>
                                                    <p class="text-gray-500 dark:text-gray-400 text-xs">Luas</p>
                                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                                        <i class="fa fa-expand text-xs mr-1"></i>{{ $room->area }} m²
                                                    </p>
                                                </div>
                                            @endif
                                        </div>

                                        @if($room->full_location)
                                            <div class="text-sm pt-2">
                                                <p class="text-gray-500 dark:text-gray-400 text-xs">Lokasi</p>
                                                <p class="text-gray-700 dark:text-gray-300">
                                                    <i class="fa fa-map-marker-alt text-xs mr-1"></i>{{ $room->full_location }}
                                                </p>
                                            </div>
                                        @endif

                                        {{-- Action Button --}}
                                        <div class="pt-2">
                                            <button class="w-full text-center text-sm text-[#0066CC] hover:text-[#0052A3] font-medium">
                                                Lihat Detail <i class="fa fa-arrow-right ml-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fa fa-door-open text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">
                                Belum ada ruangan terdaftar di laboratorium ini
                            </p>
                            <x-button
                                variant="primary"
                                size="sm"
                                onclick="window.location.href='{{ route('rooms.create') }}?laboratory_id={{ $laboratory->id }}'"
                                class="mt-4"
                            >
                                <i class="fa fa-plus mr-2"></i>
                                Tambah Ruangan
                            </x-button>
                        </div>
                    @endif
                </x-tab-content>

                <x-tab-content id="equipment">
                    @if($laboratory->equipment->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($laboratory->equipment as $item)
                                <x-card class="hover:shadow-lg transition-shadow cursor-pointer" onclick="window.location.href='{{ route('equipment.show', $item) }}'">
                                    <div class="space-y-3">
                                        {{-- Header --}}
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $item->code }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item->name }}</p>
                                        </div>

                                        {{-- Badges --}}
                                        <div class="flex flex-wrap gap-2">
                                            <x-badge :variant="$item->status_badge" size="sm">
                                                {{ $item->status_label }}
                                            </x-badge>
                                            <x-badge :variant="$item->condition_badge" size="sm">
                                                {{ $item->condition_label }}
                                            </x-badge>
                                        </div>

                                        {{-- Info Grid --}}
                                        <div class="grid grid-cols-2 gap-3 text-sm pt-2 border-t border-gray-200 dark:border-gray-700">
                                            @if($item->brand)
                                                <div>
                                                    <p class="text-gray-500 dark:text-gray-400 text-xs">Brand</p>
                                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $item->brand }}
                                                    </p>
                                                </div>
                                            @endif
                                            @if($item->category)
                                                <div>
                                                    <p class="text-gray-500 dark:text-gray-400 text-xs">Kategori</p>
                                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $item->category_label }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>

                                        @if($item->location_detail)
                                            <div class="text-sm pt-2">
                                                <p class="text-gray-500 dark:text-gray-400 text-xs">Lokasi</p>
                                                <p class="text-gray-700 dark:text-gray-300">
                                                    <i class="fa fa-map-marker-alt text-xs mr-1"></i>{{ $item->location_detail }}
                                                </p>
                                            </div>
                                        @endif

                                        {{-- Action Button --}}
                                        <div class="pt-2">
                                            <button class="w-full text-center text-sm text-[#0066CC] hover:text-[#0052A3] font-medium">
                                                Lihat Detail <i class="fa fa-arrow-right ml-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fa fa-microscope text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">
                                Belum ada peralatan terdaftar di laboratorium ini
                            </p>
                            <x-button
                                variant="primary"
                                size="sm"
                                onclick="window.location.href='{{ route('equipment.create') }}?laboratory_id={{ $laboratory->id }}'"
                                class="mt-4"
                            >
                                <i class="fa fa-plus mr-2"></i>
                                Tambah Peralatan
                            </x-button>
                        </div>
                    @endif
                </x-tab-content>

                <x-tab-content id="services">
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                        Manajemen layanan akan tersedia di Chapter 9
                    </p>
                </x-tab-content>
            </x-tabs>

        </div>
    </div>
</x-app-layout>
