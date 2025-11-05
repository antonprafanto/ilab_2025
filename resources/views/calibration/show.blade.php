<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('calibration.index') }}'" class="mr-4" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </x-button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Detail Calibration Record</h2>
            </div>
            <div class="flex gap-2">
                <x-button onclick="window.location.href='{{ route('calibration.edit', $calibration) }}'">
                    <i class="fa fa-edit mr-2"></i>
                    Edit
                </x-button>
                <form action="{{ route('calibration.destroy', $calibration) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus record ini?')">
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
            <x-card>
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $calibration->calibration_code }}</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ $calibration->equipment->name }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-badge :variant="$calibration->status_badge" size="lg">{{ $calibration->status_label }}</x-badge>
                        @if($calibration->result)
                            <x-badge :variant="$calibration->result_badge" size="sm">{{ $calibration->result_label }}</x-badge>
                        @endif
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700 mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Tipe</span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $calibration->type_label }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Tanggal Kalibrasi</span>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $calibration->calibration_date->format('d M Y') }}</p>
                        </div>
                        @if($calibration->due_date)
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Jatuh Tempo</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $calibration->due_date->format('d M Y') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </x-card>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($calibration->accuracy || $calibration->uncertainty)
                    <x-card title="Spesifikasi">
                        @if($calibration->accuracy)
                            <div class="mb-2"><span class="text-gray-600 dark:text-gray-400">Akurasi:</span> <span class="font-medium">{{ $calibration->accuracy }}</span></div>
                        @endif
                        @if($calibration->uncertainty)
                            <div class="mb-2"><span class="text-gray-600 dark:text-gray-400">Ketidakpastian:</span> <span class="font-medium">{{ $calibration->uncertainty }}</span></div>
                        @endif
                        @if($calibration->range_calibrated)
                            <div><span class="text-gray-600 dark:text-gray-400">Rentang:</span> <span class="font-medium">{{ $calibration->range_calibrated }}</span></div>
                        @endif
                    </x-card>
                @endif

                @if($calibration->certificate_number)
                    <x-card title="Sertifikat">
                        <div class="mb-2"><span class="text-gray-600 dark:text-gray-400">Nomor:</span> <span class="font-medium">{{ $calibration->certificate_number }}</span></div>
                        @if($calibration->external_lab)
                            <div class="mb-2"><span class="text-gray-600 dark:text-gray-400">Lab:</span> <span class="font-medium">{{ $calibration->external_lab }}</span></div>
                        @endif
                        @if($calibration->certificate_file)
                            <x-button variant="info" size="sm" onclick="window.open('{{ $calibration->certificate_url }}', '_blank')">
                                <i class="fa fa-file-pdf mr-1"></i> Lihat Sertifikat
                            </x-button>
                        @endif
                    </x-card>
                @endif
            </div>

            @if($calibration->measurement_results)
                <x-card title="Hasil Pengukuran">
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $calibration->measurement_results }}</p>
                </x-card>
            @endif
        </div>
    </div>
</x-app-layout>
