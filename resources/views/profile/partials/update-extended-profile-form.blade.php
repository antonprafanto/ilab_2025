<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profile Lengkap') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Lengkapi informasi profile Anda untuk meningkatkan kredibilitas dan memudahkan kolaborasi.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update.extended') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf

        <!-- Avatar Upload -->
        <div>
            <x-input-label for="avatar" value="Foto Profile" />
            <div class="mt-2 flex items-center space-x-6">
                <div class="shrink-0">
                    <img id="avatar-preview"
                         class="h-24 w-24 object-cover rounded-full ring-4 ring-[--color-unmul-blue]"
                         src="{{ auth()->user()->avatar_url }}"
                         alt="Avatar">
                </div>
                <div class="flex-1">
                    <input type="file"
                           id="avatar"
                           name="avatar"
                           accept="image/*"
                           class="block w-full text-sm text-gray-900 dark:text-gray-100
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-[--color-unmul-blue] file:text-white
                                  hover:file:bg-[--color-tropical-green]
                                  cursor-pointer">
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <!-- Academic Title -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="title" value="Gelar Depan" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                              :value="old('title', $user->profile?->title)"
                              placeholder="Dr., Prof., H., Hj., dll" />
                <p class="mt-1 text-xs text-gray-500">Gelar kehormatan/akademik yang ditulis di depan nama</p>
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <div>
                <x-input-label for="academic_degree" value="Gelar Belakang" />
                <x-text-input id="academic_degree" name="academic_degree" type="text" class="mt-1 block w-full"
                              :value="old('academic_degree', $user->profile?->academic_degree)"
                              placeholder="S.Kom., M.T., Ph.D., dll" />
                <p class="mt-1 text-xs text-gray-500">Gelar pendidikan yang ditulis di belakang nama</p>
                <x-input-error class="mt-2" :messages="$errors->get('academic_degree')" />
            </div>
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" value="Bio Singkat" />
            <textarea id="bio" name="bio" rows="3"
                      class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[--color-unmul-blue] dark:focus:border-[--color-unmul-blue] focus:ring-[--color-unmul-blue] dark:focus:ring-[--color-unmul-blue] rounded-md shadow-sm"
                      placeholder="Ceritakan sedikit tentang diri Anda dan keahlian Anda...">{{ old('bio', $user->profile?->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- Expertise -->
        <div>
            <x-input-label for="expertise" value="Bidang Keahlian" />
            <x-text-input id="expertise" name="expertise" type="text" class="mt-1 block w-full"
                          :value="old('expertise', $user->profile?->expertise)"
                          placeholder="Kimia Organik, Mikrobiologi, Fisika Material, dll" />
            <x-input-error class="mt-2" :messages="$errors->get('expertise')" />
        </div>

        <!-- Contact Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="phone_office" value="Telepon Kantor" />
                <x-text-input id="phone_office" name="phone_office" type="text" class="mt-1 block w-full"
                              :value="old('phone_office', $user->profile?->phone_office)"
                              placeholder="+62 541 xxxxx" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_office')" />
            </div>

            <div>
                <x-input-label for="phone_mobile" value="Telepon Mobile" />
                <x-text-input id="phone_mobile" name="phone_mobile" type="text" class="mt-1 block w-full"
                              :value="old('phone_mobile', $user->profile?->phone_mobile)"
                              placeholder="+62 812 xxxx xxxx" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_mobile')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="email_alternate" value="Email Alternatif" />
                <x-text-input id="email_alternate" name="email_alternate" type="email" class="mt-1 block w-full"
                              :value="old('email_alternate', $user->profile?->email_alternate)" />
                <x-input-error class="mt-2" :messages="$errors->get('email_alternate')" />
            </div>

            <div>
                <x-input-label for="website" value="Website" />
                <x-text-input id="website" name="website" type="url" class="mt-1 block w-full"
                              :value="old('website', $user->profile?->website)"
                              placeholder="https://example.com" />
                <x-input-error class="mt-2" :messages="$errors->get('website')" />
            </div>
        </div>

        <!-- Professional Information -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Profesional</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="department" value="Departemen/Unit" />
                    <x-text-input id="department" name="department" type="text" class="mt-1 block w-full"
                                  :value="old('department', $user->profile?->department)" />
                    <x-input-error class="mt-2" :messages="$errors->get('department')" />
                </div>

                <div>
                    <x-input-label for="faculty" value="Fakultas" />
                    <x-text-input id="faculty" name="faculty" type="text" class="mt-1 block w-full"
                                  :value="old('faculty', $user->profile?->faculty)" />
                    <x-input-error class="mt-2" :messages="$errors->get('faculty')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <x-input-label for="position" value="Jabatan" />
                    <x-text-input id="position" name="position" type="text" class="mt-1 block w-full"
                                  :value="old('position', $user->profile?->position)" />
                    <x-input-error class="mt-2" :messages="$errors->get('position')" />
                </div>

                <div>
                    <x-input-label for="employment_status" value="Status Kepegawaian" />
                    <select id="employment_status" name="employment_status"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[--color-unmul-blue] dark:focus:border-[--color-unmul-blue] focus:ring-[--color-unmul-blue] dark:focus:ring-[--color-unmul-blue] rounded-md shadow-sm">
                        <option value="">Pilih Status</option>
                        <option value="PNS" {{ old('employment_status', $user->profile?->employment_status) == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK" {{ old('employment_status', $user->profile?->employment_status) == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        <option value="Kontrak" {{ old('employment_status', $user->profile?->employment_status) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                        <option value="Mahasiswa" {{ old('employment_status', $user->profile?->employment_status) == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="Lainnya" {{ old('employment_status', $user->profile?->employment_status) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('employment_status')" />
                </div>
            </div>
        </div>

        <!-- Identity Information -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Identitas</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="id_card_number" value="Nomor KTP/Passport" />
                    <x-text-input id="id_card_number" name="id_card_number" type="text" class="mt-1 block w-full"
                                  :value="old('id_card_number', $user->profile?->id_card_number)" />
                    <x-input-error class="mt-2" :messages="$errors->get('id_card_number')" />
                </div>

                <div>
                    <x-input-label for="tax_id" value="NPWP" />
                    <x-text-input id="tax_id" name="tax_id" type="text" class="mt-1 block w-full"
                                  :value="old('tax_id', $user->profile?->tax_id)" />
                    <x-input-error class="mt-2" :messages="$errors->get('tax_id')" />
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Alamat</h3>

            <div>
                <x-input-label for="address_office" value="Alamat Kantor" />
                <textarea id="address_office" name="address_office" rows="2"
                          class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[--color-unmul-blue] dark:focus:border-[--color-unmul-blue] focus:ring-[--color-unmul-blue] dark:focus:ring-[--color-unmul-blue] rounded-md shadow-sm">{{ old('address_office', $user->profile?->address_office) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('address_office')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <x-input-label for="city" value="Kota" />
                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                                  :value="old('city', $user->profile?->city)" />
                    <x-input-error class="mt-2" :messages="$errors->get('city')" />
                </div>

                <div>
                    <x-input-label for="province" value="Provinsi" />
                    <x-text-input id="province" name="province" type="text" class="mt-1 block w-full"
                                  :value="old('province', $user->profile?->province)" />
                    <x-input-error class="mt-2" :messages="$errors->get('province')" />
                </div>

                <div>
                    <x-input-label for="postal_code" value="Kode Pos" />
                    <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full"
                                  :value="old('postal_code', $user->profile?->postal_code)" />
                    <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                </div>
            </div>
        </div>

        <!-- Social Media & Academic Links -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Tautan Akademik & Sosial Media</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="linkedin" value="LinkedIn" />
                    <x-text-input id="linkedin" name="linkedin" type="url" class="mt-1 block w-full"
                                  :value="old('linkedin', $user->profile?->linkedin)"
                                  placeholder="https://linkedin.com/in/..." />
                    <x-input-error class="mt-2" :messages="$errors->get('linkedin')" />
                </div>

                <div>
                    <x-input-label for="google_scholar" value="Google Scholar" />
                    <x-text-input id="google_scholar" name="google_scholar" type="url" class="mt-1 block w-full"
                                  :value="old('google_scholar', $user->profile?->google_scholar)"
                                  placeholder="https://scholar.google.com/..." />
                    <x-input-error class="mt-2" :messages="$errors->get('google_scholar')" />
                </div>

                <div>
                    <x-input-label for="researchgate" value="ResearchGate" />
                    <x-text-input id="researchgate" name="researchgate" type="url" class="mt-1 block w-full"
                                  :value="old('researchgate', $user->profile?->researchgate)"
                                  placeholder="https://researchgate.net/..." />
                    <x-input-error class="mt-2" :messages="$errors->get('researchgate')" />
                </div>

                <div>
                    <x-input-label for="orcid" value="ORCID" />
                    <x-text-input id="orcid" name="orcid" type="text" class="mt-1 block w-full"
                                  :value="old('orcid', $user->profile?->orcid)"
                                  placeholder="0000-0002-1234-5678" />
                    <x-input-error class="mt-2" :messages="$errors->get('orcid')" />
                </div>
            </div>
        </div>

        <!-- Preferences -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Preferensi</h3>

            <div class="space-y-4">
                <div class="flex items-center">
                    <input id="email_notifications" name="email_notifications" type="checkbox" value="1"
                           {{ old('email_notifications', $user->profile?->email_notifications ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-[--color-unmul-blue] shadow-sm focus:ring-[--color-unmul-blue]">
                    <label for="email_notifications" class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                        Terima notifikasi via email
                    </label>
                </div>

                <div class="flex items-center">
                    <input id="sms_notifications" name="sms_notifications" type="checkbox" value="1"
                           {{ old('sms_notifications', $user->profile?->sms_notifications) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-[--color-unmul-blue] shadow-sm focus:ring-[--color-unmul-blue]">
                    <label for="sms_notifications" class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                        Terima notifikasi via SMS
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button>{{ __('Simpan Profile') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
// Preview avatar before upload
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
