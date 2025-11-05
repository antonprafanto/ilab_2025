@props([
    'items' => [],
    'separator' => 'chevron',
])

@php
    $separators = [
        'chevron' => '<svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>',
        'slash' => '<span class="text-gray-400">/</span>',
        'arrow' => '<span class="text-gray-400">→</span>',
        'dot' => '<span class="text-gray-400">•</span>',
    ];

    $separatorHtml = $separators[$separator] ?? $separators['chevron'];
@endphp

<nav {{ $attributes->merge(['class' => 'flex']) }} aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach($items as $index => $item)
            <li class="inline-flex items-center">
                @if($index > 0)
                    {!! $separatorHtml !!}
                @endif

                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-[#0066CC] dark:hover:text-[#0066CC] transition-colors">
                        @if(isset($item['icon']))
                            <i class="{{ $item['icon'] }} mr-2"></i>
                        @endif
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="inline-flex items-center text-sm font-medium text-gray-500 dark:text-gray-500">
                        @if(isset($item['icon']))
                            <i class="{{ $item['icon'] }} mr-2"></i>
                        @endif
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
