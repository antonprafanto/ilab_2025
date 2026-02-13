<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Dokumen Publik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.public-documents.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">{{ __('Judul Dokumen') }}</label>
                            <input id="title" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="title" value="{{ old('title') }}" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Deskripsi (Opsional)') }}</label>
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- File -->
                        <div class="mb-4">
                            <label for="file" class="block font-medium text-sm text-gray-700">{{ __('File Dokumen (PDF, DOCX, XLS, PPT | Max: 200MB)') }}</label>
                            <input id="file" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="file" required>
                            <p class="mt-1 text-sm text-gray-500" id="file_size_info">Maksimum ukuran file: 200MB. Pastikan konfigurasi server (php.ini) mendukung upload file besar.</p>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Color Theme -->
                            <div class="mb-4">
                                <label for="color" class="block font-medium text-sm text-gray-700">{{ __('Tema Warna') }}</label>
                                <select id="color" name="color" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }}>Biru (Default)</option>
                                    <option value="green" {{ old('color') == 'green' ? 'selected' : '' }}>Hijau</option>
                                    <option value="orange" {{ old('color') == 'orange' ? 'selected' : '' }}>Oranye</option>
                                    <option value="red" {{ old('color') == 'red' ? 'selected' : '' }}>Merah</option>
                                    <option value="purple" {{ old('color') == 'purple' ? 'selected' : '' }}>Ungu</option>
                                    <option value="teal" {{ old('color') == 'teal' ? 'selected' : '' }}>Teal</option>
                                </select>
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>

                            <!-- Icon -->
                            <div class="mb-4">
                                <label for="icon" class="block font-medium text-sm text-gray-700">{{ __('Ikon') }}</label>
                                <select id="icon" name="icon" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="document" {{ old('icon') == 'document' ? 'selected' : '' }}>Dokumen Umum</option>
                                    <option value="pdf" {{ old('icon') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <!-- Add more icons if needed implementation -->
                                </select>
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>
                        </div>
                        
                        <!-- Sort Order -->
                        <div class="mb-4">
                             <label for="sort_order" class="block font-medium text-sm text-gray-700">{{ __('Urutan Tampil') }}</label>
                             <input id="sort_order" class="block mt-1 w-24 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" />
                             <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin di atas.</p>
                        </div>

                         <!-- Active Status -->
                         <div class="block mt-4 mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Tampilkan Dokumen Ini') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.public-documents.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">{{ __('Batal') }}</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4">
                                {{ __('Unggah Dokumen') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
