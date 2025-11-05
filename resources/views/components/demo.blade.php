<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('UI Components Library') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Buttons Section --}}
            <x-card title="Button Components" subtitle="Berbagai variant dan size button dengan UNMUL branding">
                <div class="space-y-4">
                    {{-- Primary Buttons --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Primary Buttons</h4>
                        <div class="flex flex-wrap gap-3">
                            <x-button variant="primary" size="sm">Small Primary</x-button>
                            <x-button variant="primary">Normal Primary</x-button>
                            <x-button variant="primary" size="lg">Large Primary</x-button>
                            <x-button variant="primary" icon="fa fa-plus">With Icon</x-button>
                            <x-button variant="primary" loading="true">Loading...</x-button>
                            <x-button variant="primary" disabled="true">Disabled</x-button>
                        </div>
                    </div>

                    {{-- Variant Buttons --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Variants</h4>
                        <div class="flex flex-wrap gap-3">
                            <x-button variant="primary">Primary</x-button>
                            <x-button variant="secondary">Secondary</x-button>
                            <x-button variant="success">Success</x-button>
                            <x-button variant="danger">Danger</x-button>
                            <x-button variant="warning">Warning</x-button>
                            <x-button variant="info">Info</x-button>
                            <x-button variant="dark">Dark</x-button>
                            <x-button variant="light">Light</x-button>
                        </div>
                    </div>

                    {{-- Outline Buttons --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Outline Buttons</h4>
                        <div class="flex flex-wrap gap-3">
                            <x-button variant="outline-primary">Outline Primary</x-button>
                            <x-button variant="outline-secondary">Outline Secondary</x-button>
                            <x-button variant="outline-danger">Outline Danger</x-button>
                            <x-button variant="ghost">Ghost</x-button>
                            <x-button variant="link">Link</x-button>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Alerts Section --}}
            <x-card title="Alert Components" subtitle="Alert notifications dengan berbagai type">
                <div class="space-y-4">
                    <x-alert type="success" title="Success!" dismissible="true">
                        Profile Anda telah berhasil diperbarui.
                    </x-alert>

                    <x-alert type="error" title="Error!" dismissible="true">
                        Terjadi kesalahan saat menyimpan data. Silakan coba lagi.
                    </x-alert>

                    <x-alert type="warning" title="Warning!" dismissible="true">
                        Password Anda akan kadaluarsa dalam 7 hari. Silakan ganti password Anda.
                    </x-alert>

                    <x-alert type="info" dismissible="true">
                        Maintenance system akan dilakukan pada tanggal 10 Oktober 2025 pukul 00:00 - 06:00 WIB.
                    </x-alert>
                </div>
            </x-card>

            {{-- Badges Section --}}
            <x-card title="Badge Components" subtitle="Badge untuk status, label, dan kategori">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Badge Variants</h4>
                        <div class="flex flex-wrap gap-2">
                            <x-badge variant="default">Default</x-badge>
                            <x-badge variant="primary">Primary</x-badge>
                            <x-badge variant="secondary">Secondary</x-badge>
                            <x-badge variant="success">Success</x-badge>
                            <x-badge variant="danger">Danger</x-badge>
                            <x-badge variant="warning">Warning</x-badge>
                            <x-badge variant="info">Info</x-badge>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Badge Sizes</h4>
                        <div class="flex flex-wrap items-center gap-2">
                            <x-badge variant="primary" size="sm">Small</x-badge>
                            <x-badge variant="primary" size="md">Medium</x-badge>
                            <x-badge variant="primary" size="lg">Large</x-badge>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Badge with Dot</h4>
                        <div class="flex flex-wrap gap-2">
                            <x-badge variant="success" dot="true">Active</x-badge>
                            <x-badge variant="danger" dot="true">Inactive</x-badge>
                            <x-badge variant="warning" dot="true">Pending</x-badge>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Rounded Badge</h4>
                        <div class="flex flex-wrap gap-2">
                            <x-badge variant="primary" rounded="full">99+</x-badge>
                            <x-badge variant="danger" rounded="full" size="sm">5</x-badge>
                            <x-badge variant="success" rounded="full">New</x-badge>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Stats Cards Section --}}
            <x-card title="Stats Card Components" subtitle="Card khusus untuk menampilkan statistik">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <x-stats-card
                        title="Total Requests"
                        value="1,234"
                        icon="fa fa-file-alt"
                        iconColor="blue"
                        trend="up"
                        trendValue="+12.5%"
                        description="vs last month"/>

                    <x-stats-card
                        title="Revenue"
                        value="Rp 45.6M"
                        icon="fa fa-dollar-sign"
                        iconColor="green"
                        trend="up"
                        trendValue="+23.1%"
                        description="vs last month"/>

                    <x-stats-card
                        title="Equipment"
                        value="127"
                        icon="fa fa-flask"
                        iconColor="orange"
                        description="Available"/>

                    <x-stats-card
                        title="Pending Tasks"
                        value="18"
                        icon="fa fa-clock"
                        iconColor="red"
                        trend="down"
                        trendValue="-8.3%"
                        description="vs last week"/>
                </div>
            </x-card>

            {{-- Modal Section --}}
            <x-card title="Modal Components" subtitle="Modal dialog dengan berbagai ukuran">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Modal Sizes</h4>
                        <div class="flex flex-wrap gap-3">
                            <x-button variant="primary" onclick="openModal('modal-sm')">Small Modal</x-button>
                            <x-button variant="primary" onclick="openModal('modal-md')">Medium Modal</x-button>
                            <x-button variant="primary" onclick="openModal('modal-lg')">Large Modal</x-button>
                            <x-button variant="primary" onclick="openModal('modal-xl')">Extra Large Modal</x-button>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Modal with Footer</h4>
                        <x-button variant="secondary" onclick="openModal('modal-footer')">Open Modal with Footer</x-button>
                    </div>
                </div>
            </x-card>

            {{-- Form Components Section --}}
            <x-card title="Form Components" subtitle="Input, Textarea, Select, Checkbox, Radio, dan File Upload">
                <div class="space-y-6">
                    {{-- Text Input --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Text Input</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-input
                                label="Nama Lengkap"
                                name="fullname"
                                placeholder="Masukkan nama lengkap"
                                required="true"
                                hint="Nama sesuai dengan KTP" />

                            <x-input
                                label="Email"
                                name="email"
                                type="email"
                                icon="fa fa-envelope"
                                iconPosition="left"
                                placeholder="email@example.com" />

                            <x-input
                                label="Telepon"
                                name="phone"
                                type="tel"
                                icon="fa fa-phone"
                                iconPosition="left"
                                placeholder="08xx-xxxx-xxxx" />

                            <x-input
                                label="Password"
                                name="password"
                                type="password"
                                icon="fa fa-lock"
                                iconPosition="left"
                                error="Password minimal 8 karakter" />
                        </div>
                    </div>

                    {{-- Textarea --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Textarea</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-textarea
                                label="Deskripsi"
                                name="description"
                                placeholder="Masukkan deskripsi..."
                                rows="4"
                                hint="Minimal 50 karakter" />

                            <x-textarea
                                label="Catatan"
                                name="notes"
                                placeholder="Masukkan catatan..."
                                maxlength="200"
                                showCounter="true"
                                rows="4" />
                        </div>
                    </div>

                    {{-- Select --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Select Dropdown</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-select
                                label="Pilih Role"
                                name="role"
                                :options="[
                                    '1' => 'Super Admin',
                                    '2' => 'Kepala Lab',
                                    '3' => 'Laboran',
                                    '4' => 'Dosen',
                                    '5' => 'Mahasiswa'
                                ]"
                                required="true" />

                            <x-select
                                label="Status"
                                name="status"
                                :options="[
                                    'active' => 'Aktif',
                                    'inactive' => 'Tidak Aktif',
                                    'pending' => 'Pending'
                                ]"
                                hint="Pilih status pengguna" />
                        </div>
                    </div>

                    {{-- Checkbox & Radio --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Checkbox</h4>
                            <div class="space-y-2">
                                <x-checkbox
                                    label="Saya setuju dengan syarat dan ketentuan"
                                    name="terms"
                                    description="Anda harus menyetujui untuk melanjutkan" />

                                <x-checkbox
                                    label="Subscribe newsletter"
                                    name="newsletter"
                                    checked="true"
                                    description="Dapatkan update terbaru via email" />

                                <x-checkbox
                                    label="Enable notifications"
                                    name="notifications" />
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Radio Button</h4>
                            <div class="space-y-2">
                                <x-radio
                                    label="Pria"
                                    name="gender"
                                    value="male"
                                    checked="true" />

                                <x-radio
                                    label="Wanita"
                                    name="gender"
                                    value="female" />

                                <x-radio
                                    label="Lainnya"
                                    name="gender"
                                    value="other"
                                    description="Pilih jika tidak termasuk kategori di atas" />
                            </div>
                        </div>
                    </div>

                    {{-- File Upload --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">File Upload</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-file-upload
                                label="Upload Avatar"
                                name="avatar"
                                accept="image/*"
                                hint="Format: JPG, PNG, GIF. Max: 2MB" />

                            <x-file-upload
                                label="Upload Dokumen"
                                name="documents"
                                accept=".pdf,.doc,.docx"
                                multiple="true"
                                hint="Format: PDF, DOC, DOCX. Max: 5MB" />
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Table Section --}}
            <x-card title="Table Components" subtitle="Tabel data dengan striped dan hoverable">
                <x-table :headers="['No', 'Nama', 'Role', 'Email', 'Status', 'Aksi']" striped="true" hoverable="true">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">1</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Dr. Anton Prafanto, S.Kom., M.T.</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-badge variant="danger">Super Admin</x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">superadmin@unmul.ac.id</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-badge variant="success" dot="true">Active</x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-button variant="primary" size="sm">Edit</x-button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">2</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Prof. Anton Prafanto, Ph.D.</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-badge variant="warning">Kepala Lab</x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">kepalalab@unmul.ac.id</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-badge variant="success" dot="true">Active</x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-button variant="primary" size="sm">Edit</x-button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">3</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Anton Laboran, S.T.</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-badge variant="info">Laboran</x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">laboran@unmul.ac.id</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-badge variant="danger" dot="true">Inactive</x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-button variant="primary" size="sm">Edit</x-button>
                        </td>
                    </tr>
                </x-table>
            </x-card>

            {{-- Loading Section --}}
            <x-card title="Loading Components" subtitle="Spinner loading dengan berbagai ukuran dan warna">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded">
                        <x-loading size="sm" color="primary" />
                        <p class="mt-2 text-xs text-gray-500">Small Primary</p>
                    </div>
                    <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded">
                        <x-loading size="md" color="secondary" />
                        <p class="mt-2 text-xs text-gray-500">Medium Secondary</p>
                    </div>
                    <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded">
                        <x-loading size="lg" color="success" text="Loading..." />
                        <p class="mt-2 text-xs text-gray-500">Large with Text</p>
                    </div>
                </div>
            </x-card>

            {{-- Dropdown Section --}}
            <x-card title="Dropdown Components" subtitle="Dropdown menu dengan Alpine.js">
                <div class="flex flex-wrap gap-4">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <x-button variant="primary">
                                Dropdown Left <i class="fa fa-chevron-down ml-2"></i>
                            </x-button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a>
                                <hr class="my-1 border-gray-200 dark:border-gray-700">
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</a>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <x-button variant="secondary">
                                Actions <i class="fa fa-chevron-down ml-2"></i>
                            </x-button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fa fa-eye mr-2"></i> View
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fa fa-edit mr-2"></i> Edit
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fa fa-download mr-2"></i> Download
                                </a>
                                <hr class="my-1 border-gray-200 dark:border-gray-700">
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fa fa-trash mr-2"></i> Delete
                                </a>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </x-card>

            {{-- Breadcrumb Section --}}
            <x-card title="Breadcrumb Components" subtitle="Navigasi breadcrumb dengan berbagai separator">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-2">Chevron Separator (Default)</p>
                        <x-breadcrumb :items="[
                            ['label' => 'Home', 'url' => '#', 'icon' => 'fa fa-home'],
                            ['label' => 'Laboratory', 'url' => '#'],
                            ['label' => 'Equipment', 'url' => '#'],
                            ['label' => 'Details']
                        ]" />
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 mb-2">Slash Separator</p>
                        <x-breadcrumb separator="slash" :items="[
                            ['label' => 'Dashboard', 'url' => '#'],
                            ['label' => 'Users', 'url' => '#'],
                            ['label' => 'Profile']
                        ]" />
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 mb-2">Arrow Separator</p>
                        <x-breadcrumb separator="arrow" :items="[
                            ['label' => 'iLab', 'url' => '#'],
                            ['label' => 'Requests', 'url' => '#'],
                            ['label' => 'New Request']
                        ]" />
                    </div>
                </div>
            </x-card>

            {{-- Tabs Section --}}
            <x-card title="Tabs Components" subtitle="Tab navigation dengan Alpine.js">
                <div class="space-y-6">
                    {{-- Underline Style --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Underline Style</h4>
                        <x-tabs style="underline" :tabs="[
                            ['id' => 'profile', 'label' => 'Profile', 'icon' => 'fa fa-user'],
                            ['id' => 'settings', 'label' => 'Settings', 'icon' => 'fa fa-cog'],
                            ['id' => 'notifications', 'label' => 'Notifications', 'icon' => 'fa fa-bell', 'badge' => '3']
                        ]">
                            <x-tab-content id="profile">
                                <p class="text-gray-600 dark:text-gray-400">Profile content goes here...</p>
                            </x-tab-content>
                            <x-tab-content id="settings">
                                <p class="text-gray-600 dark:text-gray-400">Settings content goes here...</p>
                            </x-tab-content>
                            <x-tab-content id="notifications">
                                <p class="text-gray-600 dark:text-gray-400">You have 3 new notifications...</p>
                            </x-tab-content>
                        </x-tabs>
                    </div>

                    {{-- Pills Style --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Pills Style</h4>
                        <x-tabs style="pills" :tabs="[
                            ['id' => 'overview', 'label' => 'Overview'],
                            ['id' => 'analytics', 'label' => 'Analytics'],
                            ['id' => 'reports', 'label' => 'Reports', 'badge' => '12']
                        ]">
                            <x-tab-content id="overview">
                                <p class="text-gray-600 dark:text-gray-400">Overview content goes here...</p>
                            </x-tab-content>
                            <x-tab-content id="analytics">
                                <p class="text-gray-600 dark:text-gray-400">Analytics content goes here...</p>
                            </x-tab-content>
                            <x-tab-content id="reports">
                                <p class="text-gray-600 dark:text-gray-400">12 reports available...</p>
                            </x-tab-content>
                        </x-tabs>
                    </div>
                </div>
            </x-card>

        </div>
    </div>

    {{-- Modal Examples --}}
    <x-modal name="modal-sm" title="Small Modal" size="sm">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            This is a small modal dialog. Perfect for simple messages or confirmations.
        </p>
    </x-modal>

    <x-modal name="modal-md" title="Medium Modal" size="md">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            This is a medium modal dialog. Default size, suitable for most use cases.
        </p>
    </x-modal>

    <x-modal name="modal-lg" title="Large Modal" size="lg">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            This is a large modal dialog. Good for forms with multiple fields or detailed content.
        </p>
    </x-modal>

    <x-modal name="modal-xl" title="Extra Large Modal" size="xl">
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            This is an extra large modal dialog. Best for complex forms or data tables.
        </p>
        <div class="grid grid-cols-2 gap-4">
            <div class="border border-gray-200 dark:border-gray-700 rounded p-4">
                <h5 class="font-semibold mb-2">Column 1</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400">Some content here</p>
            </div>
            <div class="border border-gray-200 dark:border-gray-700 rounded p-4">
                <h5 class="font-semibold mb-2">Column 2</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400">Some content here</p>
            </div>
        </div>
    </x-modal>

    <x-modal name="modal-footer" title="Modal with Footer" size="md">
        <x-slot name="footer">
            <div class="flex items-center justify-end space-x-3">
                <x-button variant="ghost" onclick="closeModal()">Cancel</x-button>
                <x-button variant="primary">Save Changes</x-button>
            </div>
        </x-slot>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
                <input type="text" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                <input type="email" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700" />
            </div>
        </div>
    </x-modal>

</x-app-layout>
