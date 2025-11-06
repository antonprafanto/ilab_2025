<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Booking') }}
            </h2>
            <a href="{{ route('bookings.show', $booking) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Kembali
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

                    <form method="POST" action="{{ route('bookings.update', $booking) }}">
                        @csrf
                        @method('PUT')

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
                                <input type="text" name="title" id="title" value="{{ old('title', $booking->title) }}" required
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
                                    <option value="research" {{ old('booking_type', $booking->booking_type) == 'research' ? 'selected' : '' }}>Penelitian</option>
                                    <option value="testing" {{ old('booking_type', $booking->booking_type) == 'testing' ? 'selected' : '' }}>Pengujian</option>
                                    <option value="training" {{ old('booking_type', $booking->booking_type) == 'training' ? 'selected' : '' }}>Pelatihan</option>
                                    <option value="maintenance" {{ old('booking_type', $booking->booking_type) == 'maintenance' ? 'selected' : '' }}>Pemeliharaan</option>
                                    <option value="other" {{ old('booking_type', $booking->booking_type) == 'other' ? 'selected' : '' }}>Lainnya</option>
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
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $booking->description) }}</textarea>
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
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('purpose', $booking->purpose) }}</textarea>
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
                                        <option value="{{ $lab->id }}" {{ old('laboratory_id', $booking->laboratory_id) == $lab->id ? 'selected' : '' }}>
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
                                        <option value="{{ $equip->id }}" {{ old('equipment_id', $booking->equipment_id) == $equip->id ? 'selected' : '' }}>
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
                                <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date', $booking->booking_date?->format('Y-m-d') ?? '') }}" required
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
                                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $booking->start_time?->format('H:i') ?? '') }}" required
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
                                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $booking->end_time?->format('H:i') ?? '') }}" required
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
                                <input type="number" name="expected_participants" id="expected_participants" value="{{ old('expected_participants', $booking->expected_participants) }}" min="1"
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
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('special_requirements', $booking->special_requirements) }}</textarea>
                                @error('special_requirements')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Recurring Options - Display Only (Cannot Edit) --}}
                        @if($booking->is_recurring || $booking->parent_booking_id)
                        <div class="mt-8 space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                Informasi Booking Berulang
                            </h3>

                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md p-4">
                                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                    @if($booking->parent_booking_id)
                                        <strong>Catatan:</strong> Ini adalah booking anak dari series berulang. Perubahan hanya akan mempengaruhi booking ini saja, bukan seluruh series.
                                    @else
                                        <strong>Catatan:</strong> Ini adalah booking induk dari series berulang. Perubahan hanya akan mempengaruhi booking ini saja, bukan booking anak lainnya.
                                    @endif
                                </p>

                                @if($booking->is_recurring && !$booking->parent_booking_id)
                                <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                                    <p><strong>Pola:</strong> {{ ucfirst($booking->recurrence_pattern) }}</p>
                                    @if($booking->recurrence_end_date)
                                    <p><strong>Berakhir:</strong> {{ $booking->recurrence_end_date ? $booking->recurrence_end_date->format('d M Y') : '-' }}</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        {{-- Actions --}}
                        <div class="mt-8 flex items-center justify-end gap-4">
                            <a href="{{ route('bookings.calendar') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Perbarui Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
