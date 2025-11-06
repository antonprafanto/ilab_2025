@extends('emails.email-layout')

@section('content')
@if($recipient === 'user')
    <!-- Email untuk Pemohon/User -->
    <h2>✅ Permohonan Layanan Telah Ditugaskan ke Analis</h2>

    <p>Yth. <strong>{{ $serviceRequest->user?->name ?? 'Pemohon' }}</strong>,</p>

    <p>Kami dengan senang hati menginformasikan bahwa permohonan layanan Anda telah ditugaskan ke analis yang kompeten. Berikut detail penugasannya:</p>

    <div class="info-box">
        <table>
            <tr>
                <td><strong>Nomor Permohonan</strong></td>
                <td><span class="status-badge status-assigned">{{ $serviceRequest->request_number }}</span></td>
            </tr>
            <tr>
                <td><strong>Layanan</strong></td>
                <td>{{ $serviceRequest->service?->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Laboratorium</strong></td>
                <td>{{ $serviceRequest->assignedLaboratory?->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Analis yang Ditugaskan</strong></td>
                <td>{{ $serviceRequest->assignedAnalyst?->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Email Analis</strong></td>
                <td>{{ $serviceRequest->assignedAnalyst?->email ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td><span class="status-badge status-assigned">Siap Proses</span></td>
            </tr>
            <tr>
                <td><strong>Perkiraan Mulai</strong></td>
                <td>{{ $serviceRequest->assigned_at ? $serviceRequest->assigned_at->format('d/m/Y') : '-' }}</td>
            </tr>
            @if($serviceRequest->estimated_completion_date)
            <tr>
                <td><strong>Target Selesai</strong></td>
                <td>{{ $serviceRequest->estimated_completion_date->format('d/m/Y') }}</td>
            </tr>
            @endif
        </table>
    </div>

    <h3>📋 Langkah Selanjutnya</h3>

    <p>Proses selanjutnya adalah sebagai berikut:</p>

    <ol>
        <li><strong>Persiapkan Sampel</strong> - Pastikan sampel sesuai dengan spesifikasi yang diajukan</li>
        <li><strong>Kirim Sampel</strong> - Koordinasikan pengiriman sampel ke laboratorium</li>
        <li><strong>Proses Analisis</strong> - Analis akan memproses sampel sesuai metode yang ditetapkan</li>
        <li><strong>Laporan Hasil</strong> - Anda akan menerima laporan hasil analisis</li>
    </ol>

    <h3>📞 Kontak Analis</h3>

    <p>Untuk koordinasi teknis terkait sampel dan proses analisis, Anda dapat menghubungi:</p>
    <div class="info-box">
        <strong>👤 {{ $serviceRequest->assignedAnalyst?->name ?? 'Analis' }}</strong><br>
        📧 Email: <a href="mailto:{{ $serviceRequest->assignedAnalyst?->email ?? 'ilab@unmul.ac.id' }}">{{ $serviceRequest->assignedAnalyst?->email ?? 'ilab@unmul.ac.id' }}</a><br>
        🏢 Laboratorium: {{ $serviceRequest->assignedLaboratory?->name ?? 'iLab UNMUL' }}<br>
        📞 Telepon Laboratorium: +62 541-7491234
    </div>

    <h3>🔍 Lacak Progress</h3>

    <p>Anda dapat memantau progress permohonan secara real-time melalui:</p>

    <p><a href="{{ route('service-requests.show', $serviceRequest->id) }}" class="button">📊 Lihat Detail Permohonan</a></p>

@else
    <!-- Email untuk Analis -->
    <h2>🔬 Penugasan Permohonan Layanan Baru</h2>

    <p>Yth. <strong>{{ $serviceRequest->assignedAnalyst?->name ?? 'Analis' }}</strong>,</p>

    <p>Anda telah ditugaskan untuk menangani permohonan layanan baru. Berikut detail penugasannya:</p>

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
            @if($serviceRequest->user?->institution)
            <tr>
                <td><strong>Institusi</strong></td>
                <td>{{ $serviceRequest->user->institution }}</td>
            </tr>
            @endif
            @if($serviceRequest->user?->phone)
            <tr>
                <td><strong>Telepon Pemohon</strong></td>
                <td>{{ $serviceRequest->user->phone }}</td>
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
                <td>{{ $serviceRequest->assigned_at ? $serviceRequest->assigned_at->format('d/m/Y H:i') : '-' }}</td>
            </tr>
            @if($serviceRequest->estimated_completion_date)
            <tr>
                <td><strong>Target Selesai</strong></td>
                <td>{{ $serviceRequest->estimated_completion_date->format('d/m/Y') }}</td>
            </tr>
            @endif
        </table>
    </div>

    <h3>📄 Informasi Teknis</h3>

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
            <li>🔧 <strong>{{ $eq->name }}</strong> - Lokasi: {{ $eq->location_detail ?? $eq->laboratory?->name ?? 'Laboratorium' }}</li>
            @endforeach
        </ul>
    @else
        <p>📋 Tidak ada peralatan khusus yang dibutuhkan.</p>
    @endif

    <h3>🎯 Aksi yang Diperlukan</h3>

    <p>Mohon segera review detail permohonan dan persiapkan proses analisis:</p>

    <p><a href="{{ route('service-requests.show', $serviceRequest->id) }}" class="button">🔬 Lihat Detail & Mulai Proses</a></p>

    <h3>📋 Checklist Proses</h3>

    <p>Sebelum memulai proses analisis, pastikan:</p>
    <ul>
        <li>☐ Review semua informasi permohonan</li>
        <li>☐ Persiapkan peralatan yang dibutuhkan</li>
        <li>☐ Siapkan reagen dan bahan consumable</li>
        <li>☐ Koordinasi dengan pemohon untuk pengiriman sampel</li>
        <li>☐ Update status permohonan saat mulai proses</li>
    </ul>

    <h3>📞 Kontak Pemohon</h3>

    <p>Untuk koordinasi terkait sampel dan persyaratan teknis:</p>
    <div class="info-box">
        <strong>👤 {{ $serviceRequest->user?->name ?? 'Pemohon' }}</strong><br>
        📧 Email: <a href="mailto:{{ $serviceRequest->user?->email ?? 'ilab@unmul.ac.id' }}">{{ $serviceRequest->user?->email ?? 'ilab@unmul.ac.id' }}</a><br>
        @if($serviceRequest->user?->phone)
        📞 Telepon: {{ $serviceRequest->user->phone }}<br>
        @endif
        @if($serviceRequest->user?->institution)
        🏢 Institusi: {{ $serviceRequest->user->institution }}
        @endif
    </div>

@endif

<h3>📊 Lacak Progress</h3>

<p>Anda dapat memantau progress permohonan secara real-time melalui sistem iLab UNMUL:</p>

<p><a href="{{ route('service-requests.show', $serviceRequest->id) }}" class="button">📋 Lihat Detail Permohonan</a></p>

<p>Atau kunjungi dashboard Anda di <a href="{{ route('dashboard') }}">sistem iLab UNMUL</a>.</p>

<h3>📞 Bantuan & Support</h3>

<p>Jika ada pertanyaan atau memerlukan bantuan teknis:</p>
<ul>
    <li>📧 Email: <a href="mailto:ilab@unmul.ac.id">ilab@unmul.ac.id</a></li>
    <li>📞 Telepon: +62 541-7491234</li>
    <li>🏢 Laboratorium: {{ $serviceRequest->assignedLaboratory?->name ?? 'iLab UNMUL' }}</li>
</ul>

<p>Terima kasih atas kerja samanya.</p>

<p> Hormat kami,<br>
<strong>Tim iLab UNMUL</strong><br>
<em>Universitas Mulawarman</em></p>
@endsection