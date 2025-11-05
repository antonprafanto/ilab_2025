@props([
    'title' => '',
    'value' => '0',
    'icon' => null,
    'iconColor' => 'blue', // blue, green, orange, red, purple
    'trend' => null, // up, down
    'trendValue' => null,
    'description' => null,
])

@php
    // Icon background colors
    $iconBgColors = [
        'blue' => 'bg-blue-100 dark:bg-blue-900/30',
        'green' => 'bg-green-100 dark:bg-green-900/30',
        'orange' => 'bg-orange-100 dark:bg-orange-900/30',
        'red' => 'bg-red-100 dark:bg-red-900/30',
        'purple' => 'bg-purple-100 dark:bg-purple-900/30',
        'yellow' => 'bg-yellow-100 dark:bg-yellow-900/30',
    ];

    // Icon text colors
    $iconTextColors = [
        'blue' => 'text-[#0066CC]',
        'green' => 'text-[#4CAF50]',
        'orange' => 'text-[#FF9800]',
        'red' => 'text-[#E53935]',
        'purple' => 'text-purple-600',
        'yellow' => 'text-yellow-600',
    ];

    $iconBg = $iconBgColors[$iconColor] ?? $iconBgColors['blue'];
    $iconText = $iconTextColors[$iconColor] ?? $iconTextColors['blue'];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6']) }}>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                {{ $title }}
            </p>
            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                {{ $value }}
            </p>

            @if($trend || $description)
                <div class="mt-2 flex items-center space-x-2">
                    @if($trend && $trendValue)
                        <span class="inline-flex items-center text-sm {{ $trend === 'up' ? 'text-green-600' : 'text-red-600' }}">
                            @if($trend === 'up')
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                            {{ $trendValue }}
                        </span>
                    @endif

                    @if($description)
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $description }}
                        </span>
                    @endif
                </div>
            @endif
        </div>

        @if($icon)
            <div class="{{ $iconBg }} p-3 rounded-lg">
                <i class="{{ $icon }} {{ $iconText }} text-2xl"></i>
            </div>
        @endif
    </div>

    @if(isset($footer))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            {{ $footer }}
        </div>
    @endif
</div>
