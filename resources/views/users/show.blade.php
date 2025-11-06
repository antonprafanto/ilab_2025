<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <x-button
                    variant="ghost"
                    size="sm"
                    onclick="window.location.href='{{ route('users.index') }}'"
                    class="mr-4"
                    title="Kembali"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </x-button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail User') }}
                </h2>
            </div>
            <div class="flex gap-2">
                @can('edit-users')
                <x-button onclick="window.location.href='{{ route('users.edit', $user) }}'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </x-button>
                @endcan
                @can('delete-users')
                @if($user->id !== auth()->id())
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger" type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </x-button>
                </form>
                @endif
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- User Header --}}
            <x-card>
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if($user->avatar)
                                <img class="h-20 w-20 rounded-full" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                            @else
                                <div class="h-20 w-20 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-2xl">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $user->name }}
                            </h3>
                            @if($user->profile?->academic_degree)
                                <p class="text-gray-600 dark:text-gray-400">{{ $user->profile->academic_degree }}</p>
                            @endif
                            <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                            @if($user->nip)
                                <p class="text-sm text-gray-500 dark:text-gray-400">NIP: {{ $user->nip }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Terdaftar sejak</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
                    </div>
                </div>
            </x-card>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Contact Information --}}
                <x-card title="Informasi Kontak">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->phone ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->address ?? '-' }}</dd>
                        </div>
                    </dl>
                </x-card>

                {{-- Profile Information --}}
                <x-card title="Informasi Profil">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Institusi</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->profile?->faculty ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Departemen/Fakultas</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->profile?->department ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jabatan</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->profile?->position ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Spesialisasi</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->profile?->expertise ?? '-' }}</dd>
                        </div>
                    </dl>
                </x-card>
            </div>

            {{-- Roles & Permissions --}}
            <x-card title="Roles & Permissions">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Roles</h4>
                        <div class="flex flex-wrap gap-2">
                            @forelse($user->roles as $role)
                                <x-badge variant="primary">{{ $role->name }}</x-badge>
                            @empty
                                <p class="text-sm text-gray-500">No roles assigned</p>
                            @endforelse
                        </div>
                    </div>

                    @if($user->getAllPermissions()->count() > 0)
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Permissions (via roles)</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                            @foreach($user->getAllPermissions()->unique('name') as $permission)
                                <div class="text-sm text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded">
                                    <i class="fa fa-check-circle text-green-500 mr-1"></i>
                                    {{ $permission->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </x-card>

            {{-- Activity Information --}}
            <x-card title="Informasi Aktivitas">
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Terdaftar</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diperbarui</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1">
                            <x-badge variant="success">Aktif</x-badge>
                        </dd>
                    </div>
                </dl>
            </x-card>
        </div>
    </div>
</x-app-layout>
