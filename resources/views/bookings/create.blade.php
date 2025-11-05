<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Buat Booking Baru') }}
            </h2>
            <a href="{{ route('bookings.calendar') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Kembali ke Kalender
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if(session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bookings.store') }}">
                        @csrf

                        {{-- Basic Info --}}
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                Informasi Dasar
                            </h3>

                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Judul Booking <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Booking Type --}}
                            <div>
                                <label for="booking_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tipe Booking <span class="text-red-500">*</span>
                                </label>
                                <select name="booking_type" id="booking_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Tipe</option>
                                    <option value="research" {{ old('booking_type') == 'research' ? 'selected' : '' }}>Penelitian</option>
                                    <option value="testing" {{ old('booking_type') == 'testing' ? 'selected' : '' }}>Pengujian</option>
                                    <option value="training" {{ old('booking_type') == 'training' ? 'selected' : '' }}>Pelatihan</option>
                                    <option value="maintenance" {{ old('booking_type') == 'maintenance' ? 'selected' : '' }}>Pemeliharaan</option>
                                    <option value="other" {{ old('booking_type') == 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('booking_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Deskripsi
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Purpose --}}
                            <div>
                                <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tujuan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="purpose" id="purpose" rows="3" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('purpose') }}</textarea>
                                @error('purpose')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Laboratory & Equipment --}}
                        <div class="mt-8 space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                Lokasi & Peralatan
                            </h3>

                            {{-- Laboratory --}}
                            <div>
                                <label for="laboratory_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Laboratorium <span class="text-red-500">*</span>
                                </label>
                                <select name="laboratory_id" id="laboratory_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Laboratorium</option>
                                    @foreach($laboratories as $lab)
                                        <option value="{{ $lab->id }}" {{ old('laboratory_id', $prefilledLab) == $lab->id ? 'selected' : '' }}>
                                            {{ $lab->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('laboratory_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Equipment --}}
                            <div>
                                <label for="equipment_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Alat (Opsional)
                                </label>
                                <select name="equipment_id" id="equipment_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Tidak ada alat khusus</option>
                                    @foreach($equipment as $equip)
                                        <option value="{{ $equip->id }}" {{ old('equipment_id') == $equip->id ? 'selected' : '' }}>
                                            {{ $equip->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('equipment_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Schedule --}}
                        <div class="mt-8 space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                Jadwal
                            </h3>

                            {{-- Date --}}
                            <div>
                                <label for="booking_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date', $prefilledDate) }}" required
                                    min="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('booking_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                {{-- Start Time --}}
                                <div>
                                    <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Waktu Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $prefilledTime) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('start_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- End Time --}}
                                <div>
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Waktu Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('end_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Additional Info --}}
                        <div class="mt-8 space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                Informasi Tambahan
                            </h3>

                            {{-- Expected Participants --}}
                            <div>
                                <label for="expected_participants" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jumlah Partisipan
                                </label>
                                <input type="number" name="expected_participants" id="expected_participants" value="{{ old('expected_participants', 1) }}" min="1"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('expected_participants')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Special Requirements --}}
                            <div>
                                <label for="special_requirements" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kebutuhan Khusus
                                </label>
                                <textarea name="special_requirements" id="special_requirements" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('special_requirements') }}</textarea>
                                @error('special_requirements')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Recurring Options --}}
                        <div class="mt-8 space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                Booking Berulang (Opsional)
                            </h3>

                            {{-- Is Recurring --}}
                            <div class="flex items-center">
                                <input type="checkbox" name="is_recurring" id="is_recurring" value="1" {{ old('is_recurring') ? 'checked' : '' }}
                                    onchange="toggleRecurring()"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <label for="is_recurring" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                    Aktifkan booking berulang
                                </label>
                            </div>

                            <div id="recurring_options" style="display: {{ old('is_recurring') ? 'block' : 'none' }};">
                                <div class="grid grid-cols-2 gap-4">
                                    {{-- Recurrence Pattern --}}
                                    <div>
                                        <label for="recurrence_pattern" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Pola Pengulangan
                                        </label>
                                        <select name="recurrence_pattern" id="recurrence_pattern"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Pilih Pola</option>
                                            <option value="daily" {{ old('recurrence_pattern') == 'daily' ? 'selected' : '' }}>Harian</option>
                                            <option value="weekly" {{ old('recurrence_pattern') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                            <option value="monthly" {{ old('recurrence_pattern') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                        </select>
                                    </div>

                                    {{-- Recurrence End Date --}}
                                    <div>
                                        <label for="recurrence_end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Akhir Pengulangan
                                        </label>
                                        <input type="date" name="recurrence_end_date" id="recurrence_end_date" value="{{ old('recurrence_end_date') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-8 flex items-center justify-end gap-4">
                            <a href="{{ route('bookings.calendar') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Buat Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <style>
        /* Fix date and time picker icons visibility in dark mode */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
            font-size: 1.2em;
            padding: 0.25rem;
        }

        /* Add visible background to date/time inputs */
        input[type="date"],
        input[type="time"] {
            position: relative;
            padding-right: 2.5rem !important;
        }

        /* Better hover state */
        input[type="date"]:hover::-webkit-calendar-picker-indicator,
        input[type="time"]:hover::-webkit-calendar-picker-indicator {
            background-color: rgba(99, 102, 241, 0.1);
            border-radius: 0.25rem;
        }
    </style>

    <script>
        function toggleRecurring() {
            const checkbox = document.getElementById('is_recurring');
            const options = document.getElementById('recurring_options');
            options.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>
    @endpush
</x-app-layout>
