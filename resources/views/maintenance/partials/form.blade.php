<div class="space-y-6">
    {{-- Informasi Dasar --}}
    <x-card title="Informasi Dasar">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="maintenance_code">Kode Maintenance <span class="text-red-500">*</span></x-label>
                <x-input
                    id="maintenance_code"
                    name="maintenance_code"
                    value="{{ old('maintenance_code', $maintenance->maintenance_code ?? '') }}"
                    required
                />
                <p class="text-xs text-gray-500 mt-1">Format: MAINT-EQ-001-2025-001</p>
                @error('maintenance_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="equipment_id">Equipment <span class="text-red-500">*</span></x-label>
                <x-select id="equipment_id" name="equipment_id" placeholder="Pilih equipment" required>
                    @foreach($equipments as $eq)
                        <option value="{{ $eq->id }}"
                            {{ old('equipment_id', $maintenance->equipment_id ?? $selectedEquipment?->id) == $eq->id ? 'selected' : '' }}>
                            {{ $eq->name }} ({{ $eq->code }})
                        </option>
                    @endforeach
                </x-select>
                @error('equipment_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <x-label for="type">Tipe <span class="text-red-500">*</span></x-label>
                <x-select id="type" name="type" placeholder="Pilih tipe" required>
                    <option value="preventive" {{ old('type', $maintenance->type ?? '') == 'preventive' ? 'selected' : '' }}>Pemeliharaan Preventif</option>
                    <option value="corrective" {{ old('type', $maintenance->type ?? '') == 'corrective' ? 'selected' : '' }}>Pemeliharaan Korektif</option>
                    <option value="breakdown" {{ old('type', $maintenance->type ?? '') == 'breakdown' ? 'selected' : '' }}>Perbaikan Kerusakan</option>
                    <option value="inspection" {{ old('type', $maintenance->type ?? '') == 'inspection' ? 'selected' : '' }}>Inspeksi Rutin</option>
                    <option value="cleaning" {{ old('type', $maintenance->type ?? '') == 'cleaning' ? 'selected' : '' }}>Pembersihan</option>
                    <option value="calibration" {{ old('type', $maintenance->type ?? '') == 'calibration' ? 'selected' : '' }}>Kalibrasi</option>
                    <option value="replacement" {{ old('type', $maintenance->type ?? '') == 'replacement' ? 'selected' : '' }}>Penggantian Parts</option>
                </x-select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="priority">Prioritas <span class="text-red-500">*</span></x-label>
                <x-select id="priority" name="priority" required>
                    <option value="low" {{ old('priority', $maintenance->priority ?? 'medium') == 'low' ? 'selected' : '' }}>Rendah</option>
                    <option value="medium" {{ old('priority', $maintenance->priority ?? 'medium') == 'medium' ? 'selected' : '' }}>Sedang</option>
                    <option value="high" {{ old('priority', $maintenance->priority ?? 'medium') == 'high' ? 'selected' : '' }}>Tinggi</option>
                    <option value="urgent" {{ old('priority', $maintenance->priority ?? 'medium') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                </x-select>
                @error('priority')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="status">Status <span class="text-red-500">*</span></x-label>
                <x-select id="status" name="status" required>
                    <option value="scheduled" {{ old('status', $maintenance->status ?? 'scheduled') == 'scheduled' ? 'selected' : '' }}>Dijadwalkan</option>
                    <option value="in_progress" {{ old('status', $maintenance->status ?? '') == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="completed" {{ old('status', $maintenance->status ?? '') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ old('status', $maintenance->status ?? '') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="postponed" {{ old('status', $maintenance->status ?? '') == 'postponed' ? 'selected' : '' }}>Ditunda</option>
                </x-select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-label for="scheduled_date">Tanggal Dijadwalkan <span class="text-red-500">*</span></x-label>
                <x-input
                    id="scheduled_date"
                    type="date"
                    name="scheduled_date"
                    value="{{ old('scheduled_date', $maintenance?->scheduled_date?->format('Y-m-d')) }}"
                    required
                />
                @error('scheduled_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="completed_date">Tanggal Selesai</x-label>
                <x-input
                    id="completed_date"
                    type="date"
                    name="completed_date"
                    value="{{ old('completed_date', $maintenance?->completed_date?->format('Y-m-d')) }}"
                />
                @error('completed_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <x-label for="description">Deskripsi Pekerjaan</x-label>
            <x-textarea
                id="description"
                name="description"
                rows="3"
                :value="old('description', $maintenance->description ?? '')"
            />
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </x-card>

    {{-- Detail Pekerjaan --}}
    <x-card title="Detail Pekerjaan">
        <div>
            <x-label for="work_performed">Pekerjaan yang Dilakukan</x-label>
            <x-textarea
                id="work_performed"
                name="work_performed"
                rows="3"
                :value="old('work_performed', $maintenance->work_performed ?? '')"
            />
            @error('work_performed')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="parts_replaced">Parts yang Diganti</x-label>
            <x-textarea
                id="parts_replaced"
                name="parts_replaced"
                rows="3"
                :value="old('parts_replaced', $maintenance->parts_replaced ?? '')"
            />
            @error('parts_replaced')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="findings">Temuan</x-label>
            <x-textarea
                id="findings"
                name="findings"
                rows="3"
                :value="old('findings', $maintenance->findings ?? '')"
            />
            @error('findings')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="recommendations">Rekomendasi</x-label>
            <x-textarea
                id="recommendations"
                name="recommendations"
                rows="3"
                :value="old('recommendations', $maintenance->recommendations ?? '')"
            />
            @error('recommendations')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </x-card>

    {{-- Personel & Biaya --}}
    <x-card title="Personel & Biaya">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="performed_by">Teknisi</x-label>
                <x-select id="performed_by" name="performed_by" placeholder="Pilih teknisi">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('performed_by', $maintenance->performed_by ?? '') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </x-select>
                @error('performed_by')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="verified_by">Verifikator</x-label>
                <x-select id="verified_by" name="verified_by" placeholder="Pilih verifikator">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('verified_by', $maintenance->verified_by ?? '') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </x-select>
                @error('verified_by')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-label for="labor_cost">Biaya Tenaga Kerja (Rp)</x-label>
                <x-input
                    id="labor_cost"
                    type="number"
                    name="labor_cost"
                    value="{{ old('labor_cost', $maintenance->labor_cost ?? '') }}"
                    min="0"
                    step="0.01"
                />
                @error('labor_cost')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label for="parts_cost">Biaya Parts (Rp)</x-label>
                <x-input
                    id="parts_cost"
                    type="number"
                    name="parts_cost"
                    value="{{ old('parts_cost', $maintenance->parts_cost ?? '') }}"
                    min="0"
                    step="0.01"
                />
                @error('parts_cost')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </x-card>

    {{-- Maintenance Berikutnya --}}
    <x-card title="Maintenance Berikutnya">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="next_maintenance_date">Tanggal Maintenance Berikutnya</x-label>
                <x-input
                    id="next_maintenance_date"
                    type="date"
                    name="next_maintenance_date"
                    value="{{ old('next_maintenance_date', $maintenance?->next_maintenance_date?->format('Y-m-d')) }}"
                />
                @error('next_maintenance_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <x-label for="notes">Catatan</x-label>
            <x-textarea
                id="notes"
                name="notes"
                rows="2"
                :value="old('notes', $maintenance->notes ?? '')"
            />
            @error('notes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </x-card>

    <div class="flex gap-3">
        <x-button type="submit" variant="primary">
            <i class="fa fa-save mr-2"></i>
            {{ isset($maintenance) && $maintenance->exists ? 'Perbarui Record' : 'Simpan Record' }}
        </x-button>
        <x-button
            type="button"
            variant="ghost"
            onclick="window.location.href='{{ route('maintenance.index') }}'"
        >
            Batal
        </x-button>
    </div>
</div>
