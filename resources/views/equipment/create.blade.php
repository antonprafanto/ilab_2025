<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <x-button variant="ghost" size="sm" onclick="window.location.href='{{ route('equipment.index') }}'" class="mr-4">
                <i class="fa fa-arrow-left"></i>
            </x-button>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Alat Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('equipment.partials.form', ['equipment' => null, 'laboratories' => $laboratories, 'users' => $users])
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
