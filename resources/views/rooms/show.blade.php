<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('rooms.index') }}'" class="mr-4" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </x-button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail Ruang') }}
                </h2>
            </div>
            <div class="flex gap-2">
                <x-button onclick="window.location.href='{{ route('rooms.edit', $room) }}'">
                    <i class="fa fa-edit mr-2"></i>
                    Edit
                </x-button>
                <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus ruang ini?')">
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
                <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header Card --}}
            <x-card>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $room->code }}</h3>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ $room->name }}</p>
                        <div class="mt-2 flex items-center gap-2">
                            <x-badge :variant="$room->status_badge">{{ $room->status_label }}</x-badge>
                            <x-badge variant="secondary">{{ $room->type_label }}</x-badge>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Laboratorium</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $room->laboratory?->name ?? '-' }}</p>
                    </div>
                </div>
            </x-card>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Location & Capacity --}}
                <x-card title="Lokasi & Kapasitas">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $room->full_location }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Luas Ruangan</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $room->area ? $room->area . ' m²' : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kapasitas</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $room->capacity ? $room->capacity . ' orang' : '-' }}</dd>
                        </div>
                        @if($room->responsiblePerson)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Penanggung Jawab</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $room->responsiblePerson?->name ?? '-' }}</dd>
                        </div>
                        @endif
                    </dl>
                </x-card>

                {{-- Description --}}
                <x-card title="Deskripsi">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        {{ $room->description ?: 'Tidak ada deskripsi.' }}
                    </p>
                </x-card>
            </div>

            {{-- Facilities --}}
            @if($room->facilities)
            <x-card title="Fasilitas">
                <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $room->facilities }}</div>
            </x-card>
            @endif

            {{-- Safety Equipment --}}
            @if($room->safety_equipment)
            <x-card title="Peralatan Keselamatan">
                <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $room->safety_equipment }}</div>
            </x-card>
            @endif

            {{-- Notes --}}
            @if($room->notes)
            <x-card title="Catatan">
                <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $room->notes }}</div>
            </x-card>
            @endif
        </div>
    </div>
</x-app-layout>
