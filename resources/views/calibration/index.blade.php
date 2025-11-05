<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Calibration Records') }}
            </h2>
            <x-button variant="primary" onclick="window.location.href='{{ route('calibration.create') }}'">
                <i class="fa fa-plus mr-2"></i> Tambah Record
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filter Card --}}
            <x-card class="mb-6">
                <form method="GET" action="{{ route('calibration.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="md:col-span-2">
                            <x-input name="search" placeholder="Cari kode, equipment, certificate..." value="{{ request('search') }}" />
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
                                <option value="internal" {{ request('type') == 'internal' ? 'selected' : '' }}>Internal</option>
                                <option value="external" {{ request('type') == 'external' ? 'selected' : '' }}>External</option>
                                <option value="verification" {{ request('type') == 'verification' ? 'selected' : '' }}>Verifikasi</option>
                            </x-select>
                        </div>
                        <div>
                            <x-select name="result">
                                <option value="">Semua Hasil</option>
                                <option value="pass" {{ request('result') == 'pass' ? 'selected' : '' }}>Lulus</option>
                                <option value="fail" {{ request('result') == 'fail' ? 'selected' : '' }}>Tidak Lulus</option>
                                <option value="conditional" {{ request('result') == 'conditional' ? 'selected' : '' }}>Bersyarat</option>
                            </x-select>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <x-button type="submit" variant="primary"><i class="fa fa-filter mr-1"></i> Filter</x-button>
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('calibration.index') }}'">Reset</x-button>
                    </div>
                </form>
            </x-card>

            {{-- Table --}}
            <x-card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Equipment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Hasil</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($calibrations as $calibration)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $calibration->calibration_code }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $calibration->equipment?->name ?? '-' }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $calibration->equipment?->code ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $calibration->type_label }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $calibration->calibration_date->format('d M Y') }}</div>
                                        @if($calibration->is_overdue)
                                            <x-badge variant="danger" size="sm" class="mt-1">Overdue</x-badge>
                                        @elseif($calibration->is_due_soon)
                                            <x-badge variant="warning" size="sm" class="mt-1">Due Soon</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge :variant="$calibration->status_badge" size="sm">{{ $calibration->status_label }}</x-badge>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($calibration->result)
                                            <x-badge :variant="$calibration->result_badge" size="sm">{{ $calibration->result_label }}</x-badge>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('calibration.show', $calibration) }}'" title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </x-button>
                                            <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('calibration.edit', $calibration) }}'" title="Edit Calibration">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </x-button>
                                            <form action="{{ route('calibration.destroy', $calibration) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" variant="danger" size="sm" title="Hapus Calibration">
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
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <i class="fa fa-flask text-gray-400 text-5xl mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400">Tidak ada record kalibrasi.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $calibrations->links() }}</div>
            </x-card>
        </div>
    </div>
</x-app-layout>
