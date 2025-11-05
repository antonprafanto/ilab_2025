<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('samples.index') }}'" class="mr-4" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </x-button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Detail Sampel</h2>
            </div>
            <div class="flex gap-2">
                <x-button onclick="window.location.href='{{ route('samples.edit', $sample) }}'">
                    <i class="fa fa-edit mr-2"></i>
                    Edit
                </x-button>
                <form action="{{ route('samples.destroy', $sample) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus sampel ini?')">
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
                <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded">{{ session('success') }}</div>
            @endif

            <x-card>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $sample->code }}</h3>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ $sample->name }}</p>
                        <div class="mt-2 flex items-center gap-2">
                            <x-badge :variant="$sample->status_badge">{{ $sample->status_label }}</x-badge>
                            <x-badge :variant="$sample->priority_badge">{{ $sample->priority_label }}</x-badge>
                            <x-badge variant="secondary">{{ $sample->type_label }}</x-badge>
                            @if($sample->is_expired)
                                <x-badge variant="danger">Kadaluarsa</x-badge>
                            @elseif($sample->is_expiring_soon)
                                <x-badge variant="warning">Segera Kadaluarsa</x-badge>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Laboratorium</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $sample->laboratory->name }}</p>
                    </div>
                </div>
            </x-card>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card title="Informasi Sampel">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Sumber</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $sample->source ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $sample->quantity ? $sample->quantity . ' ' . $sample->unit : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi Penyimpanan</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $sample->storage_location ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kondisi Penyimpanan</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $sample->storage_condition_label }}</dd>
                        </div>
                    </dl>
                </x-card>

                <x-card title="Tanggal Penting">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Diterima</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $sample->received_date->format('d M Y') }}</dd>
                        </div>
                        @if($sample->expiry_date)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Kadaluarsa</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $sample->expiry_date->format('d M Y') }}
                                @if($sample->days_until_expiry !== null)
                                    <span class="text-xs text-gray-500">({{ $sample->days_until_expiry >= 0 ? $sample->days_until_expiry . ' hari lagi' : abs($sample->days_until_expiry) . ' hari lalu' }})</span>
                                @endif
                            </dd>
                        </div>
                        @endif
                        @if($sample->analysis_date)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Analisis</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $sample->analysis_date->format('d M Y') }}</dd>
                        </div>
                        @endif
                        @if($sample->result_date)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Hasil</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $sample->result_date->format('d M Y') }}</dd>
                        </div>
                        @endif
                    </dl>
                </x-card>
            </div>

            <x-card title="Personel">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Diserahkan Oleh</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $sample->submitter->name }}</dd>
                    </div>
                    @if($sample->analyzer)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dianalisis Oleh</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $sample->analyzer->name }}</dd>
                    </div>
                    @endif
                </dl>
            </x-card>

            @if($sample->description)
            <x-card title="Deskripsi">
                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $sample->description }}</p>
            </x-card>
            @endif

            @if($sample->test_parameters)
            <x-card title="Parameter yang Diuji">
                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $sample->test_parameters }}</p>
            </x-card>
            @endif

            @if($sample->analysis_results)
            <x-card title="Hasil Analisis">
                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $sample->analysis_results }}</p>
            </x-card>
            @endif

            @if($sample->result_file)
            <x-card title="File Hasil">
                <a href="{{ $sample->result_file_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                    <i class="fa fa-file mr-2"></i>{{ basename($sample->result_file) }}
                </a>
            </x-card>
            @endif

            @if($sample->special_requirements || $sample->notes)
            <x-card title="Catatan">
                @if($sample->special_requirements)
                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Persyaratan Khusus:</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $sample->special_requirements }}</p>
                </div>
                @endif
                @if($sample->notes)
                <div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Catatan:</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $sample->notes }}</p>
                </div>
                @endif
            </x-card>
            @endif
        </div>
    </div>
</x-app-layout>
