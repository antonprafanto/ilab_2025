{{-- Basic Information --}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Laboratory --}}
            <div class="md:col-span-2">
                <x-input-label for="laboratory_id" :value="__('Laboratorium')" required />
                <select id="laboratory_id"
                    name="laboratory_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                    <option value="">Pilih Laboratorium</option>
                    @foreach($laboratories as $lab)
                        <option value="{{ $lab->id }}" {{ old('laboratory_id', $service->laboratory_id ?? '') == $lab->id ? 'selected' : '' }}>
                            {{ $lab->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('laboratory_id')" class="mt-2" />
            </div>

            {{-- Code --}}
            <div>
                <x-input-label for="code" :value="__('Kode Layanan')" required />
                <x-text-input id="code"
                    name="code"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('code', $service->code ?? '')"
                    placeholder="SVC-CHEM-001"
                    required />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            {{-- Name --}}
            <div>
                <x-input-label for="name" :value="__('Nama Layanan')" required />
                <x-text-input id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('name', $service->name ?? '')"
                    placeholder="Analisis GC-MS"
                    required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Description --}}
            <div class="md:col-span-2">
                <x-input-label for="description" :value="__('Deskripsi')" />
                <textarea id="description"
                    name="description"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Deskripsi detail tentang layanan ini...">{{ old('description', $service->description ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
        </div>
    </div>
</div>

