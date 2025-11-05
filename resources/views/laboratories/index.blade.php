<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Laboratorium') }}
            </h2>
            <x-button variant="primary" onclick="window.location.href='{{ route('laboratories.create') }}'">
                <i class="fa fa-plus mr-2"></i> Tambah Laboratorium
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Alert --}}
            @if(session('success'))
                <div class="mb-6">
                    <x-alert type="success" dismissible="true">
                        {{ session('success') }}
                    </x-alert>
                </div>
            @endif

            {{-- Filter Section --}}
            <x-card class="mb-6">
                <form method="GET" action="{{ route('laboratories.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        {{-- Search --}}
                        <div class="md:col-span-2">
                            <x-input
                                name="search"
                                placeholder="Cari nama, kode, atau lokasi laboratorium..."
                                value="{{ request('search') }}"
                                icon="fa fa-search"
                                iconPosition="left" />
                        </div>

                        {{-- Type Filter --}}
                        <div>
                            <x-select
                                name="type"
                                placeholder="Semua Tipe"
                                :options="[
                                    'chemistry' => 'Kimia',
                                    'biology' => 'Biologi',
                                    'physics' => 'Fisika',
                                    'geology' => 'Geologi',
                                    'engineering' => 'Teknik',
                                    'computer' => 'Komputer',
                                    'other' => 'Lainnya'
                                ]"
                                value="{{ request('type') }}" />
                        </div>

                        {{-- Status Filter --}}
                        <div>
                            <x-select
                                name="status"
                                placeholder="Semua Status"
                                :options="[
                                    'active' => 'Aktif',
                                    'maintenance' => 'Maintenance',
                                    'closed' => 'Tutup'
                                ]"
                                value="{{ request('status') }}" />
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <x-button type="submit" variant="primary">
                            <i class="fa fa-filter mr-2"></i> Filter
                        </x-button>
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('laboratories.index') }}'">
                            Reset
                        </x-button>
                    </div>
                </form>
            </x-card>

            {{-- Laboratories Grid --}}
            @if($laboratories->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($laboratories as $lab)
                        <x-card class="hover:shadow-lg transition-shadow duration-200">
                            {{-- Lab Photo --}}
                            <div class="mb-4 -mx-6 -mt-6">
                                <img
                                    src="{{ $lab->photo_url }}"
                                    alt="{{ $lab->name }}"
                                    class="w-full h-48 object-cover rounded-t-lg"
                                />
                            </div>

                            {{-- Lab Info --}}
                            <div class="space-y-3">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">
                                            {{ $lab->name }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $lab->code }}
                                        </p>
                                    </div>
                                    <x-badge :variant="$lab->status_badge" dot="true">
                                        {{ $lab->status_label }}
                                    </x-badge>
                                </div>

                                <x-badge variant="primary" size="sm">
                                    <i class="fa fa-flask mr-1"></i> {{ $lab->type_label }}
                                </x-badge>

                                @if($lab->location)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fa fa-map-marker-alt mr-2 text-gray-400"></i>
                                        {{ $lab->location }}
                                    </div>
                                @endif

                                @if($lab->headUser)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fa fa-user mr-2 text-gray-400"></i>
                                        {{ $lab->headUser->full_name }}
                                    </div>
                                @endif

                                @if($lab->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                        {{ $lab->description }}
                                    </p>
                                @endif

                                {{-- Action Buttons --}}
                                <div class="flex gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <x-button
                                        variant="ghost"
                                        size="sm"
                                        onclick="window.location.href='{{ route('laboratories.show', $lab) }}'"
                                        title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </x-button>
                                    <x-button
                                        variant="ghost"
                                        size="sm"
                                        onclick="window.location.href='{{ route('laboratories.edit', $lab) }}'"
                                        title="Edit Laboratorium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </x-button>
                                    <form action="{{ route('laboratories.destroy', $lab) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus laboratorium ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="danger" size="sm" title="Hapus Laboratorium">
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
                <div class="mt-6">
                    {{ $laboratories->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <x-card class="text-center py-12">
                    <div class="max-w-md mx-auto">
                        <i class="fa fa-flask text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            Belum Ada Laboratorium
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">
                            Mulai dengan menambahkan laboratorium pertama Anda.
                        </p>
                        <x-button variant="primary" onclick="window.location.href='{{ route('laboratories.create') }}'">
                            <i class="fa fa-plus mr-2"></i> Tambah Laboratorium
                        </x-button>
                    </div>
                </x-card>
            @endif

        </div>
    </div>
</x-app-layout>
