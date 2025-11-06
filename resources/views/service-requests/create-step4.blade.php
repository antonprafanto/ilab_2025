<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Permohonan Layanan - Langkah 4: Review & Submit') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Progress Indicator --}}
            <x-card>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex items-center text-green-600 relative">
                                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-green-600 text-white font-bold">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="text-xs font-semibold absolute top-12 -left-4 w-20 text-center">Pilih Layanan</div>
                            </div>
                            <div class="flex-auto border-t-2 border-green-600"></div>
                            <div class="flex items-center text-green-600 relative">
                                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-green-600 text-white font-bold">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="text-xs font-semibold absolute top-12 -left-4 w-20 text-center">Info Sampel</div>
                            </div>
                            <div class="flex-auto border-t-2 border-green-600"></div>
                            <div class="flex items-center text-green-600 relative">
                                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-green-600 text-white font-bold">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="text-xs font-semibold absolute top-12 -left-4 w-20 text-center">Info Riset</div>
                            </div>
                            <div class="flex-auto border-t-2 border-green-600"></div>
                            <div class="flex items-center text-blue-600 relative">
                                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-blue-600 text-white font-bold">4</div>
                                <div class="text-xs font-semibold absolute top-12 -left-4 w-20 text-center">Review</div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Review Summary --}}
            <x-card>
                <div class="flex items-center gap-3 mb-6">
                    <i class="fas fa-clipboard-check text-blue-600 dark:text-blue-400 text-2xl"></i>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Review Permohonan Anda</h3>
                </div>

                {{-- Service Info --}}
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-600">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Informasi Layanan</h4>
                    <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                                    <i class="fas fa-flask text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h5 class="font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $service->name }}</h5>
                                <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">{{ $service->code }}</p>
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="text-gray-800 dark:text-gray-200 font-semibold">
                                        <i class="fas fa-flask mr-1 text-blue-600 dark:text-blue-400"></i>{{ $service->laboratory?->name ?? '-' }}
                                    </span>
                                    <span class="text-gray-800 dark:text-gray-200 font-semibold">
                                        <i class="fas fa-clock mr-1 text-green-600 dark:text-green-400"></i>{{ $service->duration_days }} hari
                                    </span>
                                    <span class="font-bold text-blue-700 dark:text-blue-400">
                                        Rp {{ number_format($service->price_internal, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Basic Info --}}
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-600">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Informasi Dasar</h4>
                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Judul Permohonan</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $draft['title'] }}</dd>
                        </div>
                        @if(!empty($draft['description']))
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $draft['description'] }}</dd>
                            </div>
                        @endif
                        @if(!empty($draft['is_urgent']))
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Prioritas</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-600 text-white">
                                        <i class="fas fa-bolt mr-1"></i>MENDESAK
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alasan Mendesak</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $draft['urgency_reason'] }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Sample Info --}}
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-600">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Informasi Sampel</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Sampel</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $draft['sample_count'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Sampel</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $draft['sample_type'] }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi Sampel</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $draft['sample_description'] }}</dd>
                        </div>
                        @if(!empty($draft['sample_preparation']))
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Preparasi Sampel</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $draft['sample_preparation'] }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Research Info --}}
                @if(!empty($draft['research_title']) || !empty($draft['institution']))
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Informasi Penelitian</h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if(!empty($draft['research_title']))
                                <div class="md:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Judul Penelitian</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $draft['research_title'] }}</dd>
                                </div>
                            @endif
                            @if(!empty($draft['research_objective']))
                                <div class="md:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tujuan Penelitian</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $draft['research_objective'] }}</dd>
                                </div>
                            @endif
                            @if(!empty($draft['institution']))
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Institusi</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $draft['institution'] }}</dd>
                                </div>
                            @endif
                            @if(!empty($draft['department']))
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jurusan/Prodi</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $draft['department'] }}</dd>
                                </div>
                            @endif
                            @if(!empty($draft['supervisor_name']))
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pembimbing</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $draft['supervisor_name'] }}</dd>
                                </div>
                            @endif
                            @if(!empty($draft['supervisor_contact']))
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kontak Pembimbing</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $draft['supervisor_contact'] }}</dd>
                                </div>
                            @endif
                            @if(!empty($draft['preferred_date']))
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Diharapkan</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($draft['preferred_date'])->format('d M Y') }}</dd>
                                </div>
                            @endif
                            @if(!empty($draft['proposal_file']))
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dokumen Proposal</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        <i class="fas fa-file-pdf text-red-600 mr-1"></i>Terlampir
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                @endif

                <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-4">
                    <div class="flex gap-3">
                        <i class="fas fa-info-circle text-green-600 dark:text-green-400 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Informasi Estimasi</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Estimasi waktu penyelesaian: <span class="font-bold">{{ $service->duration_days }} hari kerja</span>
                                @if(!empty($draft['is_urgent']))
                                    (dikurangi 30% karena mendesak: <span class="font-bold">~{{ ceil($service->duration_days * 0.7) }} hari kerja</span>)
                                @endif
                            </p>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                Estimasi biaya: <span class="font-bold">Rp {{ number_format($service->price_internal, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Submit Form --}}
            <x-card class="bg-blue-50 dark:bg-blue-900 border-blue-200 dark:border-blue-700">
                <form method="POST" action="{{ route('service-requests.store') }}">
                    @csrf
                    <input type="hidden" name="step" value="4">

                    <div class="flex items-start mb-4">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="confirm" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                        </div>
                        <div class="ml-3">
                            <label for="confirm" class="font-medium text-gray-900 dark:text-gray-100">Konfirmasi Pengajuan</label>
                            <p class="text-sm text-gray-700 dark:text-gray-300">Saya menyatakan bahwa data yang saya berikan adalah benar dan saya bertanggung jawab atas permohonan ini.</p>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4 border-t border-blue-200 dark:border-blue-700">
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('service-requests.create', ['step' => 3]) }}'">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </x-button>
                        <x-button type="submit" variant="primary">
                            <i class="fas fa-paper-plane mr-2"></i>Ajukan Permohonan
                        </x-button>
                    </div>
                </form>
            </x-card>

        </div>
    </div>
</x-app-layout>
