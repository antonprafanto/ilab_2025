<div class="space-y-6">
    <x-card title="Informasi Dasar">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="calibration_code">Kode Kalibrasi <span class="text-red-500">*</span></x-label>
                <x-input id="calibration_code" name="calibration_code" value="{{ old('calibration_code', $calibration->calibration_code ?? '') }}" required />
                @error('calibration_code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <x-label for="equipment_id">Equipment <span class="text-red-500">*</span></x-label>
                <x-select id="equipment_id" name="equipment_id" placeholder="Pilih equipment" required>
                    @foreach($equipments as $eq)
                        <option value="{{ $eq->id }}" {{ old('equipment_id', $calibration->equipment_id ?? $selectedEquipment?->id) == $eq->id ? 'selected' : '' }}>
                            {{ $eq->name }}
                        </option>
                    @endforeach
                </x-select>
                @error('equipment_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <x-label for="type">Tipe <span class="text-red-500">*</span></x-label>
                <x-select id="type" name="type" required>
                    <option value="internal" {{ old('type', $calibration->type ?? '') == 'internal' ? 'selected' : '' }}>Kalibrasi Internal</option>
                    <option value="external" {{ old('type', $calibration->type ?? '') == 'external' ? 'selected' : '' }}>Kalibrasi Eksternal</option>
                    <option value="verification" {{ old('type', $calibration->type ?? '') == 'verification' ? 'selected' : '' }}>Verifikasi</option>
                    <option value="adjustment" {{ old('type', $calibration->type ?? '') == 'adjustment' ? 'selected' : '' }}>Penyesuaian</option>
                </x-select>
            </div>
            <div>
                <x-label for="status">Status <span class="text-red-500">*</span></x-label>
                <x-select id="status" name="status" required>
                    <option value="scheduled" {{ old('status', $calibration->status ?? 'scheduled') == 'scheduled' ? 'selected' : '' }}>Dijadwalkan</option>
                    <option value="in_progress" {{ old('status', $calibration->status ?? '') == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="passed" {{ old('status', $calibration->status ?? '') == 'passed' ? 'selected' : '' }}>Lulus</option>
                    <option value="failed" {{ old('status', $calibration->status ?? '') == 'failed' ? 'selected' : '' }}>Tidak Lulus</option>
                    <option value="conditional" {{ old('status', $calibration->status ?? '') == 'conditional' ? 'selected' : '' }}>Lulus Bersyarat</option>
                </x-select>
            </div>
            <div>
                <x-label for="result">Hasil</x-label>
                <x-select id="result" name="result">
                    <option value="">-</option>
                    <option value="pass" {{ old('result', $calibration->result ?? '') == 'pass' ? 'selected' : '' }}>Lulus</option>
                    <option value="fail" {{ old('result', $calibration->result ?? '') == 'fail' ? 'selected' : '' }}>Tidak Lulus</option>
                    <option value="conditional" {{ old('result', $calibration->result ?? '') == 'conditional' ? 'selected' : '' }}>Lulus Bersyarat</option>
                </x-select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-label for="calibration_date">Tanggal Kalibrasi <span class="text-red-500">*</span></x-label>
                <x-input id="calibration_date" type="date" name="calibration_date" value="{{ old('calibration_date', $calibration?->calibration_date?->format('Y-m-d')) }}" required />
            </div>
            <div>
                <x-label for="due_date">Tanggal Jatuh Tempo</x-label>
                <x-input id="due_date" type="date" name="due_date" value="{{ old('due_date', $calibration?->due_date?->format('Y-m-d')) }}" />
            </div>
        </div>
    </x-card>

    <x-card title="Hasil Kalibrasi">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-label for="accuracy">Akurasi</x-label>
                <x-input id="accuracy" name="accuracy" value="{{ old('accuracy', $calibration->accuracy ?? '') }}" placeholder="±0.01g" />
            </div>
            <div>
                <x-label for="uncertainty">Ketidakpastian</x-label>
                <x-input id="uncertainty" name="uncertainty" value="{{ old('uncertainty', $calibration->uncertainty ?? '') }}" />
            </div>
            <div>
                <x-label for="range_calibrated">Rentang Kalibrasi</x-label>
                <x-input id="range_calibrated" name="range_calibrated" value="{{ old('range_calibrated', $calibration->range_calibrated ?? '') }}" />
            </div>
        </div>
        <div class="mt-4">
            <x-label for="measurement_results">Hasil Pengukuran</x-label>
            <x-textarea id="measurement_results" name="measurement_results" rows="3" :value="old('measurement_results', $calibration->measurement_results ?? '')" />
        </div>
    </x-card>

    <x-card title="Sertifikat (Untuk Kalibrasi Eksternal)">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="external_lab">Lab Eksternal</x-label>
                <x-input id="external_lab" name="external_lab" value="{{ old('external_lab', $calibration->external_lab ?? '') }}" />
            </div>
            <div>
                <x-label for="certificate_number">Nomor Sertifikat</x-label>
                <x-input id="certificate_number" name="certificate_number" value="{{ old('certificate_number', $calibration->certificate_number ?? '') }}" />
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-label for="certificate_issue_date">Tanggal Terbit</x-label>
                <x-input id="certificate_issue_date" type="date" name="certificate_issue_date" value="{{ old('certificate_issue_date', $calibration?->certificate_issue_date?->format('Y-m-d')) }}" />
            </div>
            <div>
                <x-label for="certificate_expiry_date">Tanggal Kadaluarsa</x-label>
                <x-input id="certificate_expiry_date" type="date" name="certificate_expiry_date" value="{{ old('certificate_expiry_date', $calibration?->certificate_expiry_date?->format('Y-m-d')) }}" />
            </div>
        </div>
        <div class="mt-4">
            <x-label for="certificate_file">File Sertifikat (PDF, Max 10MB)</x-label>
            <input type="file" id="certificate_file" name="certificate_file" accept=".pdf" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-900" />
            @if(isset($calibration) && $calibration->certificate_file)
                <p class="text-sm text-gray-500 mt-2"><i class="fa fa-file-pdf text-red-500 mr-1"></i> File saat ini: {{ basename($calibration->certificate_file) }}</p>
            @endif
        </div>
    </x-card>

    <x-card title="Personel">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="calibrated_by">Kalibrator</x-label>
                <x-select id="calibrated_by" name="calibrated_by" placeholder="Pilih kalibrator">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('calibrated_by', $calibration->calibrated_by ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <div>
                <x-label for="verified_by">Verifikator</x-label>
                <x-select id="verified_by" name="verified_by" placeholder="Pilih verifikator">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('verified_by', $calibration->verified_by ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </x-select>
            </div>
        </div>
    </x-card>

    <div class="flex gap-3">
        <x-button type="submit" variant="primary"><i class="fa fa-save mr-2"></i>{{ isset($calibration) && $calibration->exists ? 'Perbarui' : 'Simpan' }}</x-button>
        <x-button type="button" variant="ghost" onclick="window.location.href='{{ route('calibration.index') }}'">Batal</x-button>
    </div>
</div>
