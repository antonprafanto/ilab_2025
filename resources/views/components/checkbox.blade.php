@props([
    'label' => null,
    'name' => '',
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'description' => null,
])

<div {{ $attributes->only('class') }}>
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input
                type="checkbox"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ $value }}"
                @if($checked || old($name)) checked @endif
                @if($disabled) disabled @endif
                {{ $attributes->except(['class', 'label', 'hint', 'error', 'description']) }}
                class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700
                       text-[#0066CC] focus:ring-[#0066CC] focus:ring-2 focus:ring-offset-2
                       disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed
                       {{ $error ? 'border-red-300' : '' }}"
            />
        </div>

        @if($label || $description)
            <div class="ml-3 text-sm">
                @if($label)
                    <label for="{{ $name }}" class="font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
                        {{ $label }}
                    </label>
                @endif

                @if($description)
                    <p class="text-gray-500 dark:text-gray-400">{{ $description }}</p>
                @endif
            </div>
        @endif
    </div>

    @if($hint && !$error)
        <p class="mt-1 ml-7 text-sm text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="mt-1 ml-7 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
