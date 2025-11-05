@props([
    'tabs' => [],
    'active' => null,
    'style' => 'underline',
])

@php
    $activeTab = $active ?? (isset($tabs[0]['id']) ? $tabs[0]['id'] : null);
@endphp

<div {{ $attributes }} x-data="{ activeTab: '{{ $activeTab }}' }">
    {{-- Tab Headers --}}
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            @foreach($tabs as $tab)
                <button
                    @click="activeTab = '{{ $tab['id'] }}'"
                    :class="{
                        @if($style === 'underline')
                        'border-[#0066CC] text-[#0066CC]': activeTab === '{{ $tab['id'] }}',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== '{{ $tab['id'] }}'
                        @elseif($style === 'pills')
                        'bg-[#0066CC] text-white': activeTab === '{{ $tab['id'] }}',
                        'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== '{{ $tab['id'] }}'
                        @endif
                    }"
                    class="
                        @if($style === 'underline')
                        whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                        @elseif($style === 'pills')
                        whitespace-nowrap py-2 px-4 rounded-md font-medium text-sm transition-all
                        @endif
                    "
                >
                    @if(isset($tab['icon']))
                        <i class="{{ $tab['icon'] }} mr-2"></i>
                    @endif
                    {{ $tab['label'] }}
                    @if(isset($tab['badge']))
                        <span
                            :class="activeTab === '{{ $tab['id'] }}' ? 'bg-white text-[#0066CC]' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400'"
                            class="ml-2 py-0.5 px-2 rounded-full text-xs">
                            {{ $tab['badge'] }}
                        </span>
                    @endif
                </button>
            @endforeach
        </nav>
    </div>

    {{-- Tab Content --}}
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
