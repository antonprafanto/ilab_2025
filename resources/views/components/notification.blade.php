@props(['status'])

@if (session('status'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-4 right-4 z-50 max-w-md">

        <div class="rounded-lg shadow-2xl p-4 border-l-4 border-white" style="background: linear-gradient(to right, #4CAF50, #0066CC);">
            <div class="flex items-center space-x-3">
                <!-- Success Icon -->
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <div class="flex-1">
                    <p class="text-sm font-bold text-white">
                        Berhasil!
                    </p>
                    <p class="text-xs text-white/90 mt-1">
                        {{ session('status') === 'profile-updated' ? 'Profile Anda telah berhasil diperbarui!' : 'Perubahan telah disimpan.' }}
                    </p>
                </div>

                <!-- Close Button -->
                <button @click="show = false" class="flex-shrink-0 text-white hover:text-gray-200 transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
