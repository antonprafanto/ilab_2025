<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Permohonan Layanan - Langkah 1: Pilih Layanan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Progress Indicator --}}
            <x-card>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex items-center text-blue-600 relative">
                                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-blue-600 text-white font-bold">1</div>
                                <div class="text-xs font-semibold absolute top-12 -left-4 w-20 text-center">Pilih Layanan</div>
                            </div>
                            <div class="flex-auto border-t-2 border-gray-300"></div>
                            <div class="flex items-center text-gray-400 relative">
                                <div class="rounded-full h-10 w-10 flex items-center justify-center bg-gray-300 text-white font-bold">2</div>
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
                    <input type="hidden" name="step" value="1">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Layanan <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($services as $service)
                                @php
                                    $isSelected = old('service_id', $draft['service_id'] ?? null) == $service->id;
                                @endphp
                                <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ $isSelected ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' : 'border-gray-200 dark:border-gray-600' }}">
                                    <input type="radio" name="service_id" value="{{ $service->id }}" class="mt-1" {{ $isSelected ? 'checked' : '' }} required onchange="this.form.querySelector('[name=service_id]').forEach(r => r.closest('label').classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900')); this.closest('label').classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900');">
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-bold text-gray-900 dark:text-gray-100">{{ $service->name }}</h4>
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
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">{{ $service->code }}</p>
                                        @if($service->description)
                                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">{{ Str::limit($service->description, 150) }}</p>
                                        @endif
                                        <div class="flex items-center gap-4 text-sm">
                                            <span class="text-gray-800 dark:text-gray-200 font-semibold">
                                                <i class="fas fa-flask mr-1 text-blue-600 dark:text-blue-400"></i>{{ $service->laboratory->name }}
                                            </span>
                                            <span class="text-gray-800 dark:text-gray-200 font-semibold">
                                                <i class="fas fa-clock mr-1 text-green-600 dark:text-green-400"></i>{{ $service->duration_days }} hari
                                            </span>
                                            <span class="font-bold text-blue-700 dark:text-blue-400">
                                                Rp {{ number_format($service->price_internal, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('service_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Permohonan <span class="text-red-500">*</span></label>
                        <x-input type="text" name="title" id="title" placeholder="Contoh: Analisis Kadar Protein Susu Sapi Lokal" value="{{ old('title', $draft['title'] ?? '') }}" required />
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi Singkat</label>
                        <textarea name="description" id="description" rows="4" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Jelaskan secara singkat tujuan pengujian...">{{ old('description', $draft['description'] ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="is_urgent" id="is_urgent" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ old('is_urgent', $draft['is_urgent'] ?? false) ? 'checked' : '' }} onchange="document.getElementById('urgency_reason_div').classList.toggle('hidden', !this.checked);">
                            </div>
                            <div class="ml-3">
                                <label for="is_urgent" class="font-medium text-gray-700 dark:text-gray-300">Permohonan Mendesak</label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Centang jika permohonan ini memerlukan prioritas tinggi (waktu pengerjaan dikurangi 30%)</p>
                            </div>
                        </div>

                        <div id="urgency_reason_div" class="mt-4 {{ old('is_urgent', $draft['is_urgent'] ?? false) ? '' : 'hidden' }}">
                            <label for="urgency_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alasan Mendesak <span class="text-red-500">*</span></label>
                            <textarea name="urgency_reason" id="urgency_reason" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Jelaskan mengapa permohonan ini mendesak...">{{ old('urgency_reason', $draft['urgency_reason'] ?? '') }}</textarea>
                            @error('urgency_reason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('service-requests.index') }}'">
                            <i class="fas fa-times mr-2"></i>Batal
                        </x-button>
                        <x-button type="submit" variant="primary">
                            Lanjut ke Langkah 2<i class="fas fa-arrow-right ml-2"></i>
                        </x-button>
                    </div>
                </form>
            </x-card>

        </div>
    </div>
</x-app-layout>
