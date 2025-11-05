<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('reagents.index') }}'" class="mr-4" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </x-button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Detail Reagen
                </h2>
            </div>
            <div class="flex gap-2">
                <x-button onclick="window.location.href='{{ route('reagents.edit', $reagent) }}'">
                    <i class="fa fa-edit mr-2"></i>
                    Edit
                </x-button>
                <form action="{{ route('reagents.destroy', $reagent) }}" method="POST" class="inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus reagen ini?');">
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <!-- Basic Information -->
                <x-card title="Informasi Dasar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Kode Reagen</h4>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $reagent->code }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Reagen</h4>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $reagent->name }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Laboratorium</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                <a href="{{ route('laboratories.show', $reagent->laboratory) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $reagent->laboratory->name }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h4>
                            <p class="mt-1">
                                <x-badge :variant="$reagent->status_badge">{{ $reagent->status_label }}</x-badge>
                            </p>
                        </div>
                    </div>
                </x-card>

                <!-- Chemical Information -->
                <x-card title="Informasi Kimia">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">CAS Number</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 font-mono">{{ $reagent->cas_number ?? '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Formula Kimia</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 font-mono">{{ $reagent->formula ?? '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                <x-badge variant="info">{{ $reagent->category_label }}</x-badge>
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Grade/Purity</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $reagent->grade ?? '-' }}</p>
                        </div>
                    </div>
                </x-card>

                <!-- Stock Information -->
                <x-card title="Informasi Stok">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Tersedia</h4>
                            <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $reagent->quantity }} {{ $reagent->unit }}
                                @if($reagent->is_low_stock)
                                    <x-badge variant="danger" class="ml-2">Stok Rendah!</x-badge>
                                @endif
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Minimum Stok</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $reagent->min_stock_level ? $reagent->min_stock_level . ' ' . $reagent->unit : '-' }}
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi Penyimpanan</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $reagent->storage_location ?? '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Kondisi Penyimpanan</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                <x-badge variant="secondary">{{ $reagent->storage_condition_label }}</x-badge>
                            </p>
                        </div>
                    </div>
                </x-card>

                <!-- Hazard Information -->
                <x-card title="Informasi Bahaya">
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Kelas Bahaya</h3>
                                <div class="mt-2">
                                    <x-badge :variant="$reagent->hazard_badge" class="text-base">
                                        {{ $reagent->hazard_label }}
                                    </x-badge>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Safety Data Sheet</h4>
                            <p class="mt-1">
                                @if($reagent->sds_file)
                                    <a href="{{ asset('storage/' . $reagent->sds_file) }}"
                                       target="_blank"
                                       class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download SDS ({{ basename($reagent->sds_file) }})
                                    </a>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">Tidak ada file SDS</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Kadaluarsa</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                @if($reagent->expiry_date)
                                    {{ $reagent->expiry_date->format('d/m/Y') }}
                                    @if($reagent->is_expired)
                                        <x-badge variant="danger" class="ml-2">Expired</x-badge>
                                    @elseif($reagent->is_expiring_soon)
                                        <x-badge variant="warning" class="ml-2">Segera Kadaluarsa ({{ $reagent->days_until_expiry }} hari)</x-badge>
                                    @endif
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($reagent->safety_notes)
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Catatan Keamanan</h4>
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md p-4">
                                <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $reagent->safety_notes }}</p>
                            </div>
                        </div>
                    @endif
                </x-card>

                <!-- Supplier & Purchase Information -->
                <x-card title="Informasi Supplier & Pembelian">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Manufacturer</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $reagent->manufacturer ?? '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Supplier</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $reagent->supplier ?? '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Lot/Batch</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 font-mono">{{ $reagent->lot_number ?? '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Katalog</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 font-mono">{{ $reagent->catalog_number ?? '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pembelian</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $reagent->purchase_date?->format('d/m/Y') ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Dibuka</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $reagent->opened_date?->format('d/m/Y') ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Harga (Rp)</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $reagent->price ? 'Rp ' . number_format($reagent->price, 0, ',', '.') : '-' }}
                            </p>
                        </div>
                    </div>
                </x-card>

                <!-- Additional Information -->
                @if($reagent->description || $reagent->usage_instructions || $reagent->disposal_instructions || $reagent->notes)
                <x-card title="Informasi Tambahan">
                    @if($reagent->description)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Deskripsi</h4>
                            <p class="text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $reagent->description }}</p>
                        </div>
                    @endif

                    @if($reagent->usage_instructions)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Instruksi Penggunaan</h4>
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
                                <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $reagent->usage_instructions }}</p>
                            </div>
                        </div>
                    @endif

                    @if($reagent->disposal_instructions)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Instruksi Pembuangan</h4>
                            <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-md p-4">
                                <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $reagent->disposal_instructions }}</p>
                            </div>
                        </div>
                    @endif

                    @if($reagent->notes)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Catatan</h4>
                            <p class="text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $reagent->notes }}</p>
                        </div>
                    @endif
                </x-card>
                @endif

                <!-- Metadata -->
                <x-card title="Metadata">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $reagent->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diperbarui</h4>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $reagent->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
