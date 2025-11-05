<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Permohonan Layanan - Langkah 3: Informasi Riset') }}
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
                            <div class="flex items-center text-blue-600 relative">
                                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-blue-600 text-white font-bold">3</div>
                                <div class="text-xs font-semibold absolute top-12 -left-4 w-20 text-center">Info Riset</div>
                            </div>
                            <div class="flex-auto border-t-2 border-gray-300"></div>
                            <div class="flex items-center text-gray-400 relative">
                                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-gray-300 text-white font-bold">4</div>
                                <div class="text-xs font-semibold absolute top-12 -left-4 w-20 text-center">Review</div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Service Info --}}
            <x-card class="bg-blue-50 dark:bg-blue-900 border-blue-200 dark:border-blue-700">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                            <i class="fas fa-flask text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-gray-100">{{ $service->name }}</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $service->laboratory->name }} • {{ $draft['sample_count'] ?? '1' }} sampel</p>
                    </div>
                </div>
            </x-card>

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
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"></i>
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">Informasi Penelitian (Opsional)</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Bagian ini bersifat opsional. Isi jika permohonan ini terkait dengan penelitian atau tugas akhir.</p>
                </div>

                <form method="POST" action="{{ route('service-requests.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="step" value="3">

                    <div>
                        <label for="research_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Penelitian</label>
                        <x-input type="text" name="research_title" id="research_title" placeholder="Contoh: Analisis Kandungan Protein pada Susu Sapi Lokal..." value="{{ old('research_title', $draft['research_title'] ?? '') }}" />
                        @error('research_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="research_objective" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tujuan Penelitian</label>
                        <textarea name="research_objective" id="research_objective" rows="4" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Jelaskan tujuan penelitian Anda...">{{ old('research_objective', $draft['research_objective'] ?? '') }}</textarea>
                        @error('research_objective')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="institution" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Institusi</label>
                            <x-input type="text" name="institution" id="institution" placeholder="Contoh: Universitas Mulawarman" value="{{ old('institution', $draft['institution'] ?? '') }}" />
                            @error('institution')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jurusan/Program Studi</label>
                            <x-input type="text" name="department" id="department" placeholder="Contoh: Teknik Kimia" value="{{ old('department', $draft['department'] ?? '') }}" />
                            @error('department')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="supervisor_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Pembimbing</label>
                            <x-input type="text" name="supervisor_name" id="supervisor_name" placeholder="Contoh: Dr. Budi Santoso, M.T." value="{{ old('supervisor_name', $draft['supervisor_name'] ?? '') }}" />
                            @error('supervisor_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="supervisor_contact" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kontak Pembimbing</label>
                            <x-input type="text" name="supervisor_contact" id="supervisor_contact" placeholder="Email atau No. HP" value="{{ old('supervisor_contact', $draft['supervisor_contact'] ?? '') }}" />
                            @error('supervisor_contact')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Jadwal & Dokumen</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="preferred_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Pengujian Diharapkan</label>
                                <x-input type="date" name="preferred_date" id="preferred_date" value="{{ old('preferred_date', $draft['preferred_date'] ?? '') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tanggal minimal H+1</p>
                                @error('preferred_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="proposal_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Proposal/Dokumen Pendukung</label>
                            <input type="file" name="proposal_file" id="proposal_file" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-800" />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: PDF, DOC, DOCX. Maksimal 5MB</p>
                            @error('proposal_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('service-requests.create', ['step' => 2]) }}'">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </x-button>
                        <x-button type="submit" variant="primary">
                            Lanjut ke Review<i class="fas fa-arrow-right ml-2"></i>
                        </x-button>
                    </div>
                </form>
            </x-card>

        </div>
    </div>
</x-app-layout>
