<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Permohonan') }}: {{ $serviceRequest->request_number }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Error Messages --}}
            @if($errors->any())
                <x-alert type="error" dismissible="true">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </x-alert>
            @endif

            {{-- Form --}}
            <x-card>
                <form method="POST" action="{{ route('service-requests.update', $serviceRequest) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Service Selection --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Layanan <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($services as $service)
                                <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition {{ old('service_id', $serviceRequest->service_id) == $service->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                    <input type="radio" name="service_id" value="{{ $service->id }}" class="mt-1" {{ old('service_id', $serviceRequest->service_id) == $service->id ? 'checked' : '' }} required>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-bold text-gray-900">{{ $service->name }}</h4>
                                            @php
                                                $categoryColors = [
                                                    'kimia' => 'bg-blue-600 text-white',
                                                    'biologi' => 'bg-green-600 text-white',
                                                    'fisika' => 'bg-purple-600 text-white',
                                                    'mikrobiologi' => 'bg-pink-600 text-white',
                                                    'material' => 'bg-gray-700 text-white',
                                                    'lingkungan' => 'bg-teal-600 text-white',
                                                    'pangan' => 'bg-orange-600 text-white',
                                                    'farmasi' => 'bg-red-600 text-white',
                                                ];
                                                $categoryBadge = $categoryColors[$service->category] ?? 'bg-gray-700 text-white';
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold {{ $categoryBadge }}">
                                                {{ $service->category_label }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600 mb-2">{{ $service->code }}</p>
                                        <div class="flex items-center gap-4 text-sm">
                                            <span class="text-gray-800 font-semibold">
                                                <i class="fas fa-flask mr-1 text-blue-600"></i>{{ $service->laboratory?->name ?? '-' }}
                                            </span>
                                            <span class="text-gray-800 font-semibold">
                                                <i class="fas fa-clock mr-1 text-green-600"></i>{{ $service->duration_days }} hari
                                            </span>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Basic Info --}}
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Informasi Dasar</h4>

                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Permohonan <span class="text-red-500">*</span></label>
                                <x-input type="text" name="title" id="title" value="{{ old('title', $serviceRequest->title) }}" required />
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                                <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $serviceRequest->description) }}</textarea>
                            </div>

                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="is_urgent" id="is_urgent" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ old('is_urgent', $serviceRequest->is_urgent) ? 'checked' : '' }} onchange="document.getElementById('urgency_reason_div').classList.toggle('hidden', !this.checked);">
                                </div>
                                <div class="ml-3">
                                    <label for="is_urgent" class="font-medium text-gray-700">Permohonan Mendesak</label>
                                    <p class="text-sm text-gray-500">Waktu pengerjaan dikurangi 30%</p>
                                </div>
                            </div>

                            <div id="urgency_reason_div" class="{{ old('is_urgent', $serviceRequest->is_urgent) ? '' : 'hidden' }}">
                                <label for="urgency_reason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Mendesak <span class="text-red-500">*</span></label>
                                <textarea name="urgency_reason" id="urgency_reason" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('urgency_reason', $serviceRequest->urgency_reason) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Sample Info --}}
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Informasi Sampel</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="sample_count" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Sampel <span class="text-red-500">*</span></label>
                                <x-input type="number" name="sample_count" id="sample_count" value="{{ old('sample_count', $serviceRequest->sample_count) }}" min="1" required />
                            </div>

                            <div>
                                <label for="sample_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Sampel <span class="text-red-500">*</span></label>
                                <x-input type="text" name="sample_type" id="sample_type" value="{{ old('sample_type', $serviceRequest->sample_type) }}" required />
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="sample_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Sampel <span class="text-red-500">*</span></label>
                            <textarea name="sample_description" id="sample_description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('sample_description', $serviceRequest->sample_description) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="sample_preparation" class="block text-sm font-medium text-gray-700 mb-2">Preparasi Sampel</label>
                            <textarea name="sample_preparation" id="sample_preparation" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('sample_preparation', $serviceRequest->sample_preparation) }}</textarea>
                        </div>
                    </div>

                    {{-- Research Info --}}
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Informasi Penelitian (Opsional)</h4>

                        <div class="space-y-4">
                            <div>
                                <label for="research_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Penelitian</label>
                                <x-input type="text" name="research_title" id="research_title" value="{{ old('research_title', $serviceRequest->research_title) }}" />
                            </div>

                            <div>
                                <label for="research_objective" class="block text-sm font-medium text-gray-700 mb-2">Tujuan Penelitian</label>
                                <textarea name="research_objective" id="research_objective" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('research_objective', $serviceRequest->research_objective) }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">Institusi</label>
                                    <x-input type="text" name="institution" id="institution" value="{{ old('institution', $serviceRequest->institution) }}" />
                                </div>

                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Jurusan/Prodi</label>
                                    <x-input type="text" name="department" id="department" value="{{ old('department', $serviceRequest->department) }}" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="supervisor_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pembimbing</label>
                                    <x-input type="text" name="supervisor_name" id="supervisor_name" value="{{ old('supervisor_name', $serviceRequest->supervisor_name) }}" />
                                </div>

                                <div>
                                    <label for="supervisor_contact" class="block text-sm font-medium text-gray-700 mb-2">Kontak Pembimbing</label>
                                    <x-input type="text" name="supervisor_contact" id="supervisor_contact" value="{{ old('supervisor_contact', $serviceRequest->supervisor_contact) }}" />
                                </div>
                            </div>

                            <div>
                                <label for="preferred_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengujian Diharapkan</label>
                                <x-input type="date" name="preferred_date" id="preferred_date" value="{{ old('preferred_date', $serviceRequest->preferred_date?->format('Y-m-d')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" />
                            </div>

                            <div>
                                <label for="proposal_file" class="block text-sm font-medium text-gray-700 mb-2">Upload Proposal/Dokumen Pendukung</label>
                                @if($serviceRequest->proposal_file)
                                    <p class="text-sm text-gray-600 mb-2">
                                        <i class="fas fa-file-pdf text-red-600 mr-1"></i>File saat ini:
                                        <a href="{{ $serviceRequest->proposal_file_url }}" target="_blank" class="text-blue-600 hover:underline">Lihat file</a>
                                    </p>
                                @endif
                                <input type="file" name="proposal_file" id="proposal_file" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                <p class="mt-1 text-xs text-gray-500">Format: PDF, DOC, DOCX. Maksimal 5MB. Biarkan kosong jika tidak ingin mengubah.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('service-requests.show', $serviceRequest) }}'">
                            <i class="fas fa-times mr-2"></i>Batal
                        </x-button>
                        <x-button type="submit" variant="primary">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </x-button>
                    </div>
                </form>
            </x-card>

        </div>
    </div>
</x-app-layout>
