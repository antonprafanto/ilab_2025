# 🎨 Component Usage Guide

**Project:** iLab LIMS
**Last Updated:** 2025-10-22

---

## 📚 **Table of Contents**

1. [x-select Component](#x-select-component)
2. [x-textarea Component](#x-textarea-component)
3. [x-input Component](#x-input-component)
4. [x-button Component](#x-button-component)
5. [x-card Component](#x-card-component)
6. [Common Mistakes](#common-mistakes)

---

## 🔽 **x-select Component**

### ✅ **Correct Usage:**

```blade
<!-- Basic usage with placeholder -->
<x-select id="laboratory_id" name="laboratory_id" placeholder="Pilih laboratorium" required>
    @foreach($laboratories as $lab)
        <option value="{{ $lab->id }}" {{ old('laboratory_id', $model?->laboratory_id) == $lab->id ? 'selected' : '' }}>
            {{ $lab->name }}
        </option>
    @endforeach
</x-select>
```

### ❌ **Wrong Usage:**

```blade
<!-- DON'T add manual empty option - component auto-injects it! -->
<x-select id="laboratory_id" name="laboratory_id" required>
    <option value="">Pilih laboratorium</option>  ← Remove this!
    @foreach($laboratories as $lab)
        <option value="{{ $lab->id }}">{{ $lab->name }}</option>
    @endforeach
</x-select>
```

### 📋 **Props:**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | '' | Field name (required) |
| `placeholder` | string | 'Pilih salah satu...' | Text for empty option |
| `required` | boolean | false | Mark field as required |
| `disabled` | boolean | false | Disable the select |
| `multiple` | boolean | false | Enable multiple selection |

### 🔍 **Key Points:**

- ✅ Component **auto-injects** placeholder option if not `multiple`
- ✅ Use `placeholder` prop to customize empty option text
- ✅ **Don't** add manual `<option value="">` - akan duplikasi!

---

## 📝 **x-textarea Component**

### ✅ **Correct Usage:**

```blade
<!-- Use :value prop (with colon for binding) -->
<x-textarea
    id="description"
    name="description"
    rows="3"
    :value="old('description', $model?->description ?? '')"
/>
```

### ❌ **Wrong Usage:**

```blade
<!-- DON'T use slot syntax - won't work! -->
<x-textarea id="description" name="description" rows="3">
    {{ old('description', $model?->description) }}  ← This will be ignored!
</x-textarea>
```

### 📋 **Props:**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | '' | Field name (required) |
| `value` | string | '' | Field value (use **:value** binding!) |
| `rows` | int | 4 | Number of rows |
| `placeholder` | string | '' | Placeholder text |
| `required` | boolean | false | Mark as required |
| `maxlength` | int | null | Max character length |
| `showCounter` | boolean | false | Show character counter |

### 🔍 **Key Points:**

- ✅ **MUST** use `:value` prop (dengan colon untuk binding)
- ✅ Component renders `{{ old($name, $value) }}` internally
- ❌ **DON'T** use slot content - component tidak support slot
- ✅ Use `?? ''` untuk avoid null values

---

## 📥 **x-input Component**

### ✅ **Correct Usage:**

```blade
<!-- Basic text input -->
<x-input
    id="name"
    name="name"
    type="text"
    value="{{ old('name', $model?->name) }}"
    placeholder="Enter name"
    required
/>

<!-- Date input -->
<x-input
    id="received_date"
    name="received_date"
    type="date"
    value="{{ old('received_date', $model?->received_date?->format('Y-m-d')) }}"
/>

<!-- Number input -->
<x-input
    id="quantity"
    name="quantity"
    type="number"
    step="0.01"
    min="0"
    value="{{ old('quantity', $model?->quantity) }}"
    required
/>
```

### 📋 **Props:**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | '' | Field name (required) |
| `type` | string | 'text' | Input type |
| `value` | string | '' | Field value |
| `placeholder` | string | '' | Placeholder text |
| `required` | boolean | false | Mark as required |
| `disabled` | boolean | false | Disable the input |

### 🔍 **Key Points:**

- ✅ For dates: use `->format('Y-m-d')` for proper format
- ✅ For numbers: use `step` and `min` attributes
- ✅ **Don't** use `:value` binding here (unlike textarea) - regular `value=` works

---

## 🔘 **x-button Component**

### ✅ **Correct Usage:**

```blade
<!-- Primary button -->
<x-button type="submit" variant="primary">
    <i class="fa fa-save mr-2"></i>Simpan
</x-button>

<!-- Secondary button -->
<x-button type="button" variant="secondary" onclick="window.location.href='{{ route('index') }}'">
    Kembali
</x-button>

<!-- Danger button -->
<x-button type="submit" variant="danger">
    <i class="fa fa-trash mr-2"></i>Hapus
</x-button>

<!-- Small ghost button -->
<x-button size="sm" variant="ghost" title="Edit">
    <svg class="w-4 h-4">...</svg>
</x-button>
```

### 📋 **Variants:**

| Variant | Color | Use Case |
|---------|-------|----------|
| `primary` | Blue | Primary actions (Save, Submit) |
| `secondary` | Gray | Secondary actions (Cancel) |
| `danger` | Red | Destructive actions (Delete) |
| `success` | Green | Success actions (Approve) |
| `warning` | Yellow | Warning actions |
| `ghost` | Transparent | Icon-only buttons |

### 📋 **Sizes:**

| Size | Class | Use Case |
|------|-------|----------|
| `sm` | Small | Icon buttons, table actions |
| `md` | Medium (default) | Regular buttons |
| `lg` | Large | Hero CTAs |

---

## 🎴 **x-card Component**

### ✅ **Correct Usage:**

```blade
<!-- Card with title -->
<x-card title="Informasi Dasar">
    <!-- Card content here -->
    <div class="grid grid-cols-2 gap-4">
        ...
    </div>
</x-card>

<!-- Card without title (just container) -->
<x-card>
    <p>Simple card content</p>
</x-card>

<!-- Card with custom class -->
<x-card title="Alert Card" class="bg-yellow-50 border-yellow-200">
    <p class="text-yellow-800">Warning message here</p>
</x-card>
```

---

## ⚠️ **Common Mistakes**

### **Mistake #1: Dropdown Duplicate Options**

```blade
<!-- ❌ WRONG -->
<x-select name="lab_id">
    <option value="">Select lab</option>  ← Duplicate!
    @foreach($labs as $lab)...
</x-select>

<!-- ✅ CORRECT -->
<x-select name="lab_id" placeholder="Select lab">
    @foreach($labs as $lab)...
</x-select>
```

---

### **Mistake #2: Textarea Slot Content**

```blade
<!-- ❌ WRONG -->
<x-textarea name="notes">{{ $value }}</x-textarea>

<!-- ✅ CORRECT -->
<x-textarea name="notes" :value="$value" />
```

---

### **Mistake #3: Field Name Mismatch**

```blade
<!-- ❌ WRONG - Plural/singular mismatch -->
<x-input name="storage_conditions" />  ← Plural
<!-- Controller expects: storage_condition (singular) -->

<!-- ✅ CORRECT - Match database column name -->
<x-input name="storage_condition" />  ← Singular
```

---

### **Mistake #4: Missing :value Binding**

```blade
<!-- ❌ WRONG - Value tidak ter-bind -->
<x-textarea name="desc" value="{{ $model->desc }}" />

<!-- ✅ CORRECT - Use colon for binding -->
<x-textarea name="desc" :value="$model->desc ?? ''" />
```

---

### **Mistake #5: Date Format Mismatch**

```blade
<!-- ❌ WRONG - Date object tidak auto-format -->
<x-input type="date" value="{{ $model->date }}" />

<!-- ✅ CORRECT - Format to Y-m-d -->
<x-input type="date" value="{{ $model->date?->format('Y-m-d') }}" />
```

---

## 🧪 **Testing Checklist**

Before submitting PR with new form:

- [ ] All dropdowns use `placeholder` prop (no manual empty options)
- [ ] All textareas use `:value` prop (not slot content)
- [ ] All field names match database columns exactly (singular/plural)
- [ ] Date fields use `->format('Y-m-d')`
- [ ] Required fields have `*` in label
- [ ] All fields have `@error` directive
- [ ] Form submission tested (create + update)
- [ ] Validation errors display correctly

---

## 📞 **Need Help?**

- **Documentation:** This file
- **Component Source:** `resources/views/components/`
- **Bug Reports:** Create issue with label `component-bug`
- **Questions:** Ask in #frontend Slack channel

---

**Happy Coding!** 🚀

**Last Updated:** 2025-10-22 by Claude & Anton
