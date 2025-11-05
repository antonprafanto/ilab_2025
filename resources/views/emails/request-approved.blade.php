@extends('emails.email-layout')

@section('content')
<h2>✅ Permohonan Layanan Disetujui Direktur - Menunggu Penugasan Lab</h2>

<p>Yth. <strong>Bapak/Ibu Wakil Direktur Pelayanan,</strong></p>

<p>Berikut permohonan layanan yang telah disetujui oleh Direktur dan memerlukan penugasan ke laboratorium:</p>

<div class="info-box">
    <table>
        <tr>
            <td><strong>Nomor Permohonan</strong></td>
            <td><span class="status-badge status-approved">{{ $serviceRequest->request_number }}</span></td>
        </tr>
        <tr>
            <td><strong>Pemohon</strong></td>
            <td>{{ $serviceRequest->user->name }}</td>
        </tr>
        @if($serviceRequest->user->institution)
        <tr>
            <td><strong>Institusi</strong></td>
            <td>{{ $serviceRequest->user->institution }}</td>
        </tr>
        @endif
        <tr>
            <td><strong>Layanan</strong></td>
            <td>{{ $serviceRequest->service->name }}</td>
        </tr>
        <tr>
            <td><strong>Laboratorium Default</strong></td>
            <td>{{ $serviceRequest->service->laboratory->name }}</td>
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
            <td><strong>Tanggal Persetujuan</strong></td>
            <td>{{ $serviceRequest->approved_at->format('d/m/Y H:i') }}</td>
        </tr>
        @if($serviceRequest->estimated_completion_date)
        <tr>
            <td><strong>Target Selesai</strong></td>
            <td>{{ $serviceRequest->estimated_completion_date->format('d/m/Y') }}</td>
        </tr>
        @endif
    </table>
</div>

<h3>⏰ SLA PENUGASAN</h3>

<div class="info-box" style="border-left-color: #e74c3c; background: #fdf2f2;">
    <p style="margin: 0; color: #e74c3c; font-weight: bold;">
        ⚠️ <strong>Batas Waktu: 1 Hari Kerja</strong><br>
        <small>Permohonan ini harus ditugaskan sebelum {{ now()->addDay()->format('d/m/Y H:i') }} WITA</small>
    </p>
</div>

<h3>🔬 Rekomendasi Laboratorium</h3>

<p>Berdasarkan jenis layanan, berikut rekomendasi laboratorium yang sesuai:</p>

<div class="info-box">
    <strong>Laboratorium yang Direkomendasikan:</strong><br>
    🏷️ <strong>{{ $serviceRequest->service->laboratory->name }}</strong><br>
    <small>Fasilitas dan expertise yang tersedia sesuai dengan permohonan layanan ini.</small>
</div>

<h3>📄 Informasi Tambahan</h3>

@if($serviceRequest->description)
<p><strong>Deskripsi Layanan:</strong></p>
<p>{{ $serviceRequest->description }}</p>
@endif

@if($serviceRequest->research_objective)
<p><strong>Tujuan Penelitian:</strong></p>
<p>{{ $serviceRequest->research_objective }}</p>
@endif

@if($serviceRequest->special_requirements)
<p><strong>Persyaratan Khusus:</strong></p>
<p>{{ $serviceRequest->special_requirements }}</p>
@endif

<h3>🎯 Aksi yang Diperlukan</h3>

<p>Mohon lakukan penugasan laboratorium dan analis untuk permohonan ini:</p>

<p><a href="{{ route('service-requests.show', $serviceRequest->id) }}" class="button">🔬 Tugaskan ke Laboratorium</a></p>

<p>Atau kunjungi dashboard approval queue di <a href="{{ route('service-requests.pending-approval') }}">sistem iLab UNMUL</a>.</p>

<h3>📋 Pertimbangan Penugasan</h3>

<p>Faktor yang perlu dipertimbangkan dalam penugasan:</p>
<ul>
    <li>✅ Ketersediaan peralatan yang dibutuhkan</li>
    <li>✅ Kapasitas dan workload analis</li>
    <li>✅ Jenis dan kompleksitas sampel</li>
    <li>✅ Urgency dan deadline permohonan</li>
    <li>✅ Expertise spesifik laboratorium</li>
</ul>

<h3>📞 Kontak</h3>

<p>Jika ada pertanyaan atau memerlukan informasi tambahan:</p>
<ul>
    <li>📧 Email: <a href="mailto:ilab@unmul.ac.id">ilab@unmul.ac.id</a></li>
    <li>📞 Telepon: +62 541-7491234</li>
</ul>

<p>Terima kasih atas perhatian dan koordinasi Bapak/Ibu.</p>

<p> Hormat kami,<br>
<strong>Tim iLab UNMUL</strong><br>
<em>Universitas Mulawarman</em></p>
@endsection