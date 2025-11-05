<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Calibration Record</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('calibration.update', $calibration) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('calibration.partials.form')
            </form>
        </div>
    </div>
</x-app-layout>
