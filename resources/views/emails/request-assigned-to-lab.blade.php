@extends('emails.email-layout')

@section('content')
<h2>🔬 Permohonan Layanan Ditugaskan ke Laboratorium Anda</h2>

<p>Yth. <strong>Bapak/Ibu Kepala Laboratorium,</strong></p>

<p>Telah ada permohonan layanan baru yang ditugaskan ke laboratorium Anda oleh Wakil Direktur Pelayanan:</p>

<div class="info-box">
    <table>
        <tr>
            <td><strong>Nomor Permohonan</strong></td>
            <td><span class="status-badge status-assigned">{{ $serviceRequest->request_number }}</span></td>
        </tr>
        <tr>
            <td><strong>Pemohon</strong></td>
            <td>{{ $serviceRequest->user?->name ?? '-' }}</td>
        </tr>
        @if($serviceRequest->user->institution)
        <tr>
            <td><strong>Institusi</strong></td>
            <td>{{ $serviceRequest->user->institution }}</td>
        </tr>
        @endif
        <tr>
            <td><strong>Layanan</strong></td>
            <td>{{ $serviceRequest->service?->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Laboratorium</strong></td>
            <td>{{ $serviceRequest->assignedLaboratory?->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Judul Penelitian</strong></td>
            <td>{{ $serviceRequest->research_title ?: '-' }}</td>
        </tr>
        <tr>
            <td><strong>Jumlah Sampel</strong></td>
            <td>{{ $serviceRequest->sample_count }} {{ $serviceRequest->sample_type }}</td>
        </tr>
        <tr>
            <td><strong>Prioritas</strong></td>
            <td>
                @if($serviceRequest->priority === 'urgent')
                    <span style="color: #e74c3c; font-weight: bold;">🔴 URGENT</span>
                @else
                    <span style="color: #27ae60;">{{ strtoupper($serviceRequest->priority) }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Tanggal Penugasan</strong></td>
            <td>{{ $serviceRequest->lab_assigned_at ? $serviceRequest->lab_assigned_at->format('d/m/Y H:i') : '-' }}</td>
        </tr>
        @if($serviceRequest->estimated_completion_date)
        <tr>
            <td><strong>Target Selesai</strong></td>
            <td>{{ $serviceRequest->estimated_completion_date ? $serviceRequest->estimated_completion_date->format('d/m/Y') : '-' }}</td>
        </tr>
        @endif
    </table>
</div>

<h3>⏰ SLA PENUGASAN ANALIS</h3>

<div class="info-box" style="border-left-color: #e74c3c; background: #fdf2f2;">
    <p style="margin: 0; color: #e74c3c; font-weight: bold;">
        ⚠️ <strong>Batas Waktu: 1 Hari Kerja</strong><br>
        <small>Permohonan ini harus ditugaskan ke analis sebelum {{ now()->addDay()->format('d/m/Y H:i') }} WITA</small>
    </p>
</div>

<h3>👥 Suggesti Analis yang Tersedia</h3>

<p>Berdasarkan workload dan expertise saat ini, berikut suggesti analis yang tersedia di laboratorium Anda:</p>

@php
    // Count current active assignments per analyst
    $currentAssignments = collect();
    if ($serviceRequest->assignedLaboratory?->id) {
        $currentAssignments = App\Models\User::role('Anggota Lab/Unit')
            ->whereHas('laboratories', function($q) use ($serviceRequest) {
                $q->where('laboratories.id', $serviceRequest->assignedLaboratory->id);
            })
            ->withCount(['serviceRequestsAsAnalyst' => function($q) {
                $q->whereIn('status', ['assigned', 'in_progress', 'testing']);
            }])
            ->orderBy('service_requests_as_analyst_count')
            ->limit(3)
            ->get();
    }
@endphp

@if($currentAssignments->count() > 0)
<div class="info-box">
    @foreach($currentAssignments as $analyst)
    <div style="margin-bottom: 10px; padding: 10px; background: #f8f9fa; border-radius: 5px;">
        <strong>👤 {{ $analyst->name }}</strong><br>
        <small>📋 Workload saat ini: {{ $analyst->service_requests_as_analyst_count }} permohonan aktif</small><br>
        <small>📧 Email: {{ $analyst->email }}</small>
    </div>
    @endforeach
</div>
@else
<div class="info-box" style="border-left-color: #f39c12; background: #fef9e7;">
    <p style="margin: 0; color: #f39c12;">
        ⚠️ <strong>Tidak ada analis yang tersedia saat ini</strong><br>
        <small>Silakan tambahkan analis baru atau alokasikan ulang workload.</small>
    </p>
</div>
@endif

<h3>📄 Detail Permohonan</h3>

@if($serviceRequest->description)
<p><strong>Deskripsi Layanan:</strong></p>
<p>{{ $serviceRequest->description }}</p>
@endif

@if($serviceRequest->research_objective)
<p><strong>Tujuan Penelitian:</strong></p>
<p>{{ $serviceRequest->research_objective }}</p>
@endif

@if($serviceRequest->sample_description)
<p><strong>Deskripsi Sampel:</strong></p>
<p>{{ $serviceRequest->sample_description }}</p>
@endif

@if($serviceRequest->special_requirements)
<p><strong>Persyaratan Khusus:</strong></p>
<p>{{ $serviceRequest->special_requirements }}</p>
@endif

<h3>🔧 Peralatan yang Dibutuhkan</h3>

@if($serviceRequest->service->equipment_needed && count($serviceRequest->service->equipment_needed) > 0)
    @php
        $equipment = \App\Models\Equipment::whereIn('id', $serviceRequest->service->equipment_needed)->get();
    @endphp
    <ul>
        @foreach($equipment as $eq)
        <li>🔧 <strong>{{ $eq->name }}</strong> - Status:
            @if($eq->status === 'available')
                <span style="color: #27ae60;">✅ Tersedia</span>
            @else
                <span style="color: #e74c3c;">❌ {{ strtoupper($eq->status) }}</span>
            @endif
        </li>
        @endforeach
    </ul>
@else
<p>📋 Tidak ada peralatan khusus yang dibutuhkan untuk layanan ini.</p>
@endif

<h3>🎯 Aksi yang Diperlukan</h3>

<p>Mohon segera tugaskan analis yang sesuai untuk permohonan ini:</p>

<p><a href="{{ route('service-requests.show', $serviceRequest->id) }}" class="button">👤 Tugaskan Analis</a></p>

<p>Atau kunjungi dashboard approval queue di <a href="{{ route('service-requests.pending-approval') }}">sistem iLab UNMUL</a>.</p>

<h3>📋 Checklist Sebelum Penugasan</h3>

<p>Pastikan hal-hal berikut sebelum menugaskan analis:</p>
<ul>
    <li>✅ Ketersediaan peralatan yang dibutuhkan</li>
    <li>✅ Kapasitas dan workload analis yang dipilih</li>
    <li>✅ Kesesuaian expertise analis dengan jenis analisis</li>
    <li>✅ Deadline dan prioritas permohonan</li>
    <li>✅ Ketersediaan bahan dan reagen yang diperlukan</li>
</ul>

<h3>📞 Kontak</h3>

<p>Jika ada pertanyaan atau memerlukan informasi tambahan:</p>
<ul>
    <li>📧 Email: <a href="mailto:ilab@unmul.ac.id">ilab@unmul.ac.id</a></li>
    <li>📞 Telepon: +62 541-7491234</li>
</ul>

<p>Terima kasih atas koordinasi dan kerja samanya.</p>

<p> Hormat kami,<br>
<strong>Tim iLab UNMUL</strong><br>
<em>Universitas Mulawarman</em></p>
@endsection