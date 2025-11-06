<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Scripts Stack -->
        @stack('scripts')

        <!-- Beta Banner Script -->
        <script>
            // Toggle Dashboard Beta Banner Function (Minimize/Maximize)
            function toggleDashboardBetaBanner() {
                const bannerContent = document.getElementById('dashboard-beta-content');
                const bannerMinimized = document.getElementById('dashboard-beta-minimized');

                if (bannerContent && bannerMinimized) {
                    if (bannerContent.classList.contains('hidden')) {
                        // Show full banner
                        bannerContent.classList.remove('hidden');
                        bannerMinimized.classList.add('hidden');
                        localStorage.setItem('dashboardBetaBannerMinimized', 'false');
                    } else {
                        // Minimize banner
                        bannerContent.classList.add('hidden');
                        bannerMinimized.classList.remove('hidden');
                        localStorage.setItem('dashboardBetaBannerMinimized', 'true');
                    }
                }
            }

            // Check if banner was previously minimized on page load
            document.addEventListener('DOMContentLoaded', function() {
                const bannerMinimized = localStorage.getItem('dashboardBetaBannerMinimized');
                if (bannerMinimized === 'true') {
                    const bannerContent = document.getElementById('dashboard-beta-content');
                    const bannerMinimizedDiv = document.getElementById('dashboard-beta-minimized');
                    if (bannerContent && bannerMinimizedDiv) {
                        bannerContent.classList.add('hidden');
                        bannerMinimizedDiv.classList.remove('hidden');
                    }
                }
            });
        </script>
    </body>
</html>
