@props(['for' => '', 'required' => false])

<label {{ $attributes->merge(['for' => $for, 'class' => 'block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1']) }}>
    {{ $slot }}
    @if($required)
        <span class="text-red-500">*</span>
    @endif
</label>
