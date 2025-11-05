<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Reagent & Chemical Management</h2>
            <x-button onclick="window.location.href='{{ route('reagents.create') }}'">
                <i class="fa fa-plus mr-2"></i>Tambah Reagen
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded">{{ session('success') }}</div>
            @endif

            <x-card class="mb-6">
                <form method="GET" action="{{ route('reagents.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <x-label for="search">Pencarian</x-label>
                            <x-input id="search" name="search" value="{{ request('search') }}" placeholder="Nama, CAS, formula..." />
                        </div>
                        <div>
                            <x-label for="laboratory_id">Laboratorium</x-label>
                            <x-select id="laboratory_id" name="laboratory_id">
                                <option value="">Semua Lab</option>
                                @foreach($laboratories as $lab)
                                    <option value="{{ $lab->id }}" {{ request('laboratory_id') == $lab->id ? 'selected' : '' }}>{{ $lab->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div>
                            <x-label for="category">Kategori</x-label>
                            <x-select id="category" name="category">
                                <option value="">Semua</option>
                                <option value="acid" {{ request('category') == 'acid' ? 'selected' : '' }}>Asam</option>
                                <option value="base" {{ request('category') == 'base' ? 'selected' : '' }}>Basa</option>
                                <option value="solvent" {{ request('category') == 'solvent' ? 'selected' : '' }}>Pelarut</option>
                                <option value="standard" {{ request('category') == 'standard' ? 'selected' : '' }}>Standar</option>
                            </x-select>
                        </div>
                        <div>
                            <x-label for="status">Status</x-label>
                            <x-select id="status" name="status">
                                <option value="">Semua</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Stok Rendah</option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                            </x-select>
                        </div>
                        <div>
                            <x-label for="hazard_class">Bahaya</x-label>
                            <x-select id="hazard_class" name="hazard_class">
                                <option value="">Semua</option>
                                <option value="flammable" {{ request('hazard_class') == 'flammable' ? 'selected' : '' }}>Mudah Terbakar</option>
                                <option value="corrosive" {{ request('hazard_class') == 'corrosive' ? 'selected' : '' }}>Korosif</option>
                                <option value="toxic" {{ request('hazard_class') == 'toxic' ? 'selected' : '' }}>Beracun</option>
                            </x-select>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <x-button type="submit" variant="primary"><i class="fa fa-filter mr-2"></i>Filter</x-button>
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('reagents.index') }}'">Reset</x-button>
                    </div>
                </form>
            </x-card>

            <x-card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Kode/Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">CAS/Formula</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Bahaya</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($reagents as $reagent)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reagent->code }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $reagent->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        @if($reagent->cas_number)<div>CAS: {{ $reagent->cas_number }}</div>@endif
                                        @if($reagent->formula)<div class="text-gray-500">{{ $reagent->formula }}</div>@endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"><x-badge variant="secondary" size="sm">{{ $reagent->category_label }}</x-badge></td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $reagent->quantity }} {{ $reagent->unit }}
                                        @if($reagent->is_low_stock)<div class="text-red-600 text-xs">Stok rendah!</div>@endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge :variant="$reagent->status_badge" size="sm">{{ $reagent->status_label }}</x-badge>
                                        @if($reagent->is_expired)<x-badge variant="danger" size="sm" class="ml-1">Expired</x-badge>@endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"><x-badge :variant="$reagent->hazard_badge" size="sm">{{ $reagent->hazard_label }}</x-badge></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex gap-2">
                                            <x-button size="sm" variant="ghost" onclick="window.location.href='{{ route('reagents.show', $reagent) }}'" title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </x-button>
                                            <x-button size="sm" variant="ghost" onclick="window.location.href='{{ route('reagents.edit', $reagent) }}'" title="Edit Reagen">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </x-button>
                                            <form action="{{ route('reagents.destroy', $reagent) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus reagen ini?')">
                                                @csrf @method('DELETE')
                                                <x-button size="sm" variant="danger" type="submit" title="Hapus Reagen">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </x-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data reagen.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $reagents->links() }}</div>
            </x-card>
        </div>
    </div>
</x-app-layout>
