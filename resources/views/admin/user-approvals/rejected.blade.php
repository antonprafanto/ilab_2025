<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pengguna yang Ditolak') }}
            </h2>
            <a href="{{ route('admin.user-approvals.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Pending
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($rejectedUsers->count() > 0)
                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $rejectedUsers->total() }} pengguna telah ditolak
                        </div>

                        <div class="space-y-4">
                            @foreach($rejectedUsers as $user)
                                <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-6 border border-red-200 dark:border-red-800">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-4 mb-3">
                                                <div class="w-16 h-16 rounded-full bg-red-600 flex items-center justify-center text-white text-xl font-bold">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        {{ $user->name }}
                                                    </h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                                    <div class="flex gap-2 mt-1">
                                                        @foreach($user->roles as $role)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                                {{ $role->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 mt-4 mb-4">
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
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">Ditolak pada:</span>
                                                    <p class="text-sm text-gray-900 dark:text-white">{{ $user->approved_at ? $user->approved_at->format('d M Y H:i') : '-' }}</p>
                                                </div>

                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">Ditolak oleh:</span>
                                                    <p class="text-sm text-gray-900 dark:text-white">{{ $user->approver?->name ?? 'System' }}</p>
                                                </div>
                                            </div>

                                            @if($user->rejection_reason)
                                                <div class="bg-white dark:bg-gray-800 rounded-md p-4 border border-red-300 dark:border-red-700">
                                                    <div class="flex items-start">
                                                        <svg class="w-5 h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                        </svg>
                                                        <div class="flex-1">
                                                            <span class="text-xs font-semibold text-red-800 dark:text-red-400 uppercase">Alasan Penolakan:</span>
                                                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $user->rejection_reason }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $rejectedUsers->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada pengguna yang ditolak</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
