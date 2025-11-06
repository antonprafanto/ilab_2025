@extends('emails.email-layout')

@section('content')
<h2>📋 Permohonan Layanan Memerlukan Persetujuan Anda</h2>

<p>Yth. <strong>Bapak/Ibu Direktur,</strong></p>

<p>Telah diterima permohonan layanan baru yang telah diverifikasi oleh admin dan memerlukan persetujuan Bapak/Ibu:</p>

<div class="info-box">
    <table>
        <tr>
            <td><strong>Nomor Permohonan</strong></td>
            <td><span class="status-badge status-verified">{{ $serviceRequest->request_number }}</span></td>
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
            <td>{{ $serviceRequest->service?->laboratory?->name ?? '-' }}</td>
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
            <td><strong>Tanggal Pengajuan</strong></td>
            <td>{{ $serviceRequest->submitted_at ? $serviceRequest->submitted_at->format('d/m/Y H:i') : '-' }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Verifikasi</strong></td>
            <td>{{ $serviceRequest->verified_at ? $serviceRequest->verified_at->format('d/m/Y H:i') : '-' }}</td>
        </tr>
        @if($serviceRequest->estimated_completion_date)
        <tr>
            <td><strong>Target Selesai</strong></td>
            <td>{{ $serviceRequest->estimated_completion_date ? $serviceRequest->estimated_completion_date->format('d/m/Y') : '-' }}</td>
        </tr>
        @endif
    </table>
</div>

<h3>⏰ SLA PERSYETUJUAN</h3>

<div class="info-box" style="border-left-color: #e74c3c; background: #fdf2f2;">
    <p style="margin: 0; color: #e74c3c; font-weight: bold;">
        ⚠️ <strong>Batas Waktu: 1 Hari Kerja</strong><br>
        <small>Permohonan ini harus disetujui sebelum {{ now()->addDay()->format('d/m/Y H:i') }} WITA</small>
    </p>
</div>

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

<h3>🎯 Aksi yang Diperlukan</h3>

<p> Mohon review dan berikan persetujuan pada permohonan ini:</p>

<p><a href="{{ route('service-requests.show', $serviceRequest->id) }}" class="button">✅ Review & Setujui Permohonan</a></p>

<p>Atau kunjungi dashboard approval queue di <a href="{{ route('service-requests.pending-approval') }}">sistem iLab UNMUL</a>.</p>

<h3>📞 Kontak</h3>

<p>Jika ada pertanyaan atau memerlukan informasi tambahan:</p>
<ul>
    <li>📧 Email: <a href="mailto:ilab@unmul.ac.id">ilab@unmul.ac.id</a></li>
    <li>📞 Telepon: +62 541-7491234</li>
</ul>

<p>Terima kasih atas perhatian dan persetujuan Bapak/Ibu.</p>

<p> Hormat kami,<br>
<strong>Tim iLab UNMUL</strong><br>
<em>Universitas Mulawarman</em></p>
@endsection