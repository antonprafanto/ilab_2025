<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permohonan Layanan') }}
            </h2>
            <a href="{{ route('service-requests.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Ajukan Permohonan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
            @endif
            @if(session('error'))
                <x-alert type="error" dismissible="true">{{ session('error') }}</x-alert>
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
                <form method="GET" action="{{ route('service-requests.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <x-input name="search" placeholder="Cari nomor, judul, pemohon..." value="{{ request('search') }}" icon="fa fa-search" iconPosition="left" />
                        </div>
                        <div>
                            <x-select name="status" placeholder="Status" :options="$statuses" value="{{ request('status') }}" />
                        </div>
                        <div>
                            <x-select name="service_id" placeholder="Layanan" :options="$services->pluck('name', 'id')->toArray()" value="{{ request('service_id') }}" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <x-select name="priority" placeholder="Prioritas" :options="['standard'=>'Standar','urgent'=>'Mendesak']" value="{{ request('priority') }}" />
                        </div>
                        <div>
                            <x-input type="date" name="start_date" placeholder="Dari Tanggal" value="{{ request('start_date') }}" />
                        </div>
                        <div>
                            <x-input type="date" name="end_date" placeholder="Sampai Tanggal" value="{{ request('end_date') }}" />
                        </div>
                        <div>
                            <x-select name="sort" placeholder="Urutkan" :options="['created_at'=>'Terbaru','request_number'=>'Nomor','priority'=>'Prioritas']" value="{{ request('sort','created_at') }}" />
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <x-button type="submit" variant="primary"><i class="fas fa-filter mr-2"></i>Filter</x-button>
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('service-requests.index') }}'">Reset</x-button>
                    </div>
                </form>
            </x-card>

            {{-- Requests List --}}
            @if($requests->isEmpty())
                <x-card class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Permohonan</h3>
                    <p class="text-gray-600 mb-4">Belum ada permohonan layanan yang diajukan.</p>
                    <x-button href="{{ route('service-requests.create') }}" variant="primary">
                        <i class="fas fa-plus mr-2"></i>Ajukan Permohonan
                    </x-button>
                </x-card>
            @else
                <div class="space-y-4">
                    @foreach($requests as $request)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow p-6">
                            <div class="flex items-start gap-4">
                                {{-- Left: Icon --}}
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 rounded-lg {{ $request->is_urgent ? 'bg-gradient-to-br from-red-500 to-red-600' : 'bg-gradient-to-br from-blue-500 to-blue-600' }} flex items-center justify-center text-white shadow-sm">
                                        <i class="fas {{ $request->is_urgent ? 'fa-bolt' : 'fa-file-alt' }} text-xl"></i>
                                    </div>
                                </div>

                                {{-- Middle: Info --}}
                                <div class="flex-1 min-w-0">
                                    {{-- Top: Status & Priority --}}
                                    <div class="flex items-center gap-3 mb-2">
                                        @php
                                            $statusColors = [
                                                'warning' => 'bg-yellow-600 text-white',
                                                'info' => 'bg-blue-600 text-white',
                                                'success' => 'bg-green-600 text-white',
                                                'primary' => 'bg-indigo-600 text-white',
                                                'danger' => 'bg-red-600 text-white',
                                                'secondary' => 'bg-gray-600 text-white',
                                            ];
                                            $statusBadge = $statusColors[$request->status_badge] ?? 'bg-gray-600 text-white';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $statusBadge }}">
                                            {{ $request->status_label }}
                                        </span>
                                        @if($request->is_urgent)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-600 text-white">
                                                <i class="fas fa-bolt mr-1"></i>MENDESAK
                                            </span>
                                        @endif
                                        @if($request->is_overdue)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-600 text-white">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>TERLAMBAT
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Request Number & Title --}}
                                    <h3 class="text-lg font-bold text-gray-900 mb-1 hover:text-blue-600 cursor-pointer transition-colors" onclick="window.location.href='{{ route('service-requests.show', $request) }}'">
                                        {{ $request->request_number }}
                                    </h3>
                                    <p class="text-sm font-semibold text-gray-700 mb-3">{{ $request->title }}</p>

                                    {{-- Info Row --}}
                                    <div class="flex items-center gap-5 text-sm mb-3">
                                        <span class="text-gray-800 font-semibold">
                                            <i class="fas fa-user mr-1.5 text-blue-600"></i>{{ $request->user?->name ?? '-' }}
                                        </span>
                                        <span class="text-gray-800 font-semibold">
                                            <i class="fas fa-flask mr-1.5 text-green-600"></i>{{ $request->service?->name ?? '-' }}
                                        </span>
                                        <span class="text-gray-800 font-semibold">
                                            <i class="fas fa-calendar mr-1.5 text-purple-600"></i>{{ $request->submitted_at->format('d M Y') }}
                                        </span>
                                        @if($request->estimated_completion_date)
                                            <span class="text-gray-800 font-semibold">
                                                <i class="fas fa-clock mr-1.5 text-orange-600"></i>Est: {{ $request->estimated_completion_date->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Assigned Info --}}
                                    @if($request->assignedTo)
                                        <p class="text-xs text-gray-600 mb-3">
                                            <i class="fas fa-user-check mr-1"></i>Ditugaskan ke: <span class="font-semibold">{{ $request->assignedTo->name }}</span>
                                        </p>
                                    @endif

                                    {{-- Actions --}}
                                    <div class="flex gap-2 pt-3 border-t border-gray-200">
                                        <x-button href="{{ route('service-requests.show', $request) }}" variant="primary" size="sm">
                                            <i class="fas fa-eye mr-1"></i>Lihat Detail
                                        </x-button>

                                        @if($request->canBeEdited() && $request->user_id === Auth::id())
                                            <x-button href="{{ route('service-requests.edit', $request) }}" variant="warning" size="sm">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </x-button>
                                        @endif

                                        @if($request->canBeCancelled() && $request->user_id === Auth::id())
                                            <form action="{{ route('service-requests.destroy', $request) }}" method="POST" class="inline" onsubmit="return confirm('Yakin membatalkan permohonan ini?');">
                                                @csrf @method('DELETE')
                                                <x-button type="submit" variant="danger" size="sm">
                                                    <i class="fas fa-times mr-1"></i>Batalkan
                                                </x-button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <x-card>{{ $requests->links() }}</x-card>
            @endif

        </div>
    </div>
</x-app-layout>
