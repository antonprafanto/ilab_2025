<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Room Management') }}
            </h2>
            <x-button onclick="window.location.href='{{ route('rooms.create') }}'">
                <i class="fa fa-plus mr-2"></i>
                Tambah Ruang
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <x-alert type="success" dismissible="true" class="mb-4">
                    {{ session('success') }}
                </x-alert>
            @endif

            {{-- Filter Section --}}
            <x-card class="mb-6">
                <form method="GET" action="{{ route('rooms.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <x-label for="search">Pencarian</x-label>
                            <x-input
                                id="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari kode, nama, gedung..."
                            />
                        </div>

                        <div>
                            <x-label for="laboratory_id">Laboratorium</x-label>
                            <x-select id="laboratory_id" name="laboratory_id">
                                <option value="">Semua Laboratorium</option>
                                @foreach($laboratories as $lab)
                                    <option value="{{ $lab->id }}" {{ request('laboratory_id') == $lab->id ? 'selected' : '' }}>
                                        {{ $lab->name }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>

                        <div>
                            <x-label for="type">Tipe</x-label>
                            <x-select id="type" name="type">
                                <option value="">Semua Tipe</option>
                                <option value="research" {{ request('type') == 'research' ? 'selected' : '' }}>Ruang Penelitian</option>
                                <option value="teaching" {{ request('type') == 'teaching' ? 'selected' : '' }}>Ruang Pengajaran</option>
                                <option value="storage" {{ request('type') == 'storage' ? 'selected' : '' }}>Ruang Penyimpanan</option>
                                <option value="preparation" {{ request('type') == 'preparation' ? 'selected' : '' }}>Ruang Persiapan</option>
                                <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>Ruang Rapat</option>
                                <option value="office" {{ request('type') == 'office' ? 'selected' : '' }}>Ruang Kantor</option>
                            </x-select>
                        </div>

                        <div>
                            <x-label for="status">Status</x-label>
                            <x-select id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </x-select>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <x-button type="submit" variant="primary">
                            <i class="fa fa-filter mr-2"></i>
                            Filter
                        </x-button>
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('rooms.index') }}'">
                            Reset
                        </x-button>
                    </div>
                </form>
            </x-card>

            {{-- Rooms Table --}}
            <x-card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kode/Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Laboratorium</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kapasitas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($rooms as $room)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $room->code }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $room->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $room->laboratory?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge variant="secondary" size="sm">{{ $room->type_label }}</x-badge>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $room->full_location }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $room->capacity ? $room->capacity . ' orang' : '-' }}
                                        @if($room->area)
                                            <div class="text-xs text-gray-500">{{ $room->area }} m²</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge :variant="$room->status_badge" size="sm">{{ $room->status_label }}</x-badge>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex gap-2">
                                            <x-button
                                                size="sm"
                                                variant="ghost"
                                                onclick="window.location.href='{{ route('rooms.show', $room) }}'"
                                                title="Lihat Detail"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </x-button>
                                            <x-button
                                                size="sm"
                                                variant="ghost"
                                                onclick="window.location.href='{{ route('rooms.edit', $room) }}'"
                                                title="Edit Ruang"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </x-button>
                                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus ruang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <x-button size="sm" variant="danger" type="submit" title="Hapus Ruang">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </x-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada data ruang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $rooms->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
