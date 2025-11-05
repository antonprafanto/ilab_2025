<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('rooms.show', $room) }}'" class="mr-4">
                <i class="fa fa-arrow-left"></i>
            </x-button>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Ruang') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('rooms.update', $room) }}" method="POST">
                @csrf
                @method('PUT')
                @include('rooms.partials.form')
            </form>
        </div>
    </div>
</x-app-layout>
