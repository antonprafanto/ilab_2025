<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Permohonan Layanan - Langkah 2: Informasi Sampel') }}
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
                            <div class="flex items-center text-blue-600 relative">
                                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-blue-600 text-white font-bold">2</div>
                                <div class="text-xs font-semibold absolute top-12 -left-4 w-20 text-center">Info Sampel</div>
                            </div>
                            <div class="flex-auto border-t-2 border-gray-300"></div>
                            <div class="flex items-center text-gray-400 relative">
                                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-gray-300 text-white font-bold">3</div>
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
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $service->laboratory->name }} • {{ $service->duration_days }} hari kerja</p>
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
                <form method="POST" action="{{ route('service-requests.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="step" value="2">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sample_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah Sampel <span class="text-red-500">*</span></label>
                            <x-input type="number" name="sample_count" id="sample_count" placeholder="1" value="{{ old('sample_count', $draft['sample_count'] ?? '') }}" min="1" required />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Berapa banyak sampel yang akan diuji?</p>
                            @error('sample_count')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sample_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis Sampel <span class="text-red-500">*</span></label>
                            <x-input type="text" name="sample_type" id="sample_type" placeholder="Contoh: Cair, Padat, Gas, Bubuk, dll" value="{{ old('sample_type', $draft['sample_type'] ?? '') }}" required />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Bentuk fisik sampel</p>
                            @error('sample_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="sample_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi Sampel <span class="text-red-500">*</span></label>
                        <textarea name="sample_description" id="sample_description" rows="4" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Jelaskan detail sampel: asal, kondisi, karakteristik khusus, dll..." required>{{ old('sample_description', $draft['sample_description'] ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Semakin detail informasi sampel, semakin mudah proses analisis</p>
                        @error('sample_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sample_preparation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preparasi Sampel yang Sudah Dilakukan</label>
                        <textarea name="sample_preparation" id="sample_preparation" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Jika ada preparasi khusus yang sudah dilakukan, jelaskan di sini...">{{ old('sample_preparation', $draft['sample_preparation'] ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Contoh: sudah dikeringkan, dihaluskan, diencerkan, dll.</p>
                        @error('sample_preparation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
                        <div class="flex gap-3">
                            <i class="fas fa-info-circle text-yellow-600 dark:text-yellow-400 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Catatan Penting</h4>
                                <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1 list-disc list-inside">
                                    <li>Pastikan sampel dalam kondisi baik dan sesuai untuk dianalisis</li>
                                    <li>Sampel akan diterima sesuai jadwal yang telah ditentukan</li>
                                    <li>Hubungi laboratorium untuk informasi penyimpanan khusus</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('service-requests.create', ['step' => 1]) }}'">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </x-button>
                        <x-button type="submit" variant="primary">
                            Lanjut ke Langkah 3<i class="fas fa-arrow-right ml-2"></i>
                        </x-button>
                    </div>
                </form>
            </x-card>

        </div>
    </div>
</x-app-layout>
