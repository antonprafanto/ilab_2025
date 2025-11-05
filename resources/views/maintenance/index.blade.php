<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Maintenance Records') }}
            </h2>
            <x-button
                variant="primary"
                onclick="window.location.href='{{ route('maintenance.create') }}'"
            >
                <i class="fa fa-plus mr-2"></i> Tambah Record
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter Card --}}
            <x-card class="mb-6">
                <form method="GET" action="{{ route('maintenance.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-2">
                            <x-input
                                name="search"
                                placeholder="Cari kode, equipment, deskripsi..."
                                value="{{ request('search') }}"
                            />
                        </div>
                        <div>
                            <x-select name="equipment_id">
                                <option value="">Semua Equipment</option>
                                @foreach($equipments as $eq)
                                    <option value="{{ $eq->id }}" {{ request('equipment_id') == $eq->id ? 'selected' : '' }}>
                                        {{ $eq->name }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                        <div>
                            <x-select name="type">
                                <option value="">Semua Tipe</option>
                                <option value="preventive" {{ request('type') == 'preventive' ? 'selected' : '' }}>Preventif</option>
                                <option value="corrective" {{ request('type') == 'corrective' ? 'selected' : '' }}>Korektif</option>
                                <option value="breakdown" {{ request('type') == 'breakdown' ? 'selected' : '' }}>Kerusakan</option>
                                <option value="inspection" {{ request('type') == 'inspection' ? 'selected' : '' }}>Inspeksi</option>
                                <option value="cleaning" {{ request('type') == 'cleaning' ? 'selected' : '' }}>Pembersihan</option>
                            </x-select>
                        </div>
                        <div>
                            <x-select name="status">
                                <option value="">Semua Status</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Dijadwalkan</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            </x-select>
                        </div>
                        <div>
                            <x-select name="priority">
                                <option value="">Semua Prioritas</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                            </x-select>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <x-button type="submit" variant="primary">
                            <i class="fa fa-filter mr-1"></i> Filter
                        </x-button>
                        <x-button
                            type="button"
                            variant="ghost"
                            onclick="window.location.href='{{ route('maintenance.index') }}'"
                        >
                            Reset
                        </x-button>
                    </div>
                </form>
            </x-card>

            {{-- Maintenance Records Table --}}
            <x-card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Kode
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Equipment
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Tipe
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Prioritas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Jadwal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Teknisi
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($maintenances as $maintenance)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $maintenance->maintenance_code }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $maintenance->equipment?->name ?? '-' }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $maintenance->equipment?->code ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $maintenance->type_label }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge :variant="$maintenance->priority_badge" size="sm">
                                            {{ $maintenance->priority_label }}
                                        </x-badge>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $maintenance->scheduled_date->format('d M Y') }}
                                        </div>
                                        @if($maintenance->is_overdue)
                                            <x-badge variant="danger" size="sm" class="mt-1">Terlambat</x-badge>
                                        @elseif($maintenance->is_upcoming)
                                            <x-badge variant="warning" size="sm" class="mt-1">Segera</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge :variant="$maintenance->status_badge" size="sm">
                                            {{ $maintenance->status_label }}
                                        </x-badge>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $maintenance->technician?->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-button
                                                variant="ghost"
                                                size="sm"
                                                onclick="window.location.href='{{ route('maintenance.show', $maintenance) }}'"
                                                title="Lihat Detail"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </x-button>
                                            <x-button
                                                variant="ghost"
                                                size="sm"
                                                onclick="window.location.href='{{ route('maintenance.edit', $maintenance) }}'"
                                                title="Edit Maintenance"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </x-button>
                                            <form action="{{ route('maintenance.destroy', $maintenance) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus record ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" variant="danger" size="sm" title="Hapus Maintenance">
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
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <i class="fa fa-wrench text-gray-400 text-5xl mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400">Tidak ada record maintenance.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $maintenances->links() }}
                </div>
            </x-card>

        </div>
    </div>
</x-app-layout>
