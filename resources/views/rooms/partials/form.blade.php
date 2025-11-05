<div class="space-y-6">
    {{-- Basic Information --}}
    <x-card title="Informasi Dasar">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="code">Kode Ruang <span class="text-red-500">*</span></x-label>
                <x-input id="code" name="code" value="{{ old('code', $room?->code) }}" required />
                <p class="text-xs text-gray-500 mt-1">Contoh: R-LAB-001</p>
                @error('code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <x-label for="name">Nama Ruang <span class="text-red-500">*</span></x-label>
                <x-input id="name" name="name" value="{{ old('name', $room?->name) }}" required />
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <x-label for="laboratory_id">Laboratorium <span class="text-red-500">*</span></x-label>
                <x-select id="laboratory_id" name="laboratory_id" required>
                    <option value="">Pilih laboratorium</option>
                    @foreach($laboratories as $lab)
                        <option value="{{ $lab->id }}" {{ old('laboratory_id', $room?->laboratory_id) == $lab->id ? 'selected' : '' }}>
                            {{ $lab->name }}
                        </option>
                    @endforeach
                </x-select>
                @error('laboratory_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <x-label for="type">Tipe Ruang <span class="text-red-500">*</span></x-label>
                <x-select id="type" name="type" required>
                    <option value="research" {{ old('type', $room?->type) == 'research' ? 'selected' : '' }}>Ruang Penelitian</option>
                    <option value="teaching" {{ old('type', $room?->type) == 'teaching' ? 'selected' : '' }}>Ruang Pengajaran</option>
                    <option value="storage" {{ old('type', $room?->type) == 'storage' ? 'selected' : '' }}>Ruang Penyimpanan</option>
                    <option value="preparation" {{ old('type', $room?->type) == 'preparation' ? 'selected' : '' }}>Ruang Persiapan</option>
                    <option value="meeting" {{ old('type', $room?->type) == 'meeting' ? 'selected' : '' }}>Ruang Rapat</option>
                    <option value="office" {{ old('type', $room?->type) == 'office' ? 'selected' : '' }}>Ruang Kantor</option>
                </x-select>
                @error('type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <x-label for="status">Status <span class="text-red-500">*</span></x-label>
                <x-select id="status" name="status" required>
                    <option value="active" {{ old('status', $room?->status ?? 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="maintenance" {{ old('status', $room?->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="inactive" {{ old('status', $room?->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </x-select>
                @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-4">
            <x-label for="description">Deskripsi</x-label>
            <x-textarea id="description" name="description" rows="3">{{ old('description', $room?->description) }}</x-textarea>
            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
    </x-card>

    {{-- Location & Capacity --}}
    <x-card title="Lokasi & Kapasitas">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="building">Gedung</x-label>
                <x-input id="building" name="building" value="{{ old('building', $room?->building) }}" placeholder="Gedung A, B, C..." />
                @error('building')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <x-label for="floor">Lantai</x-label>
                <x-input id="floor" name="floor" value="{{ old('floor', $room?->floor) }}" placeholder="1, 2, 3..." />
                @error('floor')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-label for="area">Luas Ruangan (m²)</x-label>
                <x-input id="area" type="number" name="area" value="{{ old('area', $room?->area) }}" step="0.01" min="0" />
                @error('area')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <x-label for="capacity">Kapasitas (orang)</x-label>
                <x-input id="capacity" type="number" name="capacity" value="{{ old('capacity', $room?->capacity) }}" min="0" />
                @error('capacity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </x-card>

    {{-- Facilities & Safety --}}
    <x-card title="Fasilitas & Keselamatan">
        <div>
            <x-label for="facilities">Fasilitas</x-label>
            <x-textarea id="facilities" name="facilities" rows="3" placeholder="AC, Proyektor, Kursi 20 unit, Meja 10 unit, dll.">{{ old('facilities', $room?->facilities) }}</x-textarea>
            @error('facilities')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mt-4">
            <x-label for="safety_equipment">Peralatan Keselamatan</x-label>
            <x-textarea id="safety_equipment" name="safety_equipment" rows="3" placeholder="APAR, Emergency Shower, Eye Wash, First Aid Kit, dll.">{{ old('safety_equipment', $room?->safety_equipment) }}</x-textarea>
            @error('safety_equipment')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mt-4">
            <x-label for="responsible_person">Penanggung Jawab</x-label>
            <x-select id="responsible_person" name="responsible_person">
                <option value="">Pilih penanggung jawab</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('responsible_person', $room?->responsible_person) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </x-select>
            @error('responsible_person')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mt-4">
            <x-label for="notes">Catatan</x-label>
            <x-textarea id="notes" name="notes" rows="2">{{ old('notes', $room?->notes) }}</x-textarea>
            @error('notes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
    </x-card>

    <div class="flex gap-3">
        <x-button type="submit" variant="primary">
            <i class="fa fa-save mr-2"></i>
            {{ isset($room) && $room->exists ? 'Perbarui Ruang' : 'Simpan Ruang' }}
        </x-button>
        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('rooms.index') }}'">
            Batal
        </x-button>
    </div>
</div>
