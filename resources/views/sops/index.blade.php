<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Standard Operating Procedure (SOP)') }}
            </h2>
            @can('create-sop')
                <x-button variant="primary" size="sm" onclick="window.location.href='{{ route('sops.create') }}'">
                    <i class="fa fa-plus mr-1"></i> Tambah SOP
                </x-button>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filter Section --}}
            <x-card class="mb-6">
                <form method="GET" action="{{ route('sops.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        {{-- Search Box --}}
                        <div class="md:col-span-3">
                            <x-input
                                name="search"
                                placeholder="Cari judul, kode SOP, deskripsi..."
                                value="{{ request('search') }}"
                                icon="fa fa-search"
                                iconPosition="left"
                            />
                        </div>

                        {{-- Laboratory Filter --}}
                        <div>
                            <x-select
                                name="laboratory_id"
                                placeholder="Semua Lab"
                                :options="$laboratories->pluck('name', 'id')->toArray()"
                                value="{{ request('laboratory_id') }}"
                            />
                        </div>

                        {{-- Category Filter --}}
                        <div>
                            <x-select
                                name="category"
                                placeholder="Kategori"
                                :options="[
                                    'equipment' => 'Penggunaan Alat',
                                    'testing' => 'Pengujian',
                                    'safety' => 'Keselamatan',
                                    'quality' => 'Mutu/Kualitas',
                                    'maintenance' => 'Pemeliharaan',
                                    'calibration' => 'Kalibrasi',
                                    'general' => 'Umum'
                                ]"
                                value="{{ request('category') }}"
                            />
                        </div>

                        {{-- Status Filter --}}
                        <div>
                            <x-select
                                name="status"
                                placeholder="Status"
                                :options="[
                                    'draft' => 'Draft',
                                    'review' => 'Dalam Review',
                                    'approved' => 'Disetujui',
                                    'archived' => 'Diarsipkan'
                                ]"
                                value="{{ request('status') }}"
                            />
                        </div>
                    </div>

                    <div class="flex gap-2 mt-4">
                        <x-button type="submit" variant="primary">
                            <i class="fa fa-filter mr-2"></i> Filter
                        </x-button>
                        <x-button
                            type="button"
                            variant="ghost"
                            onclick="window.location.href='{{ route('sops.index') }}'"
                        >
                            Reset
                        </x-button>
                    </div>
                </form>
            </x-card>

            {{-- SOP Grid --}}
            @if($sops->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sops as $sop)
                        <x-card class="hover:shadow-lg transition-shadow duration-200">
                            <div class="space-y-3">
                                {{-- Header with Status Badge --}}
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">
                                            {{ $sop->title }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $sop->code }}
                                        </p>
                                    </div>
                                    <x-badge :variant="$sop->status_badge" dot="true">
                                        {{ $sop->status_label }}
                                    </x-badge>
                                </div>

                                {{-- Category & Version --}}
                                <div class="flex items-center gap-2">
                                    <x-badge variant="primary" size="sm">
                                        <i class="fa fa-folder mr-1"></i> {{ $sop->category_label }}
                                    </x-badge>
                                    <x-badge variant="info" size="sm">
                                        v{{ $sop->full_version }}
                                    </x-badge>
                                </div>

                                {{-- Info --}}
                                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    @if($sop->laboratory)
                                        <p><i class="fa fa-building w-4 mr-2"></i> {{ $sop->laboratory->name }}</p>
                                    @endif
                                    @if($sop->preparer)
                                        <p><i class="fa fa-user w-4 mr-2"></i> {{ $sop->preparer->name }}</p>
                                    @endif
                                    @if($sop->effective_date)
                                        <p>
                                            <i class="fa fa-calendar w-4 mr-2"></i>
                                            Efektif: {{ $sop->effective_date->format('d M Y') }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex items-center gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <x-button
                                        variant="ghost"
                                        size="sm"
                                        onclick="window.location.href='{{ route('sops.show', $sop) }}'"
                                        title="Lihat Detail"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </x-button>

                                    @can('edit-sop')
                                        <x-button
                                            variant="ghost"
                                            size="sm"
                                            onclick="window.location.href='{{ route('sops.edit', $sop) }}'"
                                            title="Edit SOP"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </x-button>
                                    @endcan

                                    @can('delete-sop')
                                        <form action="{{ route('sops.destroy', $sop) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus SOP ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" variant="danger" size="sm" title="Hapus SOP">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </x-button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $sops->links() }}
                </div>
            @else
                <x-card>
                    <div class="text-center py-12">
                        <i class="fa fa-file-alt text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Tidak ada SOP ditemukan
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">
                            @if(request()->hasAny(['search', 'laboratory_id', 'category', 'status']))
                                Coba ubah filter pencarian Anda
                            @else
                                Belum ada SOP yang terdaftar
                            @endif
                        </p>
                        @can('create-sop')
                            <x-button variant="primary" onclick="window.location.href='{{ route('sops.create') }}'">
                                <i class="fa fa-plus mr-2"></i> Tambah SOP Pertama
                            </x-button>
                        @endcan
                    </div>
                </x-card>
            @endif
        </div>
    </div>
</x-app-layout>
