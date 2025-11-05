<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Alat') }}
            </h2>
            <a href="{{ route('equipment.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Alat
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <x-alert type="success" dismissible="true" class="mb-4">
                    {{ session('success') }}
                </x-alert>
            @endif

            {{-- Filter Section --}}
            <x-card class="mb-6">
                <form method="GET" action="{{ route('equipment.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        {{-- Search --}}
                        <div class="md:col-span-2">
                            <x-input
                                name="search"
                                placeholder="Cari nama, kode, merk, model, SN..."
                                value="{{ request('search') }}"
                                icon="fa fa-search"
                                iconPosition="left" />
                        </div>

                        {{-- Laboratory Filter --}}
                        <div>
                            <x-select
                                name="laboratory_id"
                                placeholder="Semua Lab"
                                :options="$laboratories->pluck('name', 'id')->toArray()"
                                value="{{ request('laboratory_id') }}" />
                        </div>

                        {{-- Category Filter --}}
                        <div>
                            <x-select
                                name="category"
                                placeholder="Kategori"
                                :options="[
                                    'analytical' => 'Analitik',
                                    'measurement' => 'Pengukuran',
                                    'preparation' => 'Preparasi',
                                    'safety' => 'Keselamatan',
                                    'computer' => 'Komputer',
                                    'general' => 'Umum'
                                ]"
                                value="{{ request('category') }}" />
                        </div>

                        {{-- Status Filter --}}
                        <div>
                            <x-select
                                name="status"
                                placeholder="Status"
                                :options="[
                                    'available' => 'Tersedia',
                                    'in_use' => 'Digunakan',
                                    'maintenance' => 'Maintenance',
                                    'calibration' => 'Kalibrasi',
                                    'broken' => 'Rusak',
                                    'retired' => 'Retired'
                                ]"
                                value="{{ request('status') }}" />
                        </div>

                        {{-- Condition Filter --}}
                        <div>
                            <x-select
                                name="condition"
                                placeholder="Kondisi"
                                :options="[
                                    'excellent' => 'Sangat Baik',
                                    'good' => 'Baik',
                                    'fair' => 'Cukup',
                                    'poor' => 'Buruk',
                                    'broken' => 'Rusak'
                                ]"
                                value="{{ request('condition') }}" />
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <x-button type="submit" variant="primary">
                            <i class="fa fa-filter mr-2"></i> Filter
                        </x-button>
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('equipment.index') }}'">
                            Reset
                        </x-button>
                    </div>
                </form>
            </x-card>

            {{-- Equipment Grid --}}
            @if($equipment->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada alat</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan alat baru.</p>
                        <div class="mt-6">
                            <a href="{{ route('equipment.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Alat
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($equipment as $item)
                        <x-card class="hover:shadow-lg transition-shadow duration-200">
                            {{-- Equipment Photo --}}
                            <div class="mb-4 -mx-6 -mt-6">
                                <div class="relative">
                                    <img src="{{ $item->photo_url }}"
                                         alt="{{ $item->name }}"
                                         class="w-full h-48 object-cover rounded-t-lg">

                                    {{-- Status Badge --}}
                                    <div class="absolute top-2 right-2">
                                        <x-badge :variant="$item->status_badge" dot="true">
                                            {{ $item->status_label }}
                                        </x-badge>
                                    </div>
                                </div>
                            </div>

                            {{-- Equipment Info --}}
                            <div class="space-y-3">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">
                                        {{ $item->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item->code }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <x-badge variant="primary" size="sm">
                                        <i class="fa fa-flask mr-1"></i> {{ $item->category_label }}
                                    </x-badge>
                                    <x-badge :variant="$item->condition_badge" size="sm">
                                        {{ $item->condition_label }}
                                    </x-badge>
                                </div>

                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fa fa-building mr-2 text-gray-400"></i>
                                    {{ $item->laboratory->name }}
                                </div>

                                @if($item->brand)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fa fa-tag mr-2 text-gray-400"></i>
                                        {{ $item->brand }}
                                        @if($item->model)
                                            <span class="text-gray-500 ml-1">{{ $item->model }}</span>
                                        @endif
                                    </div>
                                @endif

                                @if($item->assignedUser)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fa fa-user mr-2 text-gray-400"></i>
                                        {{ $item->assignedUser->name }}
                                    </div>
                                @endif

                                {{-- Action Buttons --}}
                                <div class="flex gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <x-button
                                        variant="ghost"
                                        size="sm"
                                        onclick="window.location.href='{{ route('equipment.show', $item) }}'"
                                        title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </x-button>
                                    <x-button
                                        variant="ghost"
                                        size="sm"
                                        onclick="window.location.href='{{ route('equipment.edit', $item) }}'"
                                        title="Edit Equipment">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </x-button>
                                    <form action="{{ route('equipment.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="danger" size="sm" title="Hapus Equipment">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </x-button>
                                    </form>
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        {{ $equipment->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
