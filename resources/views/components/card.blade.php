@props([
    'title' => null,
    'subtitle' => null,
    'header' => null,
    'footer' => null,
    'padding' => 'normal', // normal, sm, lg, none
    'shadow' => 'sm', // none, sm, md, lg, xl
])

@php
    // Padding classes
    $paddingClasses = [
        'none' => '',
        'sm' => 'p-4',
        'normal' => 'p-6',
        'lg' => 'p-8',
    ];

    // Shadow classes
    $shadowClasses = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow-md',
        'lg' => 'shadow-lg',
        'xl' => 'shadow-xl',
    ];

    $bodyPadding = $paddingClasses[$padding] ?? $paddingClasses['normal'];
    $shadowClass = $shadowClasses[$shadow] ?? $shadowClasses['sm'];
@endphp

<div {{ $attributes->merge(['class' => "bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden {$shadowClass}"]) }}>
    @if($header || $title)
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            @if($header)
                {{ $header }}
            @else
                <div>
                    @if($title)
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $title }}
                        </h3>
                    @endif
                    @if($subtitle)
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ $subtitle }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $bodyPadding }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
            {{ $footer }}
        </div>
    @endif
</div>
