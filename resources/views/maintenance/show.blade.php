<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-button
                    variant="ghost"
                    size="sm"
                    onclick="window.location.href='{{ route('maintenance.index') }}'"
                    class="mr-4"
                    title="Kembali"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </x-button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail Maintenance Record') }}
                </h2>
            </div>
            <div class="flex gap-2">
                <x-button
                    onclick="window.location.href='{{ route('maintenance.edit', $maintenance) }}'"
                >
                    <i class="fa fa-edit mr-2"></i>
                    Edit
                </x-button>
                <form action="{{ route('maintenance.destroy', $maintenance) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus record ini?')">
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

            {{-- Header Card --}}
            <x-card>
                <div class="space-y-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $maintenance->maintenance_code }}
                            </h1>
                            <p class="text-lg text-gray-600 dark:text-gray-400 mb-2">
                                {{ $maintenance->equipment->name }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $maintenance->equipment->code }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <x-badge :variant="$maintenance->status_badge" size="lg">
                                {{ $maintenance->status_label }}
                            </x-badge>
                            <x-badge :variant="$maintenance->priority_badge" size="sm">
                                {{ $maintenance->priority_label }}
                            </x-badge>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Tipe</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $maintenance->type_label }}
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Tanggal Dijadwalkan</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $maintenance->scheduled_date->format('d M Y') }}
                                </p>
                            </div>
                            @if($maintenance->completed_date)
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Tanggal Selesai</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $maintenance->completed_date->format('d M Y') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Content Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Column --}}
                <div class="space-y-6">
                    @if($maintenance->description)
                        <x-card title="Deskripsi Pekerjaan">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $maintenance->description }}</p>
                        </x-card>
                    @endif

                    @if($maintenance->work_performed)
                        <x-card title="Pekerjaan yang Dilakukan">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $maintenance->work_performed }}</p>
                        </x-card>
                    @endif

                    @if($maintenance->parts_replaced)
                        <x-card title="Parts yang Diganti">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $maintenance->parts_replaced }}</p>
                        </x-card>
                    @endif
                </div>

                {{-- Right Column --}}
                <div class="space-y-6">
                    @if($maintenance->findings)
                        <x-card title="Temuan">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $maintenance->findings }}</p>
                        </x-card>
                    @endif

                    @if($maintenance->recommendations)
                        <x-card title="Rekomendasi">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $maintenance->recommendations }}</p>
                        </x-card>
                    @endif

                    @if($maintenance->total_cost)
                        <x-card title="Biaya">
                            <div class="space-y-2">
                                @if($maintenance->labor_cost)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Biaya Tenaga Kerja:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">
                                            Rp {{ number_format($maintenance->labor_cost, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif
                                @if($maintenance->parts_cost)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Biaya Parts:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">
                                            Rp {{ number_format($maintenance->parts_cost, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif
                                <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Total:</span>
                                    <span class="font-bold text-gray-900 dark:text-gray-100">
                                        Rp {{ number_format($maintenance->total_cost, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </x-card>
                    @endif
                </div>
            </div>

            {{-- Personnel --}}
            <x-card title="Personel">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($maintenance->technician)
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3">
                                    <i class="fa fa-user text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Teknisi</h4>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $maintenance->technician->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($maintenance->verifier)
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-3">
                                    <i class="fa fa-check-circle text-green-600 dark:text-green-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Verifikator</h4>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $maintenance->verifier->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if($maintenance->next_maintenance_date)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Maintenance Berikutnya</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $maintenance->next_maintenance_date->format('d M Y') }}
                        </p>
                    </div>
                @endif

                @if($maintenance->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Catatan</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $maintenance->notes }}</p>
                    </div>
                @endif
            </x-card>

        </div>
    </div>
</x-app-layout>
