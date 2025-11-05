@props([
    'variant' => 'default', // default, primary, secondary, success, danger, warning, info
    'size' => 'md', // sm, md, lg
    'rounded' => 'md', // sm, md, lg, full
    'dot' => false,
])

@php
    // Variant styles
    $variantClasses = [
        'default' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'primary' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
        'secondary' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
        'danger' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
        'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
    ];

    // Size classes
    $sizeClasses = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-0.5 text-sm',
        'lg' => 'px-3 py-1 text-base',
    ];

    // Rounded classes
    $roundedClasses = [
        'sm' => 'rounded',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'full' => 'rounded-full',
    ];

    $classes = 'inline-flex items-center font-medium ' .
                ($variantClasses[$variant] ?? $variantClasses['default']) . ' ' .
                ($sizeClasses[$size] ?? $sizeClasses['md']) . ' ' .
                ($roundedClasses[$rounded] ?? $roundedClasses['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <svg class="-ml-0.5 mr-1.5 h-2 w-2" fill="currentColor" viewBox="0 0 8 8">
            <circle cx="4" cy="4" r="3"/>
        </svg>
    @endif

    {{ $slot }}
</span>
