<div class="space-y-6">
    {{-- Informasi Dasar --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Informasi Dasar
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                label="Kode SOP"
                name="code"
                :value="old('code', $sop->code ?? '')"
                placeholder="SOP-LAB-001"
                required="true"
                hint="Format: SOP-XXX-001"
                :error="$errors->first('code')"
            />

            <x-input
                label="Versi"
                name="version"
                :value="old('version', $sop->version ?? '1.0')"
                placeholder="1.0"
                :error="$errors->first('version')"
            />

            <div class="md:col-span-2">
                <x-input
                    label="Judul SOP"
                    name="title"
                    :value="old('title', $sop->title ?? '')"
                    placeholder="Prosedur Penggunaan FTIR Spectrometer"
                    required="true"
                    :error="$errors->first('title')"
                />
            </div>

            <x-select
                label="Kategori"
                name="category"
                :options="[
                    'equipment' => 'Penggunaan Alat',
                    'testing' => 'Pengujian',
                    'safety' => 'Keselamatan',
                    'quality' => 'Mutu/Kualitas',
                    'maintenance' => 'Pemeliharaan',
                    'calibration' => 'Kalibrasi',
                    'general' => 'Umum'
                ]"
                :value="old('category', $sop->category ?? '')"
                placeholder="Pilih kategori"
                required="true"
                :error="$errors->first('category')"
            />

            <x-select
                label="Laboratorium"
                name="laboratory_id"
                :options="$laboratories->pluck('name', 'id')->toArray()"
                :value="old('laboratory_id', $sop->laboratory_id ?? '')"
                placeholder="Pilih laboratorium (opsional)"
                :error="$errors->first('laboratory_id')"
            />

            <x-select
                label="Status"
                name="status"
                :options="[
                    'draft' => 'Draft',
                    'review' => 'Dalam Review',
                    'approved' => 'Disetujui',
                    'archived' => 'Diarsipkan'
                ]"
                :value="old('status', $sop->status ?? 'draft')"
                required="true"
                :error="$errors->first('status')"
            />

            <x-input
                type="number"
                label="Interval Review (bulan)"
                name="review_interval_months"
                :value="old('review_interval_months', $sop->review_interval_months ?? '12')"
                placeholder="12"
                hint="Contoh: 12 bulan (1 tahun)"
                :error="$errors->first('review_interval_months')"
            />
        </div>
    </div>

    {{-- Konten SOP --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Konten SOP
        </h3>

        <div class="space-y-4">
            <x-textarea
                label="Tujuan (Purpose)"
                name="purpose"
                :value="old('purpose', $sop->purpose ?? '')"
                placeholder="Tujuan dari SOP ini..."
                rows="3"
                :error="$errors->first('purpose')"
            />

            <x-textarea
                label="Ruang Lingkup (Scope)"
                name="scope"
                :value="old('scope', $sop->scope ?? '')"
                placeholder="Ruang lingkup penerapan SOP..."
                rows="3"
                :error="$errors->first('scope')"
            />

            <x-textarea
                label="Deskripsi Prosedur"
                name="description"
                :value="old('description', $sop->description ?? '')"
                placeholder="Deskripsi detail prosedur..."
                rows="4"
                :error="$errors->first('description')"
            />

            <x-textarea
                label="Persyaratan (Requirements)"
                name="requirements"
                :value="old('requirements', $sop->requirements ?? '')"
                placeholder="Persyaratan atau prerequisites..."
                rows="3"
                :error="$errors->first('requirements')"
            />

            <x-textarea
                label="Tindakan Pencegahan Keselamatan"
                name="safety_precautions"
                :value="old('safety_precautions', $sop->safety_precautions ?? '')"
                placeholder="Tindakan keselamatan yang harus diperhatikan..."
                rows="3"
                :error="$errors->first('safety_precautions')"
            />

            <x-textarea
                label="Referensi"
                name="references"
                :value="old('references', $sop->references ?? '')"
                placeholder="Referensi atau dokumen terkait..."
                rows="2"
                :error="$errors->first('references')"
            />
        </div>
    </div>

    {{-- File Upload --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Dokumen SOP
        </h3>

        <x-file-upload
            label="File PDF SOP"
            name="document_file"
            accept="application/pdf"
            hint="Format: PDF. Max: 10MB"
            :error="$errors->first('document_file')"
        />

        @if(isset($sop) && $sop->document_file)
            <div class="mt-4">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dokumen Saat Ini:</p>
                <a href="{{ $sop->document_url }}" target="_blank"
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    <i class="fa fa-file-pdf mr-2"></i>
                    {{ basename($sop->document_file) }}
                </a>
            </div>
        @endif
    </div>

    {{-- Approval Workflow --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Persetujuan & Review
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select
                label="Disiapkan Oleh"
                name="prepared_by"
                :options="$users->pluck('name', 'id')->toArray()"
                :value="old('prepared_by', $sop->prepared_by ?? auth()->id())"
                placeholder="Pilih pembuat"
                :error="$errors->first('prepared_by')"
            />

            <x-select
                label="Direview Oleh"
                name="reviewed_by"
                :options="$users->pluck('name', 'id')->toArray()"
                :value="old('reviewed_by', $sop->reviewed_by ?? '')"
                placeholder="Pilih reviewer (opsional)"
                :error="$errors->first('reviewed_by')"
            />

            <x-select
                label="Disetujui Oleh"
                name="approved_by"
                :options="$users->pluck('name', 'id')->toArray()"
                :value="old('approved_by', $sop->approved_by ?? '')"
                placeholder="Pilih approver (opsional)"
                :error="$errors->first('approved_by')"
            />

            <x-input
                type="date"
                label="Tanggal Efektif"
                name="effective_date"
                :value="old('effective_date', isset($sop) && $sop->effective_date ? $sop->effective_date->format('Y-m-d') : '')"
                :error="$errors->first('effective_date')"
            />
        </div>

        <div class="mt-4">
            <x-textarea
                label="Catatan Revisi"
                name="revision_notes"
                :value="old('revision_notes', $sop->revision_notes ?? '')"
                placeholder="Catatan perubahan atau revisi..."
                rows="3"
                :error="$errors->first('revision_notes')"
            />
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
        <x-button type="button" variant="ghost" onclick="window.history.back()">
            Batal
        </x-button>
        <x-button type="submit" variant="primary">
            <i class="fa fa-save mr-2"></i>
            {{ isset($sop) && $sop->id ? 'Update SOP' : 'Simpan SOP' }}
        </x-button>
    </div>
</div>
