<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-button
                    variant="ghost"
                    size="sm"
                    onclick="window.location.href='{{ route('sops.index') }}'"
                    class="mr-4"
                    title="Kembali"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </x-button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail SOP') }}
                </h2>
            </div>
            <div class="flex gap-2">
                @if($sop->document_url)
                    <x-button
                        variant="secondary"
                        onclick="window.open('{{ $sop->document_url }}', '_blank')"
                    >
                        <i class="fa fa-file-pdf mr-2"></i>
                        Lihat PDF
                    </x-button>
                @endif
                @can('edit-sop')
                    <x-button
                        onclick="window.location.href='{{ route('sops.edit', $sop) }}'"
                    >
                        <i class="fa fa-edit mr-2"></i>
                        Edit
                    </x-button>
                @endcan
                @can('delete-sop')
                    <form action="{{ route('sops.destroy', $sop) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus SOP ini?')">
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" variant="danger">
                            <i class="fa fa-trash mr-2"></i>
                            Hapus
                        </x-button>
                    </form>
                @endcan
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
                                {{ $sop->title }}
                            </h1>
                            <p class="text-lg text-gray-600 dark:text-gray-400 mb-4">
                                {{ $sop->code }} | Versi {{ $sop->full_version }}
                            </p>
                        </div>
                        <x-badge :variant="$sop->status_badge" size="lg" dot="true">
                            {{ $sop->status_label }}
                        </x-badge>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <x-badge variant="primary">
                            <i class="fa fa-folder mr-1"></i> {{ $sop->category_label }}
                        </x-badge>
                        @if($sop->laboratory)
                            <x-badge variant="info">
                                <i class="fa fa-building mr-1"></i> {{ $sop->laboratory->name }}
                            </x-badge>
                        @endif
                        @if($sop->is_effective)
                            <x-badge variant="success">
                                <i class="fa fa-check-circle mr-1"></i> Efektif
                            </x-badge>
                        @endif
                    </div>

                    @if($sop->effective_date)
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Tanggal Efektif</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $sop->effective_date->format('d M Y') }}
                                    </p>
                                </div>
                                @if($sop->next_review_date)
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Review Berikutnya</span>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $sop->next_review_date->format('d M Y') }}
                                            @if($sop->is_review_overdue)
                                                <x-badge variant="danger" size="sm" class="ml-2">Terlambat</x-badge>
                                            @elseif($sop->days_until_review !== null && $sop->days_until_review <= 30)
                                                <x-badge variant="warning" size="sm" class="ml-2">Segera</x-badge>
                                            @endif
                                        </p>
                                    </div>
                                @endif
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Interval Review</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $sop->review_interval_months }} bulan
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </x-card>

            {{-- Content Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Column --}}
                <div class="space-y-6">
                    @if($sop->purpose)
                        <x-card title="Tujuan (Purpose)">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $sop->purpose }}</p>
                        </x-card>
                    @endif

                    @if($sop->scope)
                        <x-card title="Ruang Lingkup (Scope)">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $sop->scope }}</p>
                        </x-card>
                    @endif

                    @if($sop->requirements)
                        <x-card title="Persyaratan (Requirements)">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $sop->requirements }}</p>
                        </x-card>
                    @endif
                </div>

                {{-- Right Column --}}
                <div class="space-y-6">
                    @if($sop->description)
                        <x-card title="Deskripsi Prosedur">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $sop->description }}</p>
                        </x-card>
                    @endif

                    @if($sop->safety_precautions)
                        <x-card title="Tindakan Pencegahan Keselamatan">
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class="fa fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 mt-1 mr-3"></i>
                                    <p class="text-yellow-800 dark:text-yellow-200 text-sm whitespace-pre-line">{{ $sop->safety_precautions }}</p>
                                </div>
                            </div>
                        </x-card>
                    @endif

                    @if($sop->references)
                        <x-card title="Referensi">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $sop->references }}</p>
                        </x-card>
                    @endif
                </div>
            </div>

            {{-- Approval Workflow --}}
            <x-card title="Persetujuan & Review">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if($sop->preparer)
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3">
                                    <i class="fa fa-user text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Disiapkan Oleh</h4>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $sop->preparer->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($sop->reviewer)
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mr-3">
                                    <i class="fa fa-search text-yellow-600 dark:text-yellow-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Direview Oleh</h4>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $sop->reviewer->name }}</p>
                                    @if($sop->review_date)
                                        <p class="text-xs text-gray-500">{{ $sop->review_date->format('d M Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($sop->approver)
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-3">
                                    <i class="fa fa-check-circle text-green-600 dark:text-green-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Disetujui Oleh</h4>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $sop->approver->name }}</p>
                                    @if($sop->approval_date)
                                        <p class="text-xs text-gray-500">{{ $sop->approval_date->format('d M Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if($sop->revision_notes)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Catatan Revisi</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $sop->revision_notes }}</p>
                    </div>
                @endif
            </x-card>

        </div>
    </div>
</x-app-layout>
