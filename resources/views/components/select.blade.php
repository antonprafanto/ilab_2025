@props([
    'label' => null,
    'name' => '',
    'value' => '',
    'options' => [],
    'placeholder' => 'Pilih salah satu...',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'multiple' => false,
    'searchable' => false,
])

<div {{ $attributes->only('class') }}>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <select
            id="{{ $name }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($multiple) multiple @endif
            {{ $attributes->except(['class', 'label', 'hint', 'error']) }}
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm
                   focus:border-[#0066CC] focus:ring-[#0066CC] focus:ring-1
                   disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed
                   {{ $error ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '' }}"
        >
            @if(!$multiple && $placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif

            @if(isset($slot) && $slot != '')
                {{ $slot }}
            @else
                @foreach($options as $optionValue => $optionLabel)
                    <option
                        value="{{ $optionValue }}"
                        {{ old($name, $value) == $optionValue ? 'selected' : '' }}
                    >
                        {{ $optionLabel }}
                    </option>
                @endforeach
            @endif
        </select>

        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>

    @if($hint && !$error)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
