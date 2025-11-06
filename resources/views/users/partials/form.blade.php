<div class="space-y-6">
    {{-- Informasi Dasar --}}
    <x-card title="Informasi Dasar">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="name">Nama Lengkap <span class="text-red-500">*</span></x-label>
                <x-input
                    id="name"
                    name="name"
                    value="{{ old('name', $user?->name) }}"
                    required
                />
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="email">Email <span class="text-red-500">*</span></x-label>
                <x-input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $user?->email) }}"
                    required
                />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-label for="nip_nim">NIP/NIM</x-label>
                <x-input
                    id="nip_nim"
                    name="nip_nim"
                    value="{{ old('nip_nim', $user?->nip_nim) }}"
                />
                @error('nip_nim')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="phone">Telepon</x-label>
                <x-input
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $user?->phone) }}"
                />
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <x-label for="address">Alamat</x-label>
            <x-textarea
                id="address"
                name="address"
                rows="2"
            >{{ old('address', $user?->address) }}</x-textarea>
            @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </x-card>

    {{-- Password --}}
    <x-card title="Password">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="password">Password {{ isset($user) ? '' : '*' }}</x-label>
                <div class="relative">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        {{ isset($user) ? '' : 'required' }}
                        class="block w-full pr-10 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-[#0066CC] focus:ring-[#0066CC] focus:ring-1"
                    />
                    <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg id="eye-icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-slash-icon-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                </div>
                @if(isset($user))
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                @endif
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="password_confirmation">Konfirmasi Password {{ isset($user) ? '' : '*' }}</x-label>
                <div class="relative">
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        {{ isset($user) ? '' : 'required' }}
                        class="block w-full pr-10 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-[#0066CC] focus:ring-[#0066CC] focus:ring-1"
                    />
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg id="eye-icon-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-slash-icon-password_confirmation" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </x-card>

    {{-- Roles --}}
    <x-card title="Roles & Permissions">
        <div>
            <x-label>Pilih Role <span class="text-red-500">*</span></x-label>
            <p class="text-sm text-gray-500 mb-3">User dapat memiliki lebih dari satu role</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($roles as $role)
                    <div class="flex items-start">
                        <input
                            type="checkbox"
                            id="role_{{ $role->id }}"
                            name="roles[]"
                            value="{{ $role->name }}"
                            {{ (old('roles') && in_array($role->name, old('roles'))) || (isset($user) && $user->hasRole($role->name)) ? 'checked' : '' }}
                            class="mt-1 rounded border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500"
                        >
                        <label for="role_{{ $role->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium">{{ $role->name }}</span>
                            @if($role->permissions->count() > 0)
                                <span class="text-gray-500 text-xs block">{{ $role->permissions->count() }} permissions</span>
                            @endif
                        </label>
                    </div>
                @endforeach
            </div>

            @error('roles')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </x-card>

    {{-- Profile Information --}}
    <x-card title="Informasi Profil">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="institution">Institusi</x-label>
                <x-input
                    id="institution"
                    name="institution"
                    value="{{ old('institution', $user?->profile?->faculty) }}"
                />
                @error('institution')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="department">Departemen/Fakultas</x-label>
                <x-input
                    id="department"
                    name="department"
                    value="{{ old('department', $user?->profile?->department) }}"
                />
                @error('department')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-label for="position">Jabatan</x-label>
                <x-input
                    id="position"
                    name="position"
                    value="{{ old('position', $user?->profile?->position) }}"
                />
                @error('position')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="academic_degree">Gelar Akademik</x-label>
                <x-input
                    id="academic_degree"
                    name="academic_degree"
                    value="{{ old('academic_degree', $user?->profile?->academic_degree) }}"
                    placeholder="S.Si., M.Si., Dr., Prof."
                />
                @error('academic_degree')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <x-label for="specialization">Spesialisasi/Bidang Keahlian</x-label>
            <x-input
                id="specialization"
                name="specialization"
                value="{{ old('specialization', $user?->profile?->expertise) }}"
            />
            @error('specialization')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </x-card>

    <div class="flex gap-3">
        <x-button type="submit" variant="primary">
            <i class="fa fa-save mr-2"></i>
            {{ isset($user) && $user->exists ? 'Perbarui User' : 'Simpan User' }}
        </x-button>
        <x-button
            type="button"
            variant="ghost"
            onclick="window.location.href='{{ route('users.index') }}'"
        >
            Batal
        </x-button>
    </div>
</div>

<script>
    function togglePasswordVisibility(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const eyeIcon = document.getElementById('eye-icon-' + fieldId);
        const eyeSlashIcon = document.getElementById('eye-slash-icon-' + fieldId);

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        }
    }
</script>
