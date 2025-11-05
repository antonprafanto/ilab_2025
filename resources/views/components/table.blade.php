@props([
    'headers' => [],
    'striped' => true,
    'hoverable' => true,
    'bordered' => false,
    'compact' => false,
])

<div class="overflow-x-auto {{ $attributes->get('class') }}">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        @if(isset($header))
            <thead class="bg-gray-50 dark:bg-gray-800">
                {{ $header }}
            </thead>
        @elseif(!empty($headers))
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            {{ $slot }}
        </tbody>

        @if(isset($footer))
            <tfoot class="bg-gray-50 dark:bg-gray-800">
                {{ $footer }}
            </tfoot>
        @endif
    </table>
</div>

<style>
    @if($striped)
    tbody tr:nth-child(even) {
        background-color: rgba(249, 250, 251, 1);
    }
    .dark tbody tr:nth-child(even) {
        background-color: rgba(17, 24, 39, 0.5);
    }
    @endif

    @if($hoverable)
    tbody tr:hover {
        background-color: rgba(243, 244, 246, 1);
    }
    .dark tbody tr:hover {
        background-color: rgba(31, 41, 55, 1);
    }
    @endif

    @if($bordered)
    table {
        border: 1px solid rgba(229, 231, 235, 1);
    }
    .dark table {
        border-color: rgba(55, 65, 81, 1);
    }
    th, td {
        border: 1px solid rgba(229, 231, 235, 1);
    }
    .dark th, .dark td {
        border-color: rgba(55, 65, 81, 1);
    }
    @endif

    @if($compact)
    th, td {
        padding: 0.5rem 1rem !important;
    }
    @endif
</style>
