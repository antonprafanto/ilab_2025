<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('reagents.index') }}'" class="mr-4"><i class="fa fa-arrow-left"></i></x-button>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tambah Reagen</h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('reagents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('reagents.partials.form', ['reagent' => null])
            </form>
        </div>
    </div>
</x-app-layout>
