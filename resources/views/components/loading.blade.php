@props([
    'size' => 'md',
    'color' => 'primary',
    'text' => null,
])

@php
    $sizeClasses = [
        'xs' => 'h-4 w-4',
        'sm' => 'h-6 w-6',
        'md' => 'h-8 w-8',
        'lg' => 'h-12 w-12',
        'xl' => 'h-16 w-16',
    ];

    $colorClasses = [
        'primary' => 'border-[#0066CC]',
        'secondary' => 'border-[#FF9800]',
        'success' => 'border-[#4CAF50]',
        'danger' => 'border-[#E53935]',
        'white' => 'border-white',
        'gray' => 'border-gray-500',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $colorClass = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-center']) }}>
    <div class="flex flex-col items-center space-y-3">
        <div class="relative {{ $sizeClass }}">
            <div class="absolute top-0 left-0 {{ $sizeClass }} border-4 border-gray-200 dark:border-gray-700 rounded-full"></div>
            <div class="absolute top-0 left-0 {{ $sizeClass }} border-4 {{ $colorClass }} border-t-transparent rounded-full animate-spin"></div>
        </div>

        @if($text)
            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">{{ $text }}</p>
        @endif
    </div>
</div>
