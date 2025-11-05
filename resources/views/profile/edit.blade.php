<x-app-layout>
    <!-- Enhanced Notification -->
    <x-notification />

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profile') }}
            </h2>
            <div class="flex items-center space-x-3">
                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="h-10 w-10 rounded-full ring-2 ring-[--color-unmul-blue]">
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ auth()->user()->full_name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->getRoleNames()->first() }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Extended Profile Information -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    @include('profile.partials.update-extended-profile-form')
                </div>
            </div>

            <!-- Basic Profile Information -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
