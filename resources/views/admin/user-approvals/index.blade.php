<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Persetujuan Pengguna Baru') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.user-approvals.approved') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Disetujui
                </a>
                <a href="{{ route('admin.user-approvals.rejected') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Ditolak
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($pendingUsers->count() > 0)
                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $pendingUsers->total() }} pengguna menunggu persetujuan
                        </div>

                        <div class="space-y-4">
                            @foreach($pendingUsers as $user)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-4 mb-3">
                                                <div class="w-16 h-16 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-bold">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        {{ $user->name }}
                                                    </h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                                    <div class="flex gap-2 mt-1">
                                                        @foreach($user->roles as $role)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                                                {{ $role->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 mt-4">
                                                @if($user->phone)
                                                    <div>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">Telepon:</span>
                                                        <p class="text-sm text-gray-900 dark:text-white">{{ $user->phone }}</p>
                                                    </div>
                                                @endif

                                                @if($user->institution)
                                                    <div>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">Institusi:</span>
                                                        <p class="text-sm text-gray-900 dark:text-white">{{ $user->institution }}</p>
                                                    </div>
                                                @endif

                                                @if($user->nip_nim)
                                                    <div>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">NIP/NIM:</span>
                                                        <p class="text-sm text-gray-900 dark:text-white">{{ $user->nip_nim }}</p>
                                                    </div>
                                                @endif

                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">Tanggal Daftar:</span>
                                                    <p class="text-sm text-gray-900 dark:text-white">{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex gap-2 ml-4">
                                            <!-- Approve Button -->
                                            <form action="{{ route('admin.user-approvals.approve', $user) }}" method="POST" onsubmit="return confirm('Setujui pengguna {{ $user->name }}?')">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Setujui
                                                </button>
                                            </form>

                                            <!-- Reject Button (trigger modal) -->
                                            <button
                                                type="button"
                                                onclick="openRejectModal({{ $user->id }}, '{{ $user->name }}')"
                                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Tolak
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $pendingUsers->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada pengguna yang menunggu persetujuan</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Semua pendaftaran telah diproses.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Tolak Pendaftaran
                    </h3>
                    <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Anda akan menolak pendaftaran <span id="rejectUserName" class="font-semibold"></span>
                        </p>

                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="rejection_reason"
                            name="rejection_reason"
                            rows="4"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Contoh: Data yang dimasukkan tidak valid, Email bukan dari UNMUL, dll."></textarea>
                    </div>

                    <div class="flex gap-2 justify-end">
                        <button
                            type="button"
                            onclick="closeRejectModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                            Tolak Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(userId, userName) {
            document.getElementById('rejectUserName').textContent = userName;
            document.getElementById('rejectForm').action = `/admin/user-approvals/${userId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejection_reason').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>
