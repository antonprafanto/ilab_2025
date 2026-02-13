<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Dokumen Publik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.public-documents.update', $publicDocument) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">{{ __('Judul Dokumen') }}</label>
                            <input id="title" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="title" value="{{ old('title', $publicDocument->title) }}" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Deskripsi (Opsional)') }}</label>
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description', $publicDocument->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Current File -->
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-700">File Saat Ini:</p>
                            <a href="{{ $publicDocument->download_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-sm flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Lihat File
                            </a>
                        </div>

                        <!-- File Input (Optional) -->
                        <div class="mb-4">
                            <label for="file" class="block font-medium text-sm text-gray-700">{{ __('Ganti File (Biarkan kosong jika tidak ingin mengubah)') }}</label>
                            <input id="file" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="file">
                             <p class="mt-1 text-sm text-gray-500" id="file_size_info">Maksimum ukuran file: 200MB.</p>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Color Theme -->
                            <div class="mb-4">
                                <label for="color" class="block font-medium text-sm text-gray-700">{{ __('Tema Warna') }}</label>
                                <select id="color" name="color" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="blue" {{ old('color', $publicDocument->color) == 'blue' ? 'selected' : '' }}>Biru (Default)</option>
                                    <option value="green" {{ old('color', $publicDocument->color) == 'green' ? 'selected' : '' }}>Hijau</option>
                                    <option value="orange" {{ old('color', $publicDocument->color) == 'orange' ? 'selected' : '' }}>Oranye</option>
                                    <option value="red" {{ old('color', $publicDocument->color) == 'red' ? 'selected' : '' }}>Merah</option>
                                    <option value="purple" {{ old('color', $publicDocument->color) == 'purple' ? 'selected' : '' }}>Ungu</option>
                                    <option value="teal" {{ old('color', $publicDocument->color) == 'teal' ? 'selected' : '' }}>Teal</option>
                                </select>
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>

                            <!-- Icon -->
                            <div class="mb-4">
                                <label for="icon" class="block font-medium text-sm text-gray-700">{{ __('Ikon') }}</label>
                                <select id="icon" name="icon" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="document" {{ old('icon', $publicDocument->icon) == 'document' ? 'selected' : '' }}>Dokumen Umum</option>
                                    <option value="pdf" {{ old('icon', $publicDocument->icon) == 'pdf' ? 'selected' : '' }}>PDF</option>
                                </select>
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>
                        </div>
                        
                        <!-- Sort Order -->
                        <div class="mb-4">
                             <label for="sort_order" class="block font-medium text-sm text-gray-700">{{ __('Urutan Tampil') }}</label>
                             <input id="sort_order" class="block mt-1 w-24 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="number" name="sort_order" value="{{ old('sort_order', $publicDocument->sort_order) }}" />
                             <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin di atas.</p>
                        </div>

                         <!-- Active Status -->
                         <div class="block mt-4 mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_active" value="1" {{ old('is_active', $publicDocument->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Tampilkan Dokumen Ini') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.public-documents.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">{{ __('Batal') }}</a>
                            <x-primary-button class="ml-4">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
