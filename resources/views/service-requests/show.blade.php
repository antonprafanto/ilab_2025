<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Detail Permohonan') }}: {{ $serviceRequest->request_number }}
            </h2>
            <div class="flex gap-2">
                @if($serviceRequest->canBeEdited() && $serviceRequest->user_id === Auth::id())
                    <a href="{{ route('service-requests.edit', $serviceRequest) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                @endif
                <a href="{{ route('service-requests.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content (Left) --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Header Info --}}
                    <x-card>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-lg {{ $serviceRequest->is_urgent ? 'bg-gradient-to-br from-red-500 to-red-600' : 'bg-gradient-to-br from-blue-500 to-blue-600' }} flex items-center justify-center text-white shadow-sm">
                                    <i class="fas {{ $serviceRequest->is_urgent ? 'fa-bolt' : 'fa-file-alt' }} text-2xl"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    @php
                                        $statusColors = [
                                            'warning' => 'bg-yellow-600 text-white',
                                            'info' => 'bg-blue-600 text-white',
                                            'success' => 'bg-green-600 text-white',
                                            'primary' => 'bg-indigo-600 text-white',
                                            'danger' => 'bg-red-600 text-white',
                                            'secondary' => 'bg-gray-600 text-white',
                                        ];
                                        $statusBadge = $statusColors[$serviceRequest->status_badge] ?? 'bg-gray-600 text-white';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $statusBadge }}">
                                        {{ $serviceRequest->status_label }}
                                    </span>
                                    @if($serviceRequest->is_urgent)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-600 text-white">
                                            <i class="fas fa-bolt mr-1"></i>MENDESAK
                                        </span>
                                    @endif
                                    @if($serviceRequest->is_overdue)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-600 text-white">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>TERLAMBAT
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $serviceRequest->title }}</h3>
                                <div class="flex items-center gap-5 text-sm text-gray-600 dark:text-gray-400">
                                    <span><i class="fas fa-calendar mr-1"></i>{{ $serviceRequest->submitted_at ? $serviceRequest->submitted_at->format('d M Y H:i') : '-' }}</span>
                                    <span><i class="fas fa-eye mr-1"></i>{{ $serviceRequest->view_count }} views</span>
                                </div>
                            </div>
                        </div>

                        @if($serviceRequest->description)
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <p class="text-gray-700 dark:text-gray-300">{{ $serviceRequest->description }}</p>
                            </div>
                        @endif

                        @if($serviceRequest->urgency_reason)
                            <div class="mt-4 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg">
                                <h4 class="font-semibold text-red-900 dark:text-red-100 mb-1"><i class="fas fa-bolt mr-1"></i>Alasan Mendesak</h4>
                                <p class="text-sm text-red-800 dark:text-red-200">{{ $serviceRequest->urgency_reason }}</p>
                            </div>
                        @endif
                    </x-card>

                    {{-- Service Info --}}
                    <x-card>
                        <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4"><i class="fas fa-flask mr-2 text-blue-600 dark:text-blue-400"></i>Informasi Layanan</h4>
                        <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                                        <i class="fas fa-flask text-xl"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $serviceRequest->service?->name ?? '-' }}</h5>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">{{ $serviceRequest->service?->code ?? '-' }}</p>
                                    <div class="flex items-center gap-4 text-sm">
                                        <span class="text-gray-800 dark:text-gray-200 font-semibold">
                                            <i class="fas fa-building mr-1 text-blue-600 dark:text-blue-400"></i>{{ $serviceRequest->service?->laboratory?->name ?? '-' }}
                                        </span>
                                        <span class="text-gray-800 dark:text-gray-200 font-semibold">
                                            <i class="fas fa-clock mr-1 text-green-600 dark:text-green-400"></i>{{ $serviceRequest->service?->duration_days ?? '-' }} hari
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-card>

                    {{-- Sample Info --}}
                    <x-card>
                        <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4"><i class="fas fa-vial mr-2 text-green-600 dark:text-green-400"></i>Informasi Sampel</h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Sampel</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $serviceRequest->sample_count }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Sampel</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $serviceRequest->sample_type }}</dd>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi Sampel</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $serviceRequest->sample_description }}</dd>
                            </div>
                            @if($serviceRequest->sample_preparation)
                                <div class="md:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Preparasi Sampel</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $serviceRequest->sample_preparation }}</dd>
                                </div>
                            @endif
                        </dl>
                    </x-card>

                    {{-- Research Info --}}
                    @if($serviceRequest->research_title || $serviceRequest->institution)
                        <x-card>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4"><i class="fas fa-graduation-cap mr-2 text-purple-600 dark:text-purple-400"></i>Informasi Penelitian</h4>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($serviceRequest->research_title)
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Judul Penelitian</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $serviceRequest->research_title }}</dd>
                                    </div>
                                @endif
                                @if($serviceRequest->research_objective)
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tujuan Penelitian</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $serviceRequest->research_objective }}</dd>
                                    </div>
                                @endif
                                @if($serviceRequest->institution)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Institusi</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $serviceRequest->institution }}</dd>
                                    </div>
                                @endif
                                @if($serviceRequest->department)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jurusan/Prodi</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $serviceRequest->department }}</dd>
                                    </div>
                                @endif
                                @if($serviceRequest->supervisor_name)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pembimbing</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $serviceRequest->supervisor_name }}</dd>
                                    </div>
                                @endif
                                @if($serviceRequest->supervisor_contact)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kontak Pembimbing</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $serviceRequest->supervisor_contact }}</dd>
                                    </div>
                                @endif
                                @if($serviceRequest->proposal_file)
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dokumen Proposal</dt>
                                        <dd class="mt-1">
                                            <a href="{{ $serviceRequest->proposal_file_url }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                                <i class="fas fa-file-pdf text-red-600 mr-2"></i>Download Proposal
                                            </a>
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </x-card>
                    @endif

                    {{-- Timeline --}}
                    <x-card>
                        <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4"><i class="fas fa-history mr-2 text-gray-600 dark:text-gray-400"></i>Timeline Permohonan</h4>
                        <div class="space-y-4">
                            @foreach($timelineEvents as $event)
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-800 flex items-center justify-center text-blue-600 dark:text-blue-300">
                                            <i class="fas {{ $event['icon'] }}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-900 dark:text-gray-100">{{ $event['title'] }}</h5>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $event['description'] }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ isset($event['date']) ? \Carbon\Carbon::parse($event['date'])->format('d M Y H:i') : '-' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-card>

                    {{-- Internal Notes (Staff Only) --}}
                    @if(Auth::user()->hasRole(['Super Admin', 'Direktur', 'Wakil Direktur', 'Kepala Lab', 'Anggota Lab', 'Sub Bagian TU & Keuangan']))
                    <x-card>
                        <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4">
                            <i class="fas fa-sticky-note mr-2 text-yellow-600 dark:text-yellow-400"></i>
                            Catatan Internal <span class="text-xs font-normal text-gray-500">(Hanya Staff)</span>
                        </h4>

                        {{-- Display existing notes --}}
                        @php
                            $notes = $serviceRequest->getInternalNotesArray();
                        @endphp

                        @if(count($notes) > 0)
                            <div class="space-y-3 mb-4">
                                @foreach($notes as $note)
                                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-3">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-full bg-yellow-600 flex items-center justify-center text-white text-xs font-bold">
                                                    {{ substr($note['user_name'], 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ $note['user_name'] }}</span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                                                        {{ \Carbon\Carbon::parse($note['created_at'])->format('d M Y H:i') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 pl-10">{{ $note['note'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500 dark:text-gray-400 mb-4">
                                <i class="fas fa-sticky-note text-3xl mb-2"></i>
                                <p class="text-sm">Belum ada catatan internal</p>
                            </div>
                        @endif

                        {{-- Add new note form --}}
                        <form action="{{ route('service-requests.add-note', $serviceRequest) }}" method="POST" class="border-t border-gray-200 dark:border-gray-600 pt-4">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-plus-circle mr-1"></i>Tambah Catatan Baru
                                </label>
                                <textarea
                                    name="note"
                                    rows="3"
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md focus:ring-yellow-500 focus:border-yellow-500"
                                    placeholder="Tulis catatan internal di sini... (koordinasi, kendala, update status, dll)"
                                    required
                                ></textarea>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-info-circle"></i> Catatan ini hanya terlihat oleh staff dan tidak terlihat oleh pemohon
                                </p>
                            </div>
                            <div class="flex justify-end">
                                <x-button type="submit" variant="primary">
                                    <i class="fas fa-save mr-2"></i>Simpan Catatan
                                </x-button>
                            </div>
                        </form>
                    </x-card>
                    @endif
                </div>

                {{-- Sidebar (Right) --}}
                <div class="space-y-6">
                    {{-- Quick Info --}}
                    <x-card>
                        <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4">Informasi Cepat</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Pemohon</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $serviceRequest->user?->name ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Email Pemohon</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $serviceRequest->user?->email ?? '-' }}</dd>
                            </div>
                            @if($serviceRequest->assignedTo)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Ditugaskan ke</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $serviceRequest->assignedTo?->name ?? '-' }}</dd>
                                </div>
                            @endif
                            @if($serviceRequest->estimated_completion_date)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Estimasi Selesai</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $serviceRequest->estimated_completion_date ? $serviceRequest->estimated_completion_date->format('d M Y') : '-' }}</dd>
                                </div>
                            @endif
                            @if($serviceRequest->preferred_date)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal Diharapkan</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $serviceRequest->preferred_date ? $serviceRequest->preferred_date->format('d M Y') : '-' }}</dd>
                                </div>
                            @endif
                        </dl>
                    </x-card>

                    {{-- SLA Status (Staff Only) --}}
                    @if(Auth::user()->hasRole(['Super Admin', 'Direktur', 'Wakil Direktur', 'Kepala Lab', 'Anggota Lab', 'Sub Bagian TU & Keuangan']))
                        @php
                            $slaStatus = $serviceRequest->getCurrentSLAStatus();
                        @endphp
                        @if($slaStatus)
                            <x-card>
                                <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4">
                                    <i class="fas fa-clock mr-2 text-blue-600 dark:text-blue-400"></i>
                                    SLA Monitor
                                </h4>
                                @php
                                    $bgColors = [
                                        'green' => 'bg-green-100 dark:bg-green-900/30 border-green-300 dark:border-green-700',
                                        'yellow' => 'bg-yellow-100 dark:bg-yellow-900/30 border-yellow-300 dark:border-yellow-700',
                                        'red' => 'bg-red-100 dark:bg-red-900/30 border-red-300 dark:border-red-700',
                                    ];
                                    $textColors = [
                                        'green' => 'text-green-800 dark:text-green-200',
                                        'yellow' => 'text-yellow-800 dark:text-yellow-200',
                                        'red' => 'text-red-800 dark:text-red-200',
                                    ];
                                    $iconColors = [
                                        'green' => 'text-green-600 dark:text-green-400',
                                        'yellow' => 'text-yellow-600 dark:text-yellow-400',
                                        'red' => 'text-red-600 dark:text-red-400',
                                    ];
                                    $icons = [
                                        'green' => 'fa-check-circle',
                                        'yellow' => 'fa-exclamation-triangle',
                                        'red' => 'fa-times-circle',
                                    ];
                                    $color = $slaStatus['color'] ?? 'gray';
                                @endphp
                                <div class="border-2 {{ $bgColors[$color] ?? 'bg-gray-100' }} rounded-lg p-4">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fas {{ $icons[$color] ?? 'fa-circle' }} text-2xl {{ $iconColors[$color] ?? 'text-gray-600' }}"></i>
                                        <div>
                                            <div class="text-xs font-medium {{ $textColors[$color] ?? 'text-gray-700' }} uppercase">Status SLA</div>
                                            <div class="text-lg font-bold {{ $textColors[$color] ?? 'text-gray-900' }}">{{ $slaStatus['status'] }}</div>
                                        </div>
                                    </div>
                                    <p class="text-sm {{ $textColors[$color] ?? 'text-gray-700' }} mb-3">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        {{ $slaStatus['message'] }}
                                    </p>
                                    <div class="text-xs {{ $textColors[$color] ?? 'text-gray-600' }} bg-white/50 dark:bg-gray-800/50 rounded px-2 py-1">
                                        <i class="fas fa-flag-checkered mr-1"></i>
                                        Target: 24 jam untuk setiap tahap
                                    </div>
                                </div>

                                {{-- Progress stages --}}
                                <div class="mt-4 space-y-2">
                                    <div class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-list-check mr-1"></i> Progress Tahapan:
                                    </div>
                                    @php
                                        $stages = [
                                            ['name' => 'Verifikasi', 'status' => $serviceRequest->status, 'target' => ['pending'], 'completed' => in_array($serviceRequest->status, ['verified', 'approved', 'assigned', 'in_progress', 'testing', 'completed'])],
                                            ['name' => 'Persetujuan', 'status' => $serviceRequest->status, 'target' => ['verified'], 'completed' => in_array($serviceRequest->status, ['approved', 'assigned', 'in_progress', 'testing', 'completed'])],
                                            ['name' => 'Penugasan', 'status' => $serviceRequest->status, 'target' => ['approved'], 'completed' => in_array($serviceRequest->status, ['assigned', 'in_progress', 'testing', 'completed'])],
                                        ];
                                    @endphp
                                    @foreach($stages as $stage)
                                        <div class="flex items-center gap-2 text-xs">
                                            @if($stage['completed'])
                                                <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                                                <span class="text-gray-900 dark:text-gray-100">{{ $stage['name'] }}</span>
                                                <span class="text-green-600 dark:text-green-400 font-medium">Selesai</span>
                                            @elseif(in_array($serviceRequest->status, $stage['target']))
                                                <i class="fas fa-spinner fa-spin text-blue-600 dark:text-blue-400"></i>
                                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $stage['name'] }}</span>
                                                <span class="text-blue-600 dark:text-blue-400">Sedang Proses</span>
                                            @else
                                                <i class="fas fa-circle text-gray-400"></i>
                                                <span class="text-gray-500 dark:text-gray-400">{{ $stage['name'] }}</span>
                                                <span class="text-gray-400">Menunggu</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </x-card>
                        @endif
                    @endif

                    {{-- Workflow Actions (Admin/Lab) --}}
                    @if(Auth::user()->hasRole(['Super Admin', 'Wakil Direktur Pelayanan', 'Wakil Direktur PM & TI', 'Kepala Lab', 'Anggota Lab', 'Sub Bagian TU & Keuangan']))
                        <x-card>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4">Aksi</h4>
                            <div class="space-y-2">
                                @if($serviceRequest->status === 'pending')
                                    <form action="{{ route('service-requests.verify', $serviceRequest) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" variant="success" class="w-full">
                                            <i class="fas fa-check mr-2"></i>Verifikasi
                                        </x-button>
                                    </form>
                                @endif

                                @if($serviceRequest->status === 'verified')
                                    <form action="{{ route('service-requests.approve', $serviceRequest) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" variant="success" class="w-full">
                                            <i class="fas fa-thumbs-up mr-2"></i>Setujui
                                        </x-button>
                                    </form>
                                @endif

                                @if($serviceRequest->status === 'approved')
                                    <form action="{{ route('service-requests.assign', $serviceRequest) }}" method="POST" class="space-y-2">
                                        @csrf
                                        <select name="assigned_to" class="w-full border-gray-300 rounded-md" required>
                                            <option value="">Pilih Kepala Lab...</option>
                                            {{-- TODO: Load Kepala Lab users --}}
                                        </select>
                                        <x-button type="submit" variant="primary" class="w-full">
                                            <i class="fas fa-user-check mr-2"></i>Tugaskan
                                        </x-button>
                                    </form>
                                @endif

                                @if(in_array($serviceRequest->status, ['assigned', 'approved']))
                                    <form action="{{ route('service-requests.start-progress', $serviceRequest) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" variant="primary" class="w-full">
                                            <i class="fas fa-play mr-2"></i>Mulai Dikerjakan
                                        </x-button>
                                    </form>
                                @endif

                                @if($serviceRequest->status === 'in_progress')
                                    <form action="{{ route('service-requests.start-testing', $serviceRequest) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" variant="primary" class="w-full">
                                            <i class="fas fa-flask mr-2"></i>Mulai Analisis
                                        </x-button>
                                    </form>
                                @endif

                                @if(in_array($serviceRequest->status, ['testing', 'in_progress']))
                                    <form action="{{ route('service-requests.complete', $serviceRequest) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" variant="success" class="w-full">
                                            <i class="fas fa-check-double mr-2"></i>Selesaikan
                                        </x-button>
                                    </form>
                                @endif

                                @if(!in_array($serviceRequest->status, ['completed', 'rejected', 'cancelled']))
                                    <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                        <i class="fas fa-times mr-2"></i>Tolak
                                    </button>
                                @endif
                            </div>
                        </x-card>
                    @endif

                    {{-- User Actions --}}
                    @if($serviceRequest->user_id === Auth::id() && $serviceRequest->canBeCancelled())
                        <x-card>
                            <form action="{{ route('service-requests.destroy', $serviceRequest) }}" method="POST" onsubmit="return confirm('Yakin membatalkan permohonan ini?');">
                                @csrf @method('DELETE')
                                <x-button type="submit" variant="danger" class="w-full">
                                    <i class="fas fa-times mr-2"></i>Batalkan Permohonan
                                </x-button>
                            </form>
                        </x-card>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800 dark:border-gray-600">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Tolak Permohonan</h3>
            <form action="{{ route('service-requests.reject', $serviceRequest) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alasan Penolakan</label>
                    <textarea name="rejection_reason" rows="4" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md" required></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Tolak Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Assign to Lab Modal (Wakil Direktur) --}}
    @can('assign-to-lab')
    <div id="assignLabModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800 dark:border-gray-600">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Tugaskan ke Laboratorium</h3>
            <form action="{{ route('service-requests.assign-lab', $serviceRequest) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Laboratorium</label>
                    <select name="laboratory_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md" required>
                        <option value="">-- Pilih Laboratorium --</option>
                        @foreach(\App\Models\Laboratory::where('is_active', true)->get() as $lab)
                            <option value="{{ $lab->id }}" {{ $serviceRequest->service->laboratory_id == $lab->id ? 'selected' : '' }}>
                                {{ $lab->name }}
                                @if($serviceRequest->service->laboratory_id == $lab->id)
                                    (Rekomendasi)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <i class="fas fa-info-circle"></i> Laboratorium yang direkomendasikan dipilih otomatis
                    </p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Penugasan (Opsional)</label>
                    <textarea name="assignment_notes" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('assignLabModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <i class="fas fa-building mr-1"></i> Tugaskan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endcan

    {{-- Assign to Analyst Modal (Kepala Lab) --}}
    @can('assign-to-analyst')
    <div id="assignAnalystModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800 dark:border-gray-600">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Tugaskan ke Analis</h3>
            <form action="{{ route('service-requests.assign', $serviceRequest) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Analis</label>
                    <select name="assigned_to" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md" required>
                        <option value="">-- Pilih Analis --</option>
                        @php
                            $analysts = \App\Models\User::whereHas('roles', function($q) {
                                $q->whereIn('name', ['Anggota Lab', 'Kepala Lab']);
                            })->get();
                        @endphp
                        @foreach($analysts as $analyst)
                            <option value="{{ $analyst->id }}">
                                {{ $analyst->name }}
                                @php
                                    $workload = \App\Models\ServiceRequest::where('assigned_to', $analyst->id)
                                        ->whereIn('status', ['assigned', 'in_progress', 'testing'])
                                        ->count();
                                @endphp
                                ({{ $workload }} tugas aktif)
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <i class="fas fa-info-circle"></i> Jumlah tugas aktif ditampilkan untuk membantu distribusi beban kerja
                    </p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Penugasan (Opsional)</label>
                    <textarea name="assignment_notes" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md" placeholder="Instruksi khusus untuk analis..."></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('assignAnalystModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        <i class="fas fa-user-check mr-1"></i> Tugaskan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endcan
</x-app-layout>
