<div class="space-y-6">

    {{-- Basic Information --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Dasar</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                label="Nama Alat"
                name="name"
                :value="old('name', $equipment->name ?? '')"
                placeholder="FTIR Spectrometer"
                required="true"
                :error="$errors->first('name')" />

            <x-input
                label="Kode Alat"
                name="code"
                :value="old('code', $equipment->code ?? '')"
                placeholder="EQ-LAB-001"
                required="true"
                hint="Format: EQ-XXX-001"
                :error="$errors->first('code')" />

            <x-select
                label="Laboratorium"
                name="laboratory_id"
                :value="old('laboratory_id', $equipment->laboratory_id ?? '')"
                required="true"
                :error="$errors->first('laboratory_id')">
                <option value="">-- Pilih Laboratorium --</option>
                @foreach($laboratories as $lab)
                    <option value="{{ $lab->id }}" {{ old('laboratory_id', $equipment->laboratory_id ?? '') == $lab->id ? 'selected' : '' }}>
                        {{ $lab->name }}
                    </option>
                @endforeach
            </x-select>

            <x-select
                label="Kategori"
                name="category"
                :value="old('category', $equipment->category ?? '')"
                :options="[
                    'analytical' => 'Analitik',
                    'measurement' => 'Pengukuran',
                    'preparation' => 'Preparasi',
                    'safety' => 'Keselamatan',
                    'computer' => 'Komputer',
                    'general' => 'Umum'
                ]"
                required="true"
                :error="$errors->first('category')" />

            <x-input
                label="Merk"
                name="brand"
                :value="old('brand', $equipment->brand ?? '')"
                placeholder="Shimadzu"
                icon="fa fa-tag"
                :error="$errors->first('brand')" />

            <x-input
                label="Model"
                name="model"
                :value="old('model', $equipment->model ?? '')"
                placeholder="IRPrestige-21"
                :error="$errors->first('model')" />

            <x-input
                label="Serial Number"
                name="serial_number"
                :value="old('serial_number', $equipment->serial_number ?? '')"
                placeholder="A12345678"
                :error="$errors->first('serial_number')" />

            <x-input
                label="Detail Lokasi"
                name="location_detail"
                :value="old('location_detail', $equipment->location_detail ?? '')"
                placeholder="Rak A, Lemari 2"
                icon="fa fa-map-marker-alt"
                :error="$errors->first('location_detail')" />
        </div>
    </div>

    {{-- Description --}}
    <div>
        <x-textarea
            label="Deskripsi"
            name="description"
            :value="old('description', $equipment->description ?? '')"
            placeholder="Deskripsi singkat tentang alat ini..."
            rows="3"
            :error="$errors->first('description')" />
    </div>

    {{-- Photo Upload --}}
    <div>
        <x-file-upload
            label="Foto Alat"
            name="photo"
            accept="image/*"
            hint="Format: JPG, PNG. Max: 2MB"
            :error="$errors->first('photo')" />

        @if(isset($equipment) && $equipment->photo)
            <div class="mt-4">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Saat Ini:</p>
                <img src="{{ $equipment->photo_url }}" alt="{{ $equipment->name }}" class="w-48 h-32 object-cover rounded-lg">
            </div>
        @endif
    </div>

    {{-- Purchase Information --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Pembelian</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                label="Tanggal Pembelian"
                name="purchase_date"
                type="date"
                :value="old('purchase_date', $equipment->purchase_date ?? '')"
                :error="$errors->first('purchase_date')" />

            <x-input
                label="Harga Pembelian (Rp)"
                name="purchase_price"
                type="number"
                step="0.01"
                :value="old('purchase_price', $equipment->purchase_price ?? '')"
                placeholder="450000000"
                icon="fa fa-money-bill-wave"
                :error="$errors->first('purchase_price')" />

            <x-input
                label="Supplier"
                name="supplier"
                :value="old('supplier', $equipment->supplier ?? '')"
                placeholder="PT Shimadzu Indonesia"
                :error="$errors->first('supplier')" />

            <x-input
                label="Periode Garansi"
                name="warranty_period"
                :value="old('warranty_period', $equipment->warranty_period ?? '')"
                placeholder="2 tahun"
                :error="$errors->first('warranty_period')" />

            <x-input
                label="Garansi Sampai"
                name="warranty_until"
                type="date"
                :value="old('warranty_until', $equipment->warranty_until ?? '')"
                :error="$errors->first('warranty_until')" />
        </div>
    </div>

    {{-- Status & Condition --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Status & Kondisi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select
                label="Kondisi"
                name="condition"
                :value="old('condition', $equipment->condition ?? 'good')"
                :options="[
                    'excellent' => 'Sangat Baik',
                    'good' => 'Baik',
                    'fair' => 'Cukup',
                    'poor' => 'Buruk',
                    'broken' => 'Rusak'
                ]"
                required="true"
                :error="$errors->first('condition')" />

            <x-select
                label="Status"
                name="status"
                :value="old('status', $equipment->status ?? 'available')"
                :options="[
                    'available' => 'Tersedia',
                    'in_use' => 'Sedang Digunakan',
                    'maintenance' => 'Maintenance',
                    'calibration' => 'Kalibrasi',
                    'broken' => 'Rusak',
                    'retired' => 'Retired'
                ]"
                required="true"
                :error="$errors->first('status')" />

            <x-select
                label="Ditugaskan Kepada"
                name="assigned_to"
                :value="old('assigned_to', $equipment->assigned_to ?? '')"
                placeholder="Pilih User"
                :error="$errors->first('assigned_to')">
                <option value="">-- Tidak Ada --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('assigned_to', $equipment->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} - {{ $user->email }}
                    </option>
                @endforeach
            </x-select>
        </div>

        <div class="mt-4">
            <x-textarea
                label="Catatan Status"
                name="status_notes"
                :value="old('status_notes', $equipment->status_notes ?? '')"
                placeholder="Catatan tambahan tentang status alat..."
                rows="2"
                :error="$errors->first('status_notes')" />
        </div>
    </div>

    {{-- Maintenance & Calibration Schedule --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Jadwal Maintenance & Kalibrasi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                label="Interval Maintenance (hari)"
                name="maintenance_interval_days"
                type="number"
                :value="old('maintenance_interval_days', $equipment->maintenance_interval_days ?? '')"
                placeholder="90"
                hint="Hari antara maintenance rutin"
                :error="$errors->first('maintenance_interval_days')" />

            <x-input
                label="Interval Kalibrasi (hari)"
                name="calibration_interval_days"
                type="number"
                :value="old('calibration_interval_days', $equipment->calibration_interval_days ?? '')"
                placeholder="365"
                hint="Hari antara kalibrasi"
                :error="$errors->first('calibration_interval_days')" />
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
            {{ isset($equipment) && $equipment->id ? 'Update Alat' : 'Simpan Alat' }}
        </x-button>
    </div>

</div>
