<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Katalog Layanan Laboratorium') }}
            </h2>
            <a href="{{ route('services.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Tambah Layanan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
            @endif
            @if($errors->any())
                <x-alert type="error" dismissible="true">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </x-alert>
            @endif

            {{-- Filters --}}
            <x-card>
                <form method="GET" action="{{ route('services.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-2">
                            <x-input name="search" placeholder="Cari nama, kode, deskripsi..." value="{{ request('search') }}" icon="fa fa-search" iconPosition="left" />
                        </div>
                        <div>
                            <x-select name="category" placeholder="Kategori" :options="$categories" value="{{ request('category') }}" />
                        </div>
                        <div>
                            <x-select name="laboratory_id" placeholder="Lab" :options="$laboratories->pluck('name', 'id')->toArray()" value="{{ request('laboratory_id') }}" />
                        </div>
                        <div>
                            <x-select name="duration" placeholder="Durasi" :options="['short'=>'Cepat','medium'=>'Sedang','long'=>'Lama']" value="{{ request('duration') }}" />
                        </div>
                        <div>
                            <x-select name="sort" placeholder="Urutkan" :options="['created_at'=>'Terbaru','popularity'=>'Terpopuler','price'=>'Harga','name'=>'Nama']" value="{{ request('sort','created_at') }}" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input type="number" name="min_price" placeholder="Harga Min (Rp)" value="{{ request('min_price') }}" />
                        <x-input type="number" name="max_price" placeholder="Harga Max (Rp)" value="{{ request('max_price') }}" />
                    </div>
                    <div class="flex gap-2">
                        <x-button type="submit" variant="primary"><i class="fas fa-filter mr-2"></i>Filter</x-button>
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('services.index') }}'">Reset</x-button>
                    </div>
                </form>
            </x-card>

            {{-- Services List --}}
            @if($services->isEmpty())
                <x-card class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Layanan</h3>
                    <p class="text-gray-600 mb-4">Tidak ada layanan yang sesuai dengan filter Anda.</p>
                    <x-button href="{{ route('services.index') }}" variant="ghost">Reset Filter</x-button>
                </x-card>
            @else
                <div class="space-y-4">
                    @foreach($services as $service)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow p-6">
                            <div class="flex items-start gap-4">
                                {{-- Left: Icon --}}
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-sm">
                                        <i class="fas fa-flask text-xl"></i>
                                    </div>
                                </div>

                                {{-- Middle: Info --}}
                                <div class="flex-1 min-w-0">
                                    {{-- Top: Badge & Popularity --}}
                                    <div class="flex items-center gap-3 mb-2">
                                        @php
                                            // Badge dengan warna yang JELAS TERLIHAT
                                            $badgeStyles = [
                                                'kimia' => 'bg-blue-600 text-white',
                                                'biologi' => 'bg-green-600 text-white',
                                                'fisika' => 'bg-purple-600 text-white',
                                                'mikrobiologi' => 'bg-pink-600 text-white',
                                                'material' => 'bg-gray-700 text-white',
                                                'lingkungan' => 'bg-teal-600 text-white',
                                                'pangan' => 'bg-orange-600 text-white',
                                                'farmasi' => 'bg-red-600 text-white',
                                            ];
                                            $badgeClass = $badgeStyles[$service->category] ?? 'bg-gray-700 text-white';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                            {{ $service->category_label }}
                                        </span>
                                        <span class="text-xs text-gray-700 font-semibold">
                                            <i class="fas fa-eye mr-1"></i>{{ $service->popularity }} views
                                        </span>
                                    </div>

                                    {{-- Name --}}
                                    <h3 class="text-lg font-bold text-gray-900 mb-1 hover:text-blue-600 cursor-pointer transition-colors" onclick="window.location.href='{{ route('services.show', $service) }}'">
                                        {{ $service->name }}
                                    </h3>

                                    {{-- Code --}}
                                    <p class="text-xs font-bold text-gray-700 mb-3">{{ $service->code }}</p>

                                    {{-- Info Row --}}
                                    <div class="flex items-center gap-5 text-sm mb-3">
                                        <span class="text-gray-800 font-semibold">
                                            <i class="fas fa-flask mr-1.5 text-blue-600"></i>{{ $service->laboratory?->name ?? '-' }}
                                        </span>
                                        <span class="text-gray-800 font-semibold">
                                            <i class="fas fa-clock mr-1.5 text-green-600"></i>{{ $service->duration_days }} hari
                                        </span>
                                        <span class="font-bold text-blue-700 text-base">
                                            Rp {{ number_format($service->price_internal, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    {{-- Description --}}
                                    @if($service->description)
                                        <p class="text-sm text-gray-800 line-clamp-1 mb-3">{{ $service->description }}</p>
                                    @endif

                                    {{-- Actions --}}
                                    <div class="flex gap-2 pt-3 border-t border-gray-200">
                                        <x-button href="{{ route('services.show', $service) }}" variant="primary" size="sm">
                                            <i class="fas fa-info-circle mr-1"></i>Detail
                                        </x-button>
                                        <x-button href="{{ route('services.edit', $service) }}" variant="warning" size="sm">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </x-button>
                                        <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus layanan ini?');">
                                            @csrf @method('DELETE')
                                            <x-button type="submit" variant="danger" size="sm">
                                                <i class="fas fa-trash mr-1"></i>Hapus
                                            </x-button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <x-card>{{ $services->links() }}</x-card>
            @endif

        </div>
    </div>
</x-app-layout>
