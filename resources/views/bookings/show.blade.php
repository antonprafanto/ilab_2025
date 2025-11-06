<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Booking') }}
            </h2>
            <a href="{{ route('bookings.my-bookings') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Booking Info --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $booking->title }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $booking->booking_number }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-{{ $booking->status_badge }}-100 text-{{ $booking->status_badge }}-800">
                                    {{ $booking->status_label }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-6">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</label>
                                    <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->formatted_date }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Waktu</label>
                                    <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->formatted_time }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Durasi</label>
                                    <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->duration_hours }} jam</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipe Booking</label>
                                    <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->booking_type_label }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Laboratorium</label>
                                    <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->laboratory?->name ?? '-' }}</p>
                                </div>

                                @if($booking->equipment)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Alat</label>
                                        <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->equipment?->name ?? '-' }}</p>
                                    </div>
                                @endif

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Partisipan</label>
                                    <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->expected_participants }} orang</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat oleh</label>
                                    <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->user?->name ?? '-' }}</p>
                                </div>
                            </div>

                            @if($booking->description)
                                <div class="mt-6">
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</label>
                                    <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->description }}</p>
                                </div>
                            @endif

                            <div class="mt-6">
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tujuan</label>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->purpose }}</p>
                            </div>

                            @if($booking->special_requirements)
                                <div class="mt-6">
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Kebutuhan Khusus</label>
                                    <p class="mt-1 text-gray-900 dark:text-white">{{ $booking->special_requirements }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi</h4>
                            <div class="flex flex-wrap gap-3">

                                @if($booking->status === 'pending' && Auth::user()->hasRole(['Kepala Lab']))
                                    <form method="POST" action="{{ route('bookings.approve', $booking) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                            Setujui Booking
                                        </button>
                                    </form>
                                @endif

                                @if($booking->status === 'approved' && $booking->user_id === Auth::id())
                                    <form method="POST" action="{{ route('bookings.confirm', $booking) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                            Konfirmasi Booking
                                        </button>
                                    </form>
                                @endif

                                @if($booking->canCheckIn())
                                    <form method="POST" action="{{ route('bookings.check-in', $booking) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                            Check-in
                                        </button>
                                    </form>
                                @endif

                                @if($booking->canCheckOut())
                                    <form method="POST" action="{{ route('bookings.check-out', $booking) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                                            Check-out
                                        </button>
                                    </form>
                                @endif

                                @if(in_array($booking->status, ['pending', 'approved', 'confirmed']) && ($booking->user_id === Auth::id() || Auth::user()->hasRole(['Super Admin', 'Kepala Lab'])))
                                    <button onclick="cancelBooking()" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                        Batalkan Booking
                                    </button>
                                @endif

                                @if($booking->user_id === Auth::id() && !in_array($booking->status, ['checked_in', 'completed', 'cancelled']))
                                    <a href="{{ route('bookings.edit', $booking) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                        Edit Booking
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Conflicts --}}
                    @if(!empty($conflicts))
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200 mb-3">⚠️ Konflik Terdeteksi</h4>
                            @if(isset($conflicts['laboratory']))
                                <div class="mb-3">
                                    <p class="font-medium text-yellow-700 dark:text-yellow-300">Konflik Laboratorium:</p>
                                    @foreach($conflicts['laboratory'] as $conflict)
                                        <p class="text-sm text-yellow-600 dark:text-yellow-400">- {{ $conflict->title }} ({{ $conflict->user?->name ?? 'User tidak diketahui' }})</p>
                                    @endforeach
                                </div>
                            @endif
                            @if(isset($conflicts['equipment']))
                                <div>
                                    <p class="font-medium text-yellow-700 dark:text-yellow-300">Konflik Alat:</p>
                                    @foreach($conflicts['equipment'] as $conflict)
                                        <p class="text-sm text-yellow-600 dark:text-yellow-400">- {{ $conflict->title }} ({{ $conflict->user?->name ?? 'User tidak diketahui' }})</p>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif

                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">

                    {{-- Timeline --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Timeline</h4>
                            <div class="space-y-4">
                                @if($booking->created_at)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="h-4 w-4 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Dibuat</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($booking->approved_at)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-200 dark:bg-green-700 flex items-center justify-center">
                                            <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Disetujui</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->approved_at->format('d M Y H:i') }}</p>
                                            @if($booking->approvedBy)
                                                <p class="text-xs text-gray-400 dark:text-gray-500">oleh {{ $booking->approvedBy->name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($booking->checked_in_at)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-200 dark:bg-blue-700 flex items-center justify-center">
                                            <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Check-in</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->checked_in_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($booking->checked_out_at)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-purple-200 dark:bg-purple-700 flex items-center justify-center">
                                            <svg class="h-4 w-4 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Check-out</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->checked_out_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($booking->cancelled_at)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-red-200 dark:bg-red-700 flex items-center justify-center">
                                            <svg class="h-4 w-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Dibatalkan</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->cancelled_at->format('d M Y H:i') }}</p>
                                            @if($booking->cancellation_reason)
                                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $booking->cancellation_reason }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function cancelBooking() {
            const reason = prompt('Alasan pembatalan:');
            if (reason === null || reason.trim() === '') {
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("bookings.cancel", $booking) }}';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';

            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'cancellation_reason';
            reasonInput.value = reason;

            form.appendChild(csrf);
            form.appendChild(reasonInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
    @endpush
</x-app-layout>