{{-- Categorization --}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategori & Metode</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Category --}}
            <div>
                <x-input-label for="category" :value="__('Kategori')" required />
                <select id="category"
                    name="category"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                    <option value="">Pilih Kategori</option>
                    <option value="kimia" {{ old('category', $service->category ?? '') == 'kimia' ? 'selected' : '' }}>Kimia</option>
                    <option value="biologi" {{ old('category', $service->category ?? '') == 'biologi' ? 'selected' : '' }}>Biologi</option>
                    <option value="fisika" {{ old('category', $service->category ?? '') == 'fisika' ? 'selected' : '' }}>Fisika</option>
                    <option value="mikrobiologi" {{ old('category', $service->category ?? '') == 'mikrobiologi' ? 'selected' : '' }}>Mikrobiologi</option>
                    <option value="material" {{ old('category', $service->category ?? '') == 'material' ? 'selected' : '' }}>Material</option>
                    <option value="lingkungan" {{ old('category', $service->category ?? '') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                    <option value="pangan" {{ old('category', $service->category ?? '') == 'pangan' ? 'selected' : '' }}>Pangan</option>
                    <option value="farmasi" {{ old('category', $service->category ?? '') == 'farmasi' ? 'selected' : '' }}>Farmasi</option>
                </select>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>

            {{-- Subcategory --}}
            <div>
                <x-input-label for="subcategory" :value="__('Sub-kategori')" />
                <x-text-input id="subcategory"
                    name="subcategory"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('subcategory', $service->subcategory ?? '')"
                    placeholder="Analisis Organik" />
                <x-input-error :messages="$errors->get('subcategory')" class="mt-2" />
            </div>

            {{-- Method --}}
            <div class="md:col-span-2">
                <x-input-label for="method" :value="__('Metode')" />
                <x-text-input id="method"
                    name="method"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('method', $service->method ?? '')"
                    placeholder="ISO 17025, SNI 2354, AOAC" />
                <x-input-error :messages="$errors->get('method')" class="mt-2" />
            </div>
        </div>
    </div>
</div>

{{-- Duration & Pricing --}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Durasi & Harga</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Duration --}}
            <div>
                <x-input-label for="duration_days" :value="__('Durasi (hari kerja)')" required />
                <x-text-input id="duration_days"
                    name="duration_days"
                    type="number"
                    class="mt-1 block w-full"
                    :value="old('duration_days', $service->duration_days ?? 3)"
                    min="1"
                    required />
                <x-input-error :messages="$errors->get('duration_days')" class="mt-2" />
            </div>

            {{-- Urgent Surcharge --}}
            <div>
                <x-input-label for="urgent_surcharge_percent" :value="__('Biaya Urgent (%)')" />
                <x-text-input id="urgent_surcharge_percent"
                    name="urgent_surcharge_percent"
                    type="number"
                    class="mt-1 block w-full"
                    :value="old('urgent_surcharge_percent', $service->urgent_surcharge_percent ?? 50)"
                    min="0"
                    max="100" />
                <x-input-error :messages="$errors->get('urgent_surcharge_percent')" class="mt-2" />
            </div>

            {{-- Price Internal --}}
            <div>
                <x-input-label for="price_internal" :value="__('Harga Internal (Rp)')" required />
                <x-text-input id="price_internal"
                    name="price_internal"
                    type="number"
                    class="mt-1 block w-full"
                    :value="old('price_internal', $service->price_internal ?? '')"
                    step="0.01"
                    min="0"
                    placeholder="100000"
                    required />
                <p class="text-xs text-gray-500 mt-1">Untuk mahasiswa/dosen UNMUL</p>
                <x-input-error :messages="$errors->get('price_internal')" class="mt-2" />
            </div>

            {{-- Price External Edu --}}
            <div>
                <x-input-label for="price_external_edu" :value="__('Harga External Edu (Rp)')" required />
                <x-text-input id="price_external_edu"
                    name="price_external_edu"
                    type="number"
                    class="mt-1 block w-full"
                    :value="old('price_external_edu', $service->price_external_edu ?? '')"
                    step="0.01"
                    min="0"
                    placeholder="150000"
                    required />
                <p class="text-xs text-gray-500 mt-1">Untuk universitas lain</p>
                <x-input-error :messages="$errors->get('price_external_edu')" class="mt-2" />
            </div>

            {{-- Price External --}}
            <div class="md:col-span-2">
                <x-input-label for="price_external" :value="__('Harga External (Rp)')" required />
                <x-text-input id="price_external"
                    name="price_external"
                    type="number"
                    class="mt-1 block w-full"
                    :value="old('price_external', $service->price_external ?? '')"
                    step="0.01"
                    min="0"
                    placeholder="200000"
                    required />
                <p class="text-xs text-gray-500 mt-1">Untuk industri/umum</p>
                <x-input-error :messages="$errors->get('price_external')" class="mt-2" />
            </div>
        </div>
    </div>
</div>

{{-- Requirements & Deliverables --}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Persyaratan & Hasil</h3>

        <div class="space-y-6">
            {{-- Requirements --}}
            <div>
                <x-input-label for="requirements" :value="__('Persyaratan (satu per baris)')" />
                <textarea id="requirements"
                    name="requirements"
                    rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Sampel minimal 50g&#10;Form permohonan sudah diisi&#10;Surat pengantar dari institusi">{{ old('requirements') ? implode("\n", old('requirements')) : (isset($service->requirements) && is_array($service->requirements) ? implode("\n", $service->requirements) : '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Masukkan setiap persyaratan pada baris baru</p>
                <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
            </div>

            {{-- Equipment Needed --}}
            <div>
                <x-input-label for="equipment_needed" :value="__('Equipment IDs (dipisah koma)')" />
                <x-text-input id="equipment_needed"
                    name="equipment_needed"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('equipment_needed') ? (is_array(old('equipment_needed')) ? implode(',', old('equipment_needed')) : old('equipment_needed')) : (isset($service->equipment_needed) && is_array($service->equipment_needed) ? implode(',', $service->equipment_needed) : '')"
                    placeholder="1,5,8,12" />
                <p class="text-xs text-gray-500 mt-1">Masukkan ID equipment yang dibutuhkan, dipisah koma</p>
                <x-input-error :messages="$errors->get('equipment_needed')" class="mt-2" />
            </div>

            {{-- Sample Preparation --}}
            <div>
                <x-input-label for="sample_preparation" :value="__('Preparasi Sampel')" />
                <textarea id="sample_preparation"
                    name="sample_preparation"
                    rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Instruksi preparasi sampel...">{{ old('sample_preparation', $service->sample_preparation ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('sample_preparation')" class="mt-2" />
            </div>

            {{-- Deliverables --}}
            <div>
                <x-input-label for="deliverables" :value="__('Hasil yang Diterima (satu per baris)')" />
                <textarea id="deliverables"
                    name="deliverables"
                    rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Laporan PDF&#10;Raw data Excel&#10;Sertifikat analisis">{{ old('deliverables') ? implode("\n", old('deliverables')) : (isset($service->deliverables) && is_array($service->deliverables) ? implode("\n", $service->deliverables) : '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Masukkan setiap deliverable pada baris baru</p>
                <x-input-error :messages="$errors->get('deliverables')" class="mt-2" />
            </div>
        </div>
    </div>
</div>

{{-- Sample Limits --}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Batas Sampel</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Min Sample --}}
            <div>
                <x-input-label for="min_sample" :value="__('Jumlah Minimal Sampel')" />
                <x-text-input id="min_sample"
                    name="min_sample"
                    type="number"
                    class="mt-1 block w-full"
                    :value="old('min_sample', $service->min_sample ?? '')"
                    min="1"
                    placeholder="1" />
                <x-input-error :messages="$errors->get('min_sample')" class="mt-2" />
            </div>

            {{-- Max Sample --}}
            <div>
                <x-input-label for="max_sample" :value="__('Maksimal Sampel per Batch')" />
                <x-text-input id="max_sample"
                    name="max_sample"
                    type="number"
                    class="mt-1 block w-full"
                    :value="old('max_sample', $service->max_sample ?? '')"
                    min="1"
                    placeholder="10" />
                <x-input-error :messages="$errors->get('max_sample')" class="mt-2" />
            </div>
        </div>
    </div>
</div>

{{-- Status --}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>

        <div class="flex items-center">
            <input id="is_active"
                name="is_active"
                type="checkbox"
                value="1"
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
            <label for="is_active" class="ml-2 text-sm text-gray-700">Layanan Aktif</label>
        </div>
        <p class="text-xs text-gray-500 mt-1">Hanya layanan aktif yang ditampilkan di katalog</p>
        <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
    </div>
</div>

{{-- Action Buttons --}}
<div class="flex items-center justify-end gap-4">
    <a href="{{ route('services.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Batal
    </a>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-save mr-2"></i>Simpan
    </button>
</div>

<script>
// Convert textarea inputs to arrays before submit
document.querySelector('form').addEventListener('submit', function(e) {
    // Requirements
    const requirementsTextarea = document.getElementById('requirements');
    if (requirementsTextarea.value.trim()) {
        const lines = requirementsTextarea.value.split('\n').filter(line => line.trim());
        requirementsTextarea.value = JSON.stringify(lines);
    }

    // Deliverables
    const deliverablesTextarea = document.getElementById('deliverables');
    if (deliverablesTextarea.value.trim()) {
        const lines = deliverablesTextarea.value.split('\n').filter(line => line.trim());
        deliverablesTextarea.value = JSON.stringify(lines);
    }

    // Equipment Needed
    const equipmentInput = document.getElementById('equipment_needed');
    if (equipmentInput.value.trim()) {
        const ids = equipmentInput.value.split(',').map(id => parseInt(id.trim())).filter(id => !isNaN(id));
        equipmentInput.value = JSON.stringify(ids);
    }
});
</script>
