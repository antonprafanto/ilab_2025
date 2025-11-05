# iLab UNMUL - Tutorial Chapter 5: UI Components Library

## Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Komponen yang Dibangun](#komponen-yang-dibangun)
3. [Button Component](#button-component)
4. [Card Components](#card-components)
5. [Badge Component](#badge-component)
6. [Alert Component](#alert-component)
7. [Modal Component](#modal-component)
8. [Form Components](#form-components)
   - [Input Component](#input-component)
   - [Textarea Component](#textarea-component)
   - [Select Component](#select-component)
   - [Checkbox Component](#checkbox-component)
   - [Radio Component](#radio-component)
   - [File Upload Component](#file-upload-component)
9. [Table Component](#table-component)
10. [Loading Component](#loading-component)
11. [Dropdown Component](#dropdown-component)
12. [Breadcrumb Component](#breadcrumb-component)
13. [Tabs Component](#tabs-component)
14. [Demo Page](#demo-page)
15. [Usage Examples](#usage-examples)
16. [Best Practices](#best-practices)

---

## Pendahuluan

**Chapter 5** membangun foundation UI Components Library yang akan digunakan di seluruh aplikasi iLab UNMUL. Component library ini:

- ✅ Reusable dan konsisten
- ✅ Menggunakan UNMUL branding colors
- ✅ Support dark mode
- ✅ Responsive design
- ✅ Accessible (ARIA labels, keyboard navigation)
- ✅ Interactive dengan Alpine.js

**Keuntungan Component Library:**
1. **Consistency**: Semua komponen mengikuti design system yang sama
2. **Development Speed**: Tidak perlu menulis ulang code yang sama
3. **Maintenance**: Update sekali, apply ke semua page
4. **Quality**: Tested components, less bugs

---

## Komponen yang Dibangun

### 1. Button Component
- **File**: `resources/views/components/button.blade.php`
- **Variants**: 13 variants (primary, secondary, success, danger, warning, info, dark, light, outline-*, ghost, link)
- **Sizes**: 5 sizes (xs, sm, md, lg, xl)
- **Features**: Loading state, disabled state, icons, custom styling

### 2. Card Components
- **Card**: `resources/views/components/card.blade.php` - Content wrapper dengan header/footer
- **Stats Card**: `resources/views/components/stats-card.blade.php` - Statistik dengan icon dan trend

### 3. Badge Component
- **File**: `resources/views/components/badge.blade.php`
- **Variants**: 7 variants dengan sizes dan dot indicator

### 4. Alert Component
- **File**: `resources/views/components/alert.blade.php`
- **Types**: Success, error, warning, info dengan dismissible option

### 5. Modal Component
- **File**: `resources/views/components/modal.blade.php`
- **Sizes**: 8 sizes (sm, md, lg, xl, 2xl, 3xl, 4xl, full)
- **Features**: Alpine.js powered, closeable, footer slot

### 6. Form Components
- **Input**: `resources/views/components/input.blade.php` - Text input dengan icon, error, hint
- **Textarea**: `resources/views/components/textarea.blade.php` - Textarea dengan character counter
- **Select**: `resources/views/components/select.blade.php` - Dropdown select dengan placeholder
- **Checkbox**: `resources/views/components/checkbox.blade.php` - Checkbox dengan label dan description
- **Radio**: `resources/views/components/radio.blade.php` - Radio button dengan description
- **File Upload**: `resources/views/components/file-upload.blade.php` - File upload dengan preview

### 7. Table Component
- **File**: `resources/views/components/table.blade.php`
- **Features**: Striped, hoverable, bordered, compact modes

### 8. Loading Component
- **File**: `resources/views/components/loading.blade.php`
- **Sizes**: xs, sm, md, lg, xl
- **Colors**: Primary, secondary, success, danger, white, gray

### 9. Dropdown Component
- **File**: `resources/views/components/dropdown.blade.php`
- **Features**: Alpine.js powered, alignment options, trigger/content slots

### 10. Breadcrumb Component
- **File**: `resources/views/components/breadcrumb.blade.php`
- **Separators**: Chevron, slash, arrow, dot

### 11. Tabs Component
- **Files**: `resources/views/components/tabs.blade.php` + `tab-content.blade.php`
- **Styles**: Underline, pills
- **Features**: Alpine.js powered, icons, badges
- **Features**: Icon, value, trend indicator, description
- **Use cases**: Dashboard statistics, KPI display

### 4. Badge Component
- **File**: `resources/views/components/badge.blade.php`
- **Variants**: 7 variants (default, primary, secondary, success, danger, warning, info)
- **Features**: Sizes, rounded options, dot indicator

### 5. Alert Component
- **File**: `resources/views/components/alert.blade.php`
- **Types**: 4 types (success, error, warning, info)
- **Features**: Title, icon, dismissible

### 6. Modal Component
- **File**: `resources/views/components/modal.blade.php`
- **Sizes**: 8 sizes (sm, md, lg, xl, 2xl, 3xl, 4xl, full)
- **Features**: Header, footer, closeable, Alpine.js powered

---

## Button Component

### Implementation

**File**: `resources/views/components/button.blade.php`

```blade
@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'loading' => false,
    'disabled' => false,
])

@php
    // Variant styles dengan UNMUL branding
    $variantClasses = [
        'primary' => 'bg-[#0066CC] hover:bg-[#0052A3] text-white',
        'secondary' => 'bg-[#FF9800] hover:bg-[#E68900] text-white',
        'success' => 'bg-[#4CAF50] hover:bg-[#45A049] text-white',
        'danger' => 'bg-[#E53935] hover:bg-[#C62828] text-white',
        // ... more variants
    ];

    // Size classes
    $sizeClasses = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
        'xl' => 'px-6 py-3 text-base',
    ];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($isDisabled) disabled @endif>
    @if($loading)
        {{-- Loading spinner SVG --}}
    @elseif($icon && $iconPosition === 'left')
        <i class="{{ $icon }} -ml-1 mr-2"></i>
    @endif

    {{ $slot }}

    @if($icon && $iconPosition === 'right')
        <i class="{{ $icon }} ml-2 -mr-1"></i>
    @endif
</button>
```

### Usage Examples

**Basic Button:**
```blade
<x-button variant="primary">Save</x-button>
```

**Button with Icon:**
```blade
<x-button variant="primary" icon="fa fa-plus">Add New</x-button>
```

**Loading State:**
```blade
<x-button variant="primary" loading="true">Processing...</x-button>
```

**Button as Link:**
```blade
<x-button variant="primary" href="/dashboard">Go to Dashboard</x-button>
```

**Outline Button:**
```blade
<x-button variant="outline-primary">Cancel</x-button>
```

### Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'primary'` | Button color variant |
| `size` | string | `'md'` | Button size |
| `type` | string | `'button'` | HTML button type |
| `href` | string | `null` | If set, renders as `<a>` tag |
| `icon` | string | `null` | Font Awesome icon class |
| `iconPosition` | string | `'left'` | Icon position (left/right) |
| `loading` | boolean | `false` | Show loading spinner |
| `disabled` | boolean | `false` | Disable button |

---

## Card Components

### Basic Card Component

**File**: `resources/views/components/card.blade.php`

```blade
@props([
    'title' => null,
    'subtitle' => null,
    'header' => null,
    'footer' => null,
    'padding' => 'normal',
    'shadow' => 'sm',
])

<div {{ $attributes->merge(['class' => "bg-white dark:bg-gray-800 rounded-lg border..."]) }}>
    @if($header || $title)
        <div class="px-6 py-4 border-b...">
            {{-- Header content --}}
        </div>
    @endif

    <div class="{{ $bodyPadding }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 bg-gray-50...">
            {{ $footer }}
        </div>
    @endif
</div>
```

**Usage:**

```blade
{{-- Simple Card --}}
<x-card title="Card Title">
    Card content goes here
</x-card>

{{-- Card with Subtitle --}}
<x-card title="User Profile" subtitle="Manage your account information">
    <p>Profile content...</p>
</x-card>

{{-- Card with Footer --}}
<x-card title="Confirmation">
    <x-slot name="footer">
        <x-button variant="primary">Confirm</x-button>
        <x-button variant="ghost">Cancel</x-button>
    </x-slot>

    Are you sure you want to delete this item?
</x-card>
```

### Stats Card Component

**File**: `resources/views/components/stats-card.blade.php`

**Features:**
- Icon dengan background color
- Value dan title
- Trend indicator (up/down arrow dengan warna)
- Description text
- Optional footer slot

**Usage:**

```blade
<x-stats-card
    title="Total Requests"
    value="1,234"
    icon="fa fa-file-alt"
    iconColor="blue"
    trend="up"
    trendValue="+12.5%"
    description="vs last month"/>
```

**Props Reference:**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | `''` | Card title |
| `value` | string | `'0'` | Main value to display |
| `icon` | string | `null` | Font Awesome icon |
| `iconColor` | string | `'blue'` | Icon background color |
| `trend` | string | `null` | Trend direction (up/down) |
| `trendValue` | string | `null` | Trend percentage |
| `description` | string | `null` | Additional description |

---

## Badge Component

**File**: `resources/views/components/badge.blade.php`

### Features
- 7 color variants
- 3 sizes
- Rounded options (sm, md, lg, full)
- Dot indicator option

### Usage Examples

**Basic Badge:**
```blade
<x-badge variant="primary">New</x-badge>
```

**Badge with Dot:**
```blade
<x-badge variant="success" dot="true">Active</x-badge>
```

**Different Sizes:**
```blade
<x-badge variant="primary" size="sm">Small</x-badge>
<x-badge variant="primary" size="md">Medium</x-badge>
<x-badge variant="primary" size="lg">Large</x-badge>
```

**Rounded Badge (for counts):**
```blade
<x-badge variant="danger" rounded="full">99+</x-badge>
```

### Real-world Examples

**Status Indicators:**
```blade
<x-badge variant="success" dot="true">Completed</x-badge>
<x-badge variant="warning" dot="true">Pending</x-badge>
<x-badge variant="danger" dot="true">Rejected</x-badge>
```

**Category Tags:**
```blade
<x-badge variant="primary">Chemistry</x-badge>
<x-badge variant="secondary">Physics</x-badge>
<x-badge variant="info">Biology</x-badge>
```

**Notification Count:**
```blade
<span class="relative">
    <i class="fa fa-bell"></i>
    <x-badge variant="danger" rounded="full" class="absolute -top-2 -right-2">5</x-badge>
</span>
```

---

## Alert Component

**File**: `resources/views/components/alert.blade.php`

### Features
- 4 types (success, error, warning, info)
- Icon automatically matched to type
- Optional title
- Dismissible option (with Alpine.js)

### Usage Examples

**Success Alert:**
```blade
<x-alert type="success" title="Success!">
    Profile has been updated successfully.
</x-alert>
```

**Error Alert:**
```blade
<x-alert type="error" title="Error!" dismissible="true">
    An error occurred while saving. Please try again.
</x-alert>
```

**Warning Alert:**
```blade
<x-alert type="warning" dismissible="true">
    Your password will expire in 7 days. Please change your password.
</x-alert>
```

**Info Alert:**
```blade
<x-alert type="info">
    System maintenance scheduled for October 10, 2025.
</x-alert>
```

### Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | string | `'info'` | Alert type (success, error, warning, info) |
| `title` | string | `null` | Alert title |
| `dismissible` | boolean | `false` | Show close button |
| `icon` | boolean | `true` | Show icon |

---

## Modal Component

**File**: `resources/views/components/modal.blade.php`

### Features
- Powered by Alpine.js
- 8 size options
- Backdrop click to close (optional)
- ESC key to close
- Header with close button
- Optional footer slot
- Smooth transitions

### Usage

**1. Define Modal:**
```blade
<x-modal name="delete-confirmation" title="Confirm Delete" size="md">
    <p>Are you sure you want to delete this item? This action cannot be undone.</p>

    <x-slot name="footer">
        <x-button variant="ghost" onclick="closeModal()">Cancel</x-button>
        <x-button variant="danger">Delete</x-button>
    </x-slot>
</x-modal>
```

**2. Open Modal:**
```blade
<x-button variant="danger" onclick="openModal('delete-confirmation')">
    Delete Item
</x-button>
```

### JavaScript Helper Functions

Modal component menyediakan 2 helper functions global:

```javascript
// Open specific modal by name
openModal('modal-name')

// Close any open modal
closeModal()
```

### Size Options

```blade
<x-modal name="small" size="sm">Small modal (max-width: 24rem)</x-modal>
<x-modal name="medium" size="md">Medium modal (max-width: 28rem)</x-modal>
<x-modal name="large" size="lg">Large modal (max-width: 32rem)</x-modal>
<x-modal name="xl" size="xl">XL modal (max-width: 36rem)</x-modal>
<x-modal name="2xl" size="2xl">2XL modal (max-width: 42rem)</x-modal>
<x-modal name="full" size="full">Full width with margin</x-modal>
```

### Advanced Example: Form Modal

```blade
<x-modal name="add-user" title="Add New User" size="lg">
    <form action="/users" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" class="w-full rounded-md border-gray-300" required />
            </div>
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" class="w-full rounded-md border-gray-300" required />
            </div>
            <div>
                <label class="block text-sm font-medium">Role</label>
                <select name="role_id" class="w-full rounded-md border-gray-300" required>
                    <option value="">Select Role...</option>
                    <option value="1">Super Admin</option>
                    <option value="2">Manager</option>
                </select>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <x-button variant="ghost" onclick="closeModal()">Cancel</x-button>
        <x-button variant="primary" type="submit">Create User</x-button>
    </x-slot>
</x-modal>
```

---

## Demo Page

**Route**: `/components`
**File**: `resources/views/components/demo.blade.php`

Demo page sudah dibuat untuk showcase semua komponen yang tersedia. Akses dengan login dulu, kemudian navigate ke:

```
http://localhost:8000/components
```

**Demo Page includes:**
- ✅ Button variants showcase
- ✅ Alert examples (dismissible)
- ✅ Badge examples (all variants, sizes, with dots)
- ✅ Stats card examples (dengan trend indicators)
- ✅ Modal examples (berbagai sizes)
- ✅ Interactive examples

---

## Usage Examples

### Dashboard Page dengan Components

```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2>Dashboard</h2>
            <x-button variant="primary" icon="fa fa-plus" href="/requests/create">
                New Request
            </x-button>
        </div>
    </x-slot>

    {{-- Success notification --}}
    @if(session('success'))
        <x-alert type="success" dismissible="true">
            {{ session('success') }}
        </x-alert>
    @endif

    {{-- Stats Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <x-stats-card
            title="Total Requests"
            value="{{ $totalRequests }}"
            icon="fa fa-file-alt"
            iconColor="blue"
            trend="up"
            trendValue="+12.5%"/>

        <x-stats-card
            title="Pending"
            value="{{ $pendingRequests }}"
            icon="fa fa-clock"
            iconColor="orange"
            description="Awaiting approval"/>

        <x-stats-card
            title="Completed"
            value="{{ $completedRequests }}"
            icon="fa fa-check-circle"
            iconColor="green"
            trend="up"
            trendValue="+8.3%"/>

        <x-stats-card
            title="Revenue"
            value="Rp {{ number_format($revenue) }}"
            icon="fa fa-dollar-sign"
            iconColor="green"
            trend="up"
            trendValue="+15.2%"/>
    </div>

    {{-- Recent Requests Card --}}
    <x-card title="Recent Requests" subtitle="Latest service requests">
        <x-slot name="footer">
            <x-button variant="ghost" href="/requests">View All</x-button>
        </x-slot>

        <table class="w-full">
            {{-- Table content --}}
        </table>
    </x-card>
</x-app-layout>
```

### List Page dengan Badges

```blade
<x-card title="Service Requests">
    <table class="w-full">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Service</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->request_number }}</td>
                    <td>{{ $request->service->name }}</td>
                    <td>
                        @if($request->status === 'completed')
                            <x-badge variant="success" dot="true">Completed</x-badge>
                        @elseif($request->status === 'pending')
                            <x-badge variant="warning" dot="true">Pending</x-badge>
                        @elseif($request->status === 'rejected')
                            <x-badge variant="danger" dot="true">Rejected</x-badge>
                        @else
                            <x-badge variant="info" dot="true">{{ ucfirst($request->status) }}</x-badge>
                        @endif
                    </td>
                    <td>
                        <x-badge variant="{{ $request->is_urgent ? 'danger' : 'default' }}">
                            {{ $request->is_urgent ? 'Urgent' : 'Normal' }}
                        </x-badge>
                    </td>
                    <td>
                        <x-button variant="ghost" size="sm" href="/requests/{{ $request->id }}">
                            View
                        </x-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-card>
```

### Delete Confirmation Modal

```blade
{{-- Trigger Button --}}
<x-button variant="danger" onclick="openModal('delete-{{ $item->id }}')">
    Delete
</x-button>

{{-- Modal --}}
<x-modal name="delete-{{ $item->id }}" title="Confirm Delete" size="md">
    <p class="text-gray-600 dark:text-gray-400">
        Are you sure you want to delete <strong>{{ $item->name }}</strong>?
        This action cannot be undone.
    </p>

    <x-slot name="footer">
        <x-button variant="ghost" onclick="closeModal()">Cancel</x-button>
        <form action="/items/{{ $item->id }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <x-button variant="danger" type="submit">Delete</x-button>
        </form>
    </x-slot>
</x-modal>
```

---

## Form Components

### Input Component

**File**: `resources/views/components/input.blade.php`

Text input dengan label, icon, error message, dan hint text.

**Props:**
- `type` - Input type (text, email, password, tel, etc.) Default: text
- `label` - Label text
- `name` - Input name (required)
- `value` - Default value
- `placeholder` - Placeholder text
- `required` - Required field (boolean)
- `disabled` - Disabled state (boolean)
- `error` - Error message
- `hint` - Hint text below input
- `icon` - Icon class (FontAwesome)
- `iconPosition` - Icon position: left/right. Default: left

**Example:**
```blade
<x-input
    label="Email"
    name="email"
    type="email"
    icon="fa fa-envelope"
    iconPosition="left"
    placeholder="email@example.com"
    required="true"
    hint="Gunakan email institusi" />
```

---

### Textarea Component

**File**: `resources/views/components/textarea.blade.php`

Textarea dengan character counter optional.

**Props:**
- `label` - Label text
- `name` - Textarea name (required)
- `value` - Default value
- `placeholder` - Placeholder text
- `required` - Required field (boolean)
- `disabled` - Disabled state (boolean)
- `error` - Error message
- `hint` - Hint text
- `rows` - Number of rows. Default: 4
- `maxlength` - Maximum characters
- `showCounter` - Show character counter (boolean)

**Example:**
```blade
<x-textarea
    label="Deskripsi"
    name="description"
    placeholder="Masukkan deskripsi..."
    maxlength="500"
    showCounter="true"
    rows="6"
    hint="Jelaskan dengan detail" />
```

---

### Select Component

**File**: `resources/views/components/select.blade.php`

Dropdown select dengan options array atau slot.

**Props:**
- `label` - Label text
- `name` - Select name (required)
- `value` - Selected value
- `options` - Array of options ([value => label])
- `placeholder` - Placeholder text
- `required` - Required field (boolean)
- `disabled` - Disabled state (boolean)
- `error` - Error message
- `hint` - Hint text
- `multiple` - Multiple selection (boolean)

**Example:**
```blade
{{-- Using options array --}}
<x-select
    label="Pilih Role"
    name="role"
    :options="[
        '1' => 'Super Admin',
        '2' => 'Kepala Lab',
        '3' => 'Laboran'
    ]"
    required="true" />

{{-- Using slot for custom options --}}
<x-select label="Status" name="status">
    <option value="">-- Pilih Status --</option>
    <option value="active">Aktif</option>
    <option value="inactive">Tidak Aktif</option>
</x-select>
```

---

### Checkbox Component

**File**: `resources/views/components/checkbox.blade.php`

Checkbox dengan label dan description.

**Props:**
- `label` - Label text
- `name` - Checkbox name (required)
- `value` - Checkbox value. Default: 1
- `checked` - Checked state (boolean)
- `disabled` - Disabled state (boolean)
- `error` - Error message
- `hint` - Hint text
- `description` - Description text below label

**Example:**
```blade
<x-checkbox
    label="Saya setuju dengan syarat dan ketentuan"
    name="terms"
    description="Anda harus menyetujui untuk melanjutkan"
    required="true" />

<x-checkbox
    label="Subscribe newsletter"
    name="newsletter"
    checked="true" />
```

---

### Radio Component

**File**: `resources/views/components/radio.blade.php`

Radio button dengan label dan description.

**Props:**
- `label` - Label text
- `name` - Radio name (required)
- `value` - Radio value (required)
- `checked` - Checked state (boolean)
- `disabled` - Disabled state (boolean)
- `error` - Error message
- `description` - Description text

**Example:**
```blade
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
```

---

### File Upload Component

**File**: `resources/views/components/file-upload.blade.php`

File upload dengan drag & drop dan preview gambar.

**Props:**
- `label` - Label text
- `name` - Input name (required)
- `accept` - Accepted file types (e.g., "image/*", ".pdf")
- `required` - Required field (boolean)
- `disabled` - Disabled state (boolean)
- `error` - Error message
- `hint` - Hint text
- `multiple` - Multiple files (boolean)
- `maxSize` - Maximum file size text. Default: 2MB
- `preview` - Show preview (boolean). Default: true

**Example:**
```blade
{{-- Image upload --}}
<x-file-upload
    label="Upload Avatar"
    name="avatar"
    accept="image/*"
    hint="Format: JPG, PNG, GIF. Max: 2MB" />

{{-- Multiple documents --}}
<x-file-upload
    label="Upload Dokumen"
    name="documents"
    accept=".pdf,.doc,.docx"
    multiple="true"
    maxSize="5MB"
    hint="Format: PDF, DOC, DOCX" />
```

---

## Table Component

**File**: `resources/views/components/table.blade.php`

Responsive table dengan striped, hoverable, dan bordered options.

**Props:**
- `headers` - Array of header labels
- `striped` - Striped rows (boolean). Default: true
- `hoverable` - Hover effect (boolean). Default: true
- `bordered` - Border around table (boolean). Default: false
- `compact` - Compact padding (boolean). Default: false

**Example:**
```blade
{{-- Using headers array --}}
<x-table :headers="['No', 'Nama', 'Email', 'Role', 'Status']" striped="true" hoverable="true">
    <tr>
        <td class="px-6 py-4 text-sm">1</td>
        <td class="px-6 py-4 text-sm">Dr. Anton Prafanto</td>
        <td class="px-6 py-4 text-sm">anton@unmul.ac.id</td>
        <td class="px-6 py-4 text-sm">
            <x-badge variant="danger">Super Admin</x-badge>
        </td>
        <td class="px-6 py-4 text-sm">
            <x-badge variant="success" dot="true">Active</x-badge>
        </td>
    </tr>
</x-table>

{{-- Using header slot --}}
<x-table striped="true" hoverable="true">
    <x-slot name="header">
        <tr>
            <th class="px-6 py-3">Column 1</th>
            <th class="px-6 py-3">Column 2</th>
        </tr>
    </x-slot>
    <!-- Table body -->
</x-table>
```

---

## Loading Component

**File**: `resources/views/components/loading.blade.php`

Spinner loading indicator dengan berbagai ukuran dan warna.

**Props:**
- `size` - Size: xs, sm, md, lg, xl. Default: md
- `color` - Color: primary, secondary, success, danger, white, gray. Default: primary
- `text` - Loading text below spinner

**Example:**
```blade
{{-- Simple loading --}}
<x-loading />

{{-- Large with text --}}
<x-loading size="lg" color="primary" text="Loading data..." />

{{-- For buttons --}}
<x-button variant="primary" disabled="true">
    <x-loading size="sm" color="white" class="inline-block mr-2" />
    Processing...
</x-button>
```

---

## Dropdown Component

**File**: `resources/views/components/dropdown.blade.php`

Dropdown menu dengan Alpine.js (click away to close).

**Props:**
- `align` - Alignment: left, right, top. Default: right
- `width` - Width: 48, 56, 64, 72, full. Default: 48
- `contentClasses` - Custom content classes

**Slots:**
- `trigger` - Trigger button/element
- `content` - Dropdown content

**Example:**
```blade
<x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <x-button variant="primary">
            Actions <i class="fa fa-chevron-down ml-2"></i>
        </x-button>
    </x-slot>

    <x-slot name="content">
        <div class="py-1">
            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Edit</a>
            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">View</a>
            <hr class="my-1">
            <a href="#" class="block px-4 py-2 text-sm text-red-600">Delete</a>
        </div>
    </x-slot>
</x-dropdown>
```

---

## Breadcrumb Component

**File**: `resources/views/components/breadcrumb.blade.php`

Navigation breadcrumb dengan berbagai separator styles.

**Props:**
- `items` - Array of breadcrumb items
  - `label` - Item text (required)
  - `url` - Item URL (optional, last item auto-inactive)
  - `icon` - Icon class (optional)
- `separator` - Separator style: chevron, slash, arrow, dot. Default: chevron

**Example:**
```blade
<x-breadcrumb :items="[
    ['label' => 'Home', 'url' => route('dashboard'), 'icon' => 'fa fa-home'],
    ['label' => 'Laboratory', 'url' => route('labs.index')],
    ['label' => 'Equipment', 'url' => route('equipment.index')],
    ['label' => 'Details']
]" />

{{-- Different separator --}}
<x-breadcrumb separator="slash" :items="[...]" />
```

---

## Tabs Component

**Files**:
- `resources/views/components/tabs.blade.php`
- `resources/views/components/tab-content.blade.php`

Tab navigation dengan Alpine.js untuk switching.

**Tabs Props:**
- `tabs` - Array of tab items
  - `id` - Tab identifier (required)
  - `label` - Tab label (required)
  - `icon` - Icon class (optional)
  - `badge` - Badge text (optional)
- `active` - Active tab ID. Default: first tab
- `style` - Tab style: underline, pills. Default: underline

**Tab Content Props:**
- `id` - Content identifier (must match tab id)

**Example:**
```blade
<x-tabs style="underline" :tabs="[
    ['id' => 'profile', 'label' => 'Profile', 'icon' => 'fa fa-user'],
    ['id' => 'settings', 'label' => 'Settings', 'icon' => 'fa fa-cog'],
    ['id' => 'notifications', 'label' => 'Notifications', 'badge' => '3']
]">
    <x-tab-content id="profile">
        <p>Profile content here...</p>
    </x-tab-content>

    <x-tab-content id="settings">
        <p>Settings content here...</p>
    </x-tab-content>

    <x-tab-content id="notifications">
        <p>3 new notifications...</p>
    </x-tab-content>
</x-tabs>

{{-- Pills style --}}
<x-tabs style="pills" :tabs="[...]">
    <!-- Content -->
</x-tabs>
```

---

## Best Practices

### 1. Consistent Variant Naming
Selalu gunakan variant names yang sudah didefinisikan. Jangan custom inline styles.

```blade
{{-- GOOD --}}
<x-button variant="primary">Save</x-button>

{{-- BAD --}}
<x-button class="bg-blue-500">Save</x-button>
```

### 2. Use Semantic Variants
Pilih variant berdasarkan action semantik:

- `primary`: Primary action (Save, Submit, Create)
- `secondary`: Secondary action (Edit, Update)
- `danger`: Destructive action (Delete, Remove, Cancel subscription)
- `success`: Positive confirmation (Approve, Confirm)
- `warning`: Caution action (Archive, Suspend)

### 3. Button Size Context
Gunakan size yang sesuai konteks:

- `sm`: Secondary actions, table actions, inline buttons
- `md`: Default untuk most cases
- `lg`: Primary CTAs, hero buttons
- `xl`: Landing page CTAs

### 4. Badge Usage
```blade
{{-- Status indicators --}}
<x-badge variant="success" dot="true">Active</x-badge>

{{-- Categories/Tags --}}
<x-badge variant="primary">Chemistry</x-badge>

{{-- Counts --}}
<x-badge variant="danger" rounded="full">5</x-badge>

{{-- Priority/Urgency --}}
<x-badge variant="danger">Urgent</x-badge>
```

### 5. Alert Positioning
```blade
{{-- Top of page (after header) --}}
@if(session('success'))
    <x-alert type="success" dismissible="true">
        {{ session('success') }}
    </x-alert>
@endif
```

### 6. Modal Naming
Gunakan descriptive names untuk modals:

```blade
{{-- GOOD --}}
<x-modal name="delete-user-{{ $user->id }}">
<x-modal name="edit-profile">
<x-modal name="confirm-logout">

{{-- BAD --}}
<x-modal name="modal1">
<x-modal name="m">
```

### 7. Stats Card Layout
```blade
{{-- Grid layout for dashboard --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <x-stats-card ... />
    <x-stats-card ... />
    <x-stats-card ... />
    <x-stats-card ... />
</div>
```

---

## Summary Chapter 5

**Yang Sudah Dibuat:**
✅ Button Component (13 variants, 5 sizes, loading state, icons)
✅ Card Component (header, footer, custom padding, shadows)
✅ Stats Card Component (icon, trend, description)
✅ Badge Component (7 variants, 3 sizes, dot indicator)
✅ Alert Component (4 types, dismissible, icons)
✅ Modal Component (8 sizes, Alpine.js powered)
✅ Input Component (with icon, error, hint)
✅ Textarea Component (with character counter)
✅ Select Component (options array or slot)
✅ Checkbox Component (with description)
✅ Radio Component (with description)
✅ File Upload Component (drag & drop, preview)
✅ Table Component (striped, hoverable, bordered)
✅ Loading Component (spinner with sizes/colors)
✅ Dropdown Component (Alpine.js powered)
✅ Breadcrumb Component (4 separator styles)
✅ Tabs Component (underline/pills style)
✅ Demo Page (`/components` route)

**Files Created:**
- `resources/views/components/button.blade.php`
- `resources/views/components/card.blade.php`
- `resources/views/components/stats-card.blade.php`
- `resources/views/components/badge.blade.php`
- `resources/views/components/alert.blade.php`
- `resources/views/components/modal.blade.php`
- `resources/views/components/input.blade.php`
- `resources/views/components/textarea.blade.php`
- `resources/views/components/select.blade.php`
- `resources/views/components/checkbox.blade.php`
- `resources/views/components/radio.blade.php`
- `resources/views/components/file-upload.blade.php`
- `resources/views/components/table.blade.php`
- `resources/views/components/loading.blade.php`
- `resources/views/components/dropdown.blade.php`
- `resources/views/components/breadcrumb.blade.php`
- `resources/views/components/tabs.blade.php`
- `resources/views/components/tab-content.blade.php`
- `resources/views/components/demo.blade.php`

**Files Modified:**
- `routes/web.php` - Added `/components` route

**Key Features:**
1. **UNMUL Branding**: All components use official colors (#0066CC, #FF9800, #4CAF50, #E53935)
2. **Dark Mode Support**: All components work seamlessly in dark mode
3. **Alpine.js Integration**: Interactive components (modal, tabs, dropdown, file upload)
4. **Accessibility**: ARIA labels, keyboard navigation, semantic HTML
5. **Responsive**: Mobile-first design with responsive breakpoints
6. **Reusable**: Props-based configuration for maximum flexibility
7. **Form Validation**: Built-in error states, required indicators, hint text
8. **Visual Feedback**: Loading states, hover effects, transitions

**Total Components Created**: 18 components covering all common UI patterns

**Next Chapter (Chapter 6): Laboratory Management**
- Create laboratories table and model
- CRUD operations for labs
- Photo upload for lab images
- Lab listing and detail views
- Integration dengan UI components library

---

**iLab UNMUL - Innovation Laboratory Management System**
*Universitas Mulawarman, Samarinda, Kalimantan Timur*
