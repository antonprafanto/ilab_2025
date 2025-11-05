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
        'primary' => 'bg-[#0066CC] hover:bg-[#0052A3] text-white border-transparent shadow-sm',
        'secondary' => 'bg-[#FF9800] hover:bg-[#E68900] text-white border-transparent shadow-sm',
        'success' => 'bg-[#4CAF50] hover:bg-[#45A049] text-white border-transparent shadow-sm',
        'danger' => 'bg-[#E53935] hover:bg-[#C62828] text-white border-transparent shadow-sm',
        'warning' => 'bg-[#FFC107] hover:bg-[#FFB300] text-gray-900 border-transparent shadow-sm',
        'info' => 'bg-[#2196F3] hover:bg-[#1976D2] text-white border-transparent shadow-sm',
        'dark' => 'bg-gray-800 hover:bg-gray-900 text-white border-transparent shadow-sm',
        'light' => 'bg-white hover:bg-gray-50 text-gray-700 border-gray-300 shadow-sm',
        'outline-primary' => 'bg-transparent hover:bg-[#0066CC] text-[#0066CC] hover:text-white border-[#0066CC]',
        'outline-secondary' => 'bg-transparent hover:bg-[#FF9800] text-[#FF9800] hover:text-white border-[#FF9800]',
        'outline-danger' => 'bg-transparent hover:bg-[#E53935] text-[#E53935] hover:text-white border-[#E53935]',
        'ghost' => 'bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 border-transparent',
        'link' => 'bg-transparent hover:bg-transparent text-[#0066CC] hover:text-[#0052A3] border-transparent underline-offset-4 hover:underline shadow-none',
    ];

    // Size classes
    $sizeClasses = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
        'xl' => 'px-6 py-3 text-base',
    ];

    // Base classes
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-md border transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0066CC] disabled:opacity-50 disabled:cursor-not-allowed';

    // Combine classes
    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);

    // If loading or disabled
    $isDisabled = $disabled || $loading;
@endphp

@if($href)
    {{-- Render as link --}}
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }} @if($isDisabled) aria-disabled="true" @endif>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            <i class="{{ $icon }} -ml-1 mr-2"></i>
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }} ml-2 -mr-1"></i>
        @endif
    </a>
@else
    {{-- Render as button --}}
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($isDisabled) disabled @endif>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            <i class="{{ $icon }} -ml-1 mr-2"></i>
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }} ml-2 -mr-1"></i>
        @endif
    </button>
@endif
