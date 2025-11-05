<div class="space-y-6">

    {{-- Basic Information --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Dasar</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                label="Nama Laboratorium"
                name="name"
                :value="old('name', $laboratory->name ?? '')"
                placeholder="Lab. Kimia Analitik"
                required="true"
                :error="$errors->first('name')" />

            <x-input
                label="Kode Laboratorium"
                name="code"
                :value="old('code', $laboratory->code ?? '')"
                placeholder="LAB-KIM-001"
                required="true"
                hint="Format: LAB-XXX-001"
                :error="$errors->first('code')" />

            <x-select
                label="Tipe Laboratorium"
                name="type"
                :value="old('type', $laboratory->type ?? '')"
                :options="[
                    'chemistry' => 'Kimia',
                    'biology' => 'Biologi',
                    'physics' => 'Fisika',
                    'geology' => 'Geologi',
                    'engineering' => 'Teknik',
                    'computer' => 'Komputer',
                    'other' => 'Lainnya'
                ]"
                required="true"
                :error="$errors->first('type')" />

            <x-select
                label="Status"
                name="status"
                :value="old('status', $laboratory->status ?? 'active')"
                :options="[
                    'active' => 'Aktif',
                    'maintenance' => 'Maintenance',
                    'closed' => 'Tutup'
                ]"
                required="true"
                :error="$errors->first('status')" />
        </div>
    </div>

    {{-- Description --}}
    <div>
        <x-textarea
            label="Deskripsi"
            name="description"
            :value="old('description', $laboratory->description ?? '')"
            placeholder="Deskripsi singkat tentang laboratorium..."
            rows="4"
            maxlength="1000"
            showCounter="true"
            :error="$errors->first('description')" />
    </div>

    {{-- Location & Capacity --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Lokasi & Kapasitas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-input
                label="Lokasi"
                name="location"
                :value="old('location', $laboratory->location ?? '')"
                placeholder="Gedung A, Lantai 3, Ruang 301"
                icon="fa fa-map-marker-alt"
                :error="$errors->first('location')" />

            <x-input
                label="Luas (m²)"
                name="area_sqm"
                type="number"
                step="0.01"
                :value="old('area_sqm', $laboratory->area_sqm ?? '')"
                placeholder="100.50"
                :error="$errors->first('area_sqm')" />

            <x-input
                label="Kapasitas (orang)"
                name="capacity"
                type="number"
                :value="old('capacity', $laboratory->capacity ?? '')"
                placeholder="30"
                :error="$errors->first('capacity')" />
        </div>
    </div>

    {{-- Photo Upload --}}
    <div>
        <x-file-upload
            label="Foto Laboratorium"
            name="photo"
            accept="image/*"
            hint="Format: JPG, PNG. Max: 2MB"
            :error="$errors->first('photo')" />

        @if(isset($laboratory) && $laboratory->photo)
            <div class="mt-4">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Saat Ini:</p>
                <img src="{{ $laboratory->photo_url }}" alt="{{ $laboratory->name }}" class="w-48 h-32 object-cover rounded-lg">
            </div>
        @endif
    </div>

    {{-- Kepala Lab --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Penanggung Jawab</h3>
        <x-select
            label="Kepala Laboratorium"
            name="head_user_id"
            :value="old('head_user_id', $laboratory->head_user_id ?? '')"
            placeholder="Pilih Kepala Lab"
            :error="$errors->first('head_user_id')">
            <option value="">-- Pilih Kepala Lab --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('head_user_id', $laboratory->head_user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->full_name }}
                </option>
            @endforeach
        </x-select>
    </div>

    {{-- Contact Information --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Kontak</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                label="Telepon"
                name="phone"
                type="tel"
                :value="old('phone', $laboratory->phone ?? '')"
                placeholder="0541-1234567"
                icon="fa fa-phone"
                :error="$errors->first('phone')" />

            <x-input
                label="Email"
                name="email"
                type="email"
                :value="old('email', $laboratory->email ?? '')"
                placeholder="labkimia@unmul.ac.id"
                icon="fa fa-envelope"
                :error="$errors->first('email')" />
        </div>
    </div>

    {{-- Operating Hours --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Jam Operasional</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <x-input
                label="Jam Buka"
                name="operating_hours_start"
                type="time"
                :value="old('operating_hours_start', isset($laboratory) && $laboratory->operating_hours_start ? $laboratory->operating_hours_start->format('H:i') : '')"
                :error="$errors->first('operating_hours_start')" />

            <x-input
                label="Jam Tutup"
                name="operating_hours_end"
                type="time"
                :value="old('operating_hours_end', isset($laboratory) && $laboratory->operating_hours_end ? $laboratory->operating_hours_end->format('H:i') : '')"
                :error="$errors->first('operating_hours_end')" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hari Operasional</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @php
                    $days = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
                    $selectedDays = old('operating_days', $laboratory->operating_days ?? []);
                @endphp
                @foreach($days as $value => $label)
                    <x-checkbox
                        :label="$label"
                        name="operating_days[]"
                        :value="$value"
                        :checked="in_array($value, (array)$selectedDays)" />
                @endforeach
            </div>
        </div>
    </div>

    {{-- Status Notes (if not active) --}}
    <div x-data="{ showNotes: {{ old('status', $laboratory->status ?? 'active') !== 'active' ? 'true' : 'false' }} }">
        <div x-show="showNotes">
            <x-textarea
                label="Catatan Status"
                name="status_notes"
                :value="old('status_notes', $laboratory->status_notes ?? '')"
                placeholder="Jelaskan alasan maintenance atau penutupan..."
                rows="3"
                :error="$errors->first('status_notes')" />
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
        <x-button
            type="button"
            variant="ghost"
            onclick="window.history.back()">
            Batal
        </x-button>
        <x-button type="submit" variant="primary">
            <i class="fa fa-save mr-2"></i>
            {{ isset($laboratory) ? 'Update Laboratorium' : 'Simpan Laboratorium' }}
        </x-button>
    </div>

</div>

<script>
    // Show/hide status notes based on status selection
    document.addEventListener('alpine:init', () => {
        const statusSelect = document.querySelector('select[name="status"]');
        if (statusSelect) {
            statusSelect.addEventListener('change', (e) => {
                const showNotes = e.target.value !== 'active';
                Alpine.evaluate(document.querySelector('[x-data]'), `showNotes = ${showNotes}`);
            });
        }
    });
</script>
