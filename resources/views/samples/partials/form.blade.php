<div class="space-y-6">
    <x-card title="Informasi Dasar">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="code">Kode Sampel <span class="text-red-500">*</span></x-label>
                <x-input id="code" name="code" value="{{ old('code', $sample?->code) }}" required />
                @error('code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <x-label for="name">Nama Sampel <span class="text-red-500">*</span></x-label>
                <x-input id="name" name="name" value="{{ old('name', $sample?->name) }}" required />
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <x-label for="laboratory_id">Laboratorium <span class="text-red-500">*</span></x-label>
                <x-select id="laboratory_id" name="laboratory_id" placeholder="Pilih laboratorium" required>
                    @foreach($laboratories as $lab)
                        <option value="{{ $lab->id }}" {{ old('laboratory_id', $sample?->laboratory_id) == $lab->id ? 'selected' : '' }}>{{ $lab->name }}</option>
                    @endforeach
                </x-select>
                @error('laboratory_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <x-label for="type">Tipe Sampel <span class="text-red-500">*</span></x-label>
                <x-select id="type" name="type" required>
                    <option value="biological" {{ old('type', $sample?->type) == 'biological' ? 'selected' : '' }}>Biologis</option>
                    <option value="chemical" {{ old('type', $sample?->type) == 'chemical' ? 'selected' : '' }}>Kimia</option>
                    <option value="environmental" {{ old('type', $sample?->type) == 'environmental' ? 'selected' : '' }}>Lingkungan</option>
                    <option value="food" {{ old('type', $sample?->type) == 'food' ? 'selected' : '' }}>Pangan</option>
                    <option value="pharmaceutical" {{ old('type', $sample?->type) == 'pharmaceutical' ? 'selected' : '' }}>Farmasi</option>
                    <option value="other" {{ old('type', $sample?->type) == 'other' ? 'selected' : '' }}>Lainnya</option>
                </x-select>
                @error('type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <x-label for="status">Status <span class="text-red-500">*</span></x-label>
                <x-select id="status" name="status" required>
                    <option value="received" {{ old('status', $sample?->status ?? 'received') == 'received' ? 'selected' : '' }}>Diterima</option>
                    <option value="in_analysis" {{ old('status', $sample?->status) == 'in_analysis' ? 'selected' : '' }}>Dalam Analisis</option>
                    <option value="completed" {{ old('status', $sample?->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="archived" {{ old('status', $sample?->status) == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                    <option value="disposed" {{ old('status', $sample?->status) == 'disposed' ? 'selected' : '' }}>Dibuang</option>
                </x-select>
                @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-label for="source">Sumber Sampel</x-label>
                <x-input id="source" name="source" value="{{ old('source', $sample?->source) }}" />
                @error('source')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <x-label for="priority">Prioritas <span class="text-red-500">*</span></x-label>
                <x-select id="priority" name="priority" required>
                    <option value="low" {{ old('priority', $sample?->priority) == 'low' ? 'selected' : '' }}>Rendah</option>
                    <option value="normal" {{ old('priority', $sample?->priority ?? 'normal') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="high" {{ old('priority', $sample?->priority) == 'high' ? 'selected' : '' }}>Tinggi</option>
                    <option value="urgent" {{ old('priority', $sample?->priority) == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                </x-select>
                @error('priority')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="mt-4">
            <x-label for="description">Deskripsi</x-label>
            <x-textarea id="description" name="description" rows="2" :value="old('description', $sample?->description ?? '')" />
            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
    </x-card>

    <x-card title="Penyimpanan & Tanggal">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="storage_location">Lokasi Penyimpanan</x-label>
                <x-input id="storage_location" name="storage_location" value="{{ old('storage_location', $sample?->storage_location) }}" />
                @error('storage_location')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <x-label for="storage_condition">Kondisi Penyimpanan <span class="text-red-500">*</span></x-label>
                <x-select id="storage_condition" name="storage_condition" required>
                    <option value="room_temperature" {{ old('storage_condition', $sample?->storage_condition ?? 'room_temperature') == 'room_temperature' ? 'selected' : '' }}>Suhu Ruang</option>
                    <option value="refrigerated" {{ old('storage_condition', $sample?->storage_condition) == 'refrigerated' ? 'selected' : '' }}>Didinginkan (2-8°C)</option>
                    <option value="frozen" {{ old('storage_condition', $sample?->storage_condition) == 'frozen' ? 'selected' : '' }}>Dibekukan (-20°C)</option>
                    <option value="special" {{ old('storage_condition', $sample?->storage_condition) == 'special' ? 'selected' : '' }}>Kondisi Khusus</option>
                </x-select>
                @error('storage_condition')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <x-label for="received_date">Tanggal Diterima <span class="text-red-500">*</span></x-label>
                <x-input id="received_date" type="date" name="received_date" value="{{ old('received_date', $sample?->received_date?->format('Y-m-d')) }}" required />
                @error('received_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <x-label for="expiry_date">Tanggal Kadaluarsa</x-label>
                <x-input id="expiry_date" type="date" name="expiry_date" value="{{ old('expiry_date', $sample?->expiry_date?->format('Y-m-d')) }}" />
                @error('expiry_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <x-label for="quantity">Jumlah</x-label>
                <div class="flex gap-2">
                    <x-input id="quantity" type="number" name="quantity" value="{{ old('quantity', $sample?->quantity) }}" step="0.01" class="flex-1" />
                    <x-input id="unit" name="unit" value="{{ old('unit', $sample?->unit) }}" placeholder="mL, g, unit" class="w-24" />
                </div>
                @error('quantity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </x-card>

    <x-card title="Personel & Analisis">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="submitted_by">Diserahkan Oleh <span class="text-red-500">*</span></x-label>
                <x-select id="submitted_by" name="submitted_by" required>
                    <option value="">Pilih user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('submitted_by', $sample?->submitted_by) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </x-select>
                @error('submitted_by')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <x-label for="analyzed_by">Dianalisis Oleh</x-label>
                <x-select id="analyzed_by" name="analyzed_by">
                    <option value="">Pilih user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('analyzed_by', $sample?->analyzed_by) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </x-select>
                @error('analyzed_by')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-label for="analysis_date">Tanggal Analisis</x-label>
                <x-input id="analysis_date" type="date" name="analysis_date" value="{{ old('analysis_date', $sample?->analysis_date?->format('Y-m-d')) }}" />
                @error('analysis_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <x-label for="result_date">Tanggal Hasil</x-label>
                <x-input id="result_date" type="date" name="result_date" value="{{ old('result_date', $sample?->result_date?->format('Y-m-d')) }}" />
                @error('result_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="mt-4">
            <x-label for="test_parameters">Parameter yang Diuji</x-label>
            <x-textarea id="test_parameters" name="test_parameters" rows="2" :value="old('test_parameters', $sample?->test_parameters ?? '')" />
            @error('test_parameters')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mt-4">
            <x-label for="analysis_results">Hasil Analisis</x-label>
            <x-textarea id="analysis_results" name="analysis_results" rows="3" :value="old('analysis_results', $sample?->analysis_results ?? '')" />
            @error('analysis_results')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mt-4">
            <x-label for="result_file">File Hasil (PDF/DOC, Max 10MB)</x-label>
            <input type="file" id="result_file" name="result_file" accept=".pdf,.doc,.docx" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-900" />
            @if(isset($sample) && $sample->result_file)
                <p class="text-sm text-gray-500 mt-2"><i class="fa fa-file mr-1"></i>File saat ini: {{ basename($sample->result_file) }}</p>
            @endif
            @error('result_file')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
    </x-card>

    <x-card title="Catatan Tambahan">
        <div>
            <x-label for="special_requirements">Persyaratan Khusus</x-label>
            <x-textarea id="special_requirements" name="special_requirements" rows="2" :value="old('special_requirements', $sample?->special_requirements ?? '')" />
            @error('special_requirements')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mt-4">
            <x-label for="notes">Catatan</x-label>
            <x-textarea id="notes" name="notes" rows="2" :value="old('notes', $sample?->notes ?? '')" />
            @error('notes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
    </x-card>

    <div class="flex gap-3">
        <x-button type="submit" variant="primary">
            <i class="fa fa-save mr-2"></i>
            {{ isset($sample) && $sample->exists ? 'Perbarui Sampel' : 'Simpan Sampel' }}
        </x-button>
        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('samples.index') }}'">Batal</x-button>
    </div>
</div>
