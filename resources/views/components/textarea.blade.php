@props([
    'label' => null,
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'rows' => 4,
    'maxlength' => null,
    'showCounter' => false,
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
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            @if($maxlength) maxlength="{{ $maxlength }}" @endif
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            {{ $attributes->except(['class', 'label', 'hint', 'error']) }}
            @if($showCounter && $maxlength) x-data="{ count: {{ strlen(old($name, $value)) }} }" x-on:input="count = $el.value.length" @endif
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm
                   focus:border-[#0066CC] focus:ring-[#0066CC] focus:ring-1
                   disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed
                   resize-y
                   {{ $error ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '' }}"
        >{{ old($name, $value) }}</textarea>

        @if($showCounter && $maxlength)
            <div class="absolute bottom-2 right-2 text-xs text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 px-2 py-1 rounded">
                <span x-text="count"></span> / {{ $maxlength }}
            </div>
        @endif
    </div>

    @if($hint && !$error)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
