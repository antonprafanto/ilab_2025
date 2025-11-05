@extends('emails.email-layout')

@section('content')
<h2>✅ Permohonan Layanan Berhasil Dikirim</h2>

<p>Yth. <strong>{{ $serviceRequest->user->name }}</strong>,</p>

<p>Terima kasih telah mengajukan permohonan layanan ke iLab UNMUL. Permohonan Anda telah kami terima dengan detail sebagai berikut:</p>

<div class="info-box">
    <table>
        <tr>
            <td><strong>Nomor Permohonan</strong></td>
            <td><span class="status-badge status-pending">{{ $serviceRequest->request_number }}</span></td>
        </tr>
        <tr>
            <td><strong>Layanan</strong></td>
            <td>{{ $serviceRequest->service->name }}</td>
        </tr>
        <tr>
            <td><strong>Laboratorium</strong></td>
            <td>{{ $serviceRequest->service->laboratory->name }}</td>
        </tr>
        <tr>
            <td><strong>Jumlah Sampel</strong></td>
            <td>{{ $serviceRequest->sample_count }} {{ $serviceRequest->sample_type }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td><span class="status-badge status-pending">Menunggu Verifikasi</span></td>
        </tr>
        <tr>
            <td><strong>Tanggal Pengajuan</strong></td>
            <td>{{ $serviceRequest->submitted_at->format('d/m/Y H:i') }}</td>
        </tr>
        @if($serviceRequest->estimated_completion_date)
        <tr>
            <td><strong>Perkiraan Selesai</strong></td>
            <td>{{ $serviceRequest->estimated_completion_date->format('d/m/Y') }} ({{ $serviceRequest->working_days }} hari kerja)</td>
        </tr>
        @endif
    </table>
</div>

<h3>📋 Langkah Selanjutnya</h3>

<p>Permohonan Anda akan melalui proses verifikasi dan persetujuan sebagai berikut:</p>

<ol>
    <li><strong>Verifikasi Admin</strong> - Memeriksa kelengkapan dokumen (1 hari kerja)</li>
    <li><strong>Persetujuan Direktur</strong> - Review dan persetujuan teknis (1 hari kerja)</li>
    <li><strong>Penugasan Laboratorium</strong> - Penentuan laboratorium dan analis (1 hari kerja)</li>
    <li><strong>Pelaksanaan Layanan</strong> - Proses analisis sampel</li>
</ol>

<h3>🔍 Lacak Permohonan Anda</h3>

<p>Anda dapat memantau status permohonan secara real-time melalui:</p>

<p><a href="{{ route('service-requests.tracking') }}" class="button">📊 Lacak Status Permohonan</a></p>

<p>Atau kunjungi dashboard Anda di <a href="{{ route('dashboard') }}">sistem iLab UNMUL</a>.</p>

<h3>📞 Kontak & Bantuan</h3>

<p>Jika Anda memiliki pertanyaan atau memerlukan bantuan:</p>

<ul>
    <li>📧 Email: <a href="mailto:ilab@unmul.ac.id">ilab@unmul.ac.id</a></li>
    <li>📞 Telepon: +62 541-7491234</li>
    <li>🏢 Alamat: Laboratorium Terpadu FMIPA, Kampus Gunung Kelua, Samarinda</li>
</ul>

<p><strong>Catatan:</strong> Email notifikasi akan dikirim pada setiap perubahan status permohonan Anda.</p>

<p>Terima kasih atas kepercayaan Anda kepada layanan iLab UNMUL.</p>

<p> Hormat kami,<br>
<strong>Tim iLab UNMUL</strong><br>
<em>Universitas Mulawarman</em></p>
@endsection