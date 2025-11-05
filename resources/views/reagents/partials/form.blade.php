<div class="space-y-6">
    <x-card title="Informasi Dasar">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><x-label for="code">Kode <span class="text-red-500">*</span></x-label><x-input id="code" name="code" value="{{ old('code', $reagent?->code) }}" required />@error('code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div><x-label for="name">Nama Reagen <span class="text-red-500">*</span></x-label><x-input id="name" name="name" value="{{ old('name', $reagent?->name) }}" required />@error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div><x-label for="cas_number">CAS Number</x-label><x-input id="cas_number" name="cas_number" value="{{ old('cas_number', $reagent?->cas_number) }}" placeholder="7647-14-5" />@error('cas_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div><x-label for="formula">Formula Kimia</x-label><x-input id="formula" name="formula" value="{{ old('formula', $reagent?->formula) }}" placeholder="NaCl, H2SO4" />@error('formula')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div>
                <x-label for="laboratory_id">Laboratorium <span class="text-red-500">*</span></x-label>
                <x-select id="laboratory_id" name="laboratory_id" placeholder="Pilih laboratorium" required>
                    @foreach($laboratories as $lab)
                        <option value="{{ $lab->id }}" {{ old('laboratory_id', $reagent?->laboratory_id) == $lab->id ? 'selected' : '' }}>{{ $lab->name }}</option>
                    @endforeach
                </x-select>
                @error('laboratory_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
            <div>
                <x-label for="category">Kategori <span class="text-red-500">*</span></x-label>
                <x-select id="category" name="category" required>
                    <option value="acid" {{ old('category', $reagent?->category) == 'acid' ? 'selected' : '' }}>Asam</option>
                    <option value="base" {{ old('category', $reagent?->category) == 'base' ? 'selected' : '' }}>Basa</option>
                    <option value="salt" {{ old('category', $reagent?->category) == 'salt' ? 'selected' : '' }}>Garam</option>
                    <option value="organic" {{ old('category', $reagent?->category) == 'organic' ? 'selected' : '' }}>Organik</option>
                    <option value="inorganic" {{ old('category', $reagent?->category) == 'inorganic' ? 'selected' : '' }}>Anorganik</option>
                    <option value="solvent" {{ old('category', $reagent?->category) == 'solvent' ? 'selected' : '' }}>Pelarut</option>
                    <option value="indicator" {{ old('category', $reagent?->category) == 'indicator' ? 'selected' : '' }}>Indikator</option>
                    <option value="standard" {{ old('category', $reagent?->category) == 'standard' ? 'selected' : '' }}>Standar</option>
                    <option value="other" {{ old('category', $reagent?->category ?? 'other') == 'other' ? 'selected' : '' }}>Lainnya</option>
                </x-select>
                @error('category')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div><x-label for="grade">Grade</x-label><x-input id="grade" name="grade" value="{{ old('grade', $reagent?->grade) }}" placeholder="AR, PA, LR" />@error('grade')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div><x-label for="purity">Kemurnian</x-label><x-input id="purity" name="purity" value="{{ old('purity', $reagent?->purity) }}" placeholder="99.9%, >98%" />@error('purity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div>
                <x-label for="status">Status <span class="text-red-500">*</span></x-label>
                <x-select id="status" name="status" required>
                    <option value="available" {{ old('status', $reagent?->status ?? 'available') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="in_use" {{ old('status', $reagent?->status) == 'in_use' ? 'selected' : '' }}>Digunakan</option>
                    <option value="low_stock" {{ old('status', $reagent?->status) == 'low_stock' ? 'selected' : '' }}>Stok Rendah</option>
                    <option value="expired" {{ old('status', $reagent?->status) == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                    <option value="disposed" {{ old('status', $reagent?->status) == 'disposed' ? 'selected' : '' }}>Dibuang</option>
                </x-select>
                @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </x-card>

    <x-card title="Stok & Penyimpanan">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div><x-label for="quantity">Jumlah <span class="text-red-500">*</span></x-label><x-input id="quantity" type="number" name="quantity" value="{{ old('quantity', $reagent?->quantity) }}" step="0.01" required />@error('quantity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div><x-label for="unit">Satuan <span class="text-red-500">*</span></x-label><x-input id="unit" name="unit" value="{{ old('unit', $reagent?->unit) }}" placeholder="mL, L, g, kg" required />@error('unit')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div><x-label for="min_stock_level">Min. Stok Alert</x-label><x-input id="min_stock_level" type="number" name="min_stock_level" value="{{ old('min_stock_level', $reagent?->min_stock_level) }}" step="0.01" />@error('min_stock_level')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div><x-label for="storage_location">Lokasi Penyimpanan</x-label><x-input id="storage_location" name="storage_location" value="{{ old('storage_location', $reagent?->storage_location) }}" />@error('storage_location')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div>
                <x-label for="storage_condition">Kondisi Penyimpanan <span class="text-red-500">*</span></x-label>
                <x-select id="storage_condition" name="storage_condition" placeholder="Pilih kondisi" required>
                    <option value="room_temperature" {{ old('storage_condition', $reagent?->storage_condition ?? 'room_temperature') == 'room_temperature' ? 'selected' : '' }}>Suhu Ruang</option>
                    <option value="refrigerated" {{ old('storage_condition', $reagent?->storage_condition) == 'refrigerated' ? 'selected' : '' }}>Didinginkan (2-8°C)</option>
                    <option value="frozen" {{ old('storage_condition', $reagent?->storage_condition) == 'frozen' ? 'selected' : '' }}>Dibekukan (-20°C)</option>
                    <option value="special" {{ old('storage_condition', $reagent?->storage_condition) == 'special' ? 'selected' : '' }}>Kondisi Khusus</option>
                </x-select>
                @error('storage_condition')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </x-card>

    <x-card title="Keamanan">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="hazard_class">Kelas Bahaya <span class="text-red-500">*</span></x-label>
                <x-select id="hazard_class" name="hazard_class" required>
                    <option value="non_hazardous" {{ old('hazard_class', $reagent?->hazard_class ?? 'non_hazardous') == 'non_hazardous' ? 'selected' : '' }}>Tidak Berbahaya</option>
                    <option value="flammable" {{ old('hazard_class', $reagent?->hazard_class) == 'flammable' ? 'selected' : '' }}>Mudah Terbakar</option>
                    <option value="corrosive" {{ old('hazard_class', $reagent?->hazard_class) == 'corrosive' ? 'selected' : '' }}>Korosif</option>
                    <option value="toxic" {{ old('hazard_class', $reagent?->hazard_class) == 'toxic' ? 'selected' : '' }}>Beracun</option>
                    <option value="oxidizing" {{ old('hazard_class', $reagent?->hazard_class) == 'oxidizing' ? 'selected' : '' }}>Oksidator</option>
                    <option value="explosive" {{ old('hazard_class', $reagent?->hazard_class) == 'explosive' ? 'selected' : '' }}>Eksplosif</option>
                    <option value="radioactive" {{ old('hazard_class', $reagent?->hazard_class) == 'radioactive' ? 'selected' : '' }}>Radioaktif</option>
                </x-select>
                @error('hazard_class')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div><x-label for="sds_file">Safety Data Sheet (PDF)</x-label><input type="file" id="sds_file" name="sds_file" accept=".pdf" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-900" />@if(isset($reagent) && $reagent->sds_file)<p class="text-sm text-gray-500 mt-2"><i class="fa fa-file-pdf text-red-500 mr-1"></i>{{ basename($reagent->sds_file) }}</p>@endif @error('sds_file')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
        </div>
        <div class="mt-4"><x-label for="safety_notes">Catatan Keamanan</x-label><x-textarea id="safety_notes" name="safety_notes" rows="2">{{ old('safety_notes', $reagent?->safety_notes) }}</x-textarea>@error('safety_notes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
    </x-card>

    <x-card title="Info Pembelian">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><x-label for="manufacturer">Produsen</x-label><x-input id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $reagent?->manufacturer) }}" />@error('manufacturer')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div><x-label for="lot_number">Lot/Batch Number</x-label><x-input id="lot_number" name="lot_number" value="{{ old('lot_number', $reagent?->lot_number) }}" />@error('lot_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div><x-label for="purchase_date">Tgl Pembelian</x-label><x-input id="purchase_date" type="date" name="purchase_date" value="{{ old('purchase_date', $reagent?->purchase_date?->format('Y-m-d')) }}" />@error('purchase_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div><x-label for="opened_date">Tgl Dibuka</x-label><x-input id="opened_date" type="date" name="opened_date" value="{{ old('opened_date', $reagent?->opened_date?->format('Y-m-d')) }}" />@error('opened_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div><x-label for="expiry_date">Tgl Kadaluarsa</x-label><x-input id="expiry_date" type="date" name="expiry_date" value="{{ old('expiry_date', $reagent?->expiry_date?->format('Y-m-d')) }}" />@error('expiry_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
        </div>
        <div class="mt-4"><x-label for="notes">Catatan</x-label><x-textarea id="notes" name="notes" rows="2">{{ old('notes', $reagent?->notes) }}</x-textarea>@error('notes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
    </x-card>

    <div class="flex gap-3">
        <x-button type="submit" variant="primary"><i class="fa fa-save mr-2"></i>{{ isset($reagent) && $reagent->exists ? 'Perbarui' : 'Simpan' }}</x-button>
        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('reagents.index') }}'">Batal</x-button>
    </div>
</div>
