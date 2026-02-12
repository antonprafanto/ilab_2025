<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <!-- Master Data Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="top" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('laboratories.*') || request()->routeIs('rooms.*') || request()->routeIs('equipment.*') || request()->routeIs('samples.*') || request()->routeIs('reagents.*') ? 'border-indigo-400 dark:border-indigo-600' : 'border-transparent' }} text-sm font-medium leading-5 {{ request()->routeIs('laboratories.*') || request()->routeIs('rooms.*') || request()->routeIs('equipment.*') || request()->routeIs('samples.*') || request()->routeIs('reagents.*') ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400' }} hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                    <div>Master Data</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('laboratories.index')">
                                    Laboratories
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('rooms.index')">
                                    Rooms
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('equipment.index')">
                                    Equipment
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('samples.index')">
                                    Samples
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('reagents.index')">
                                    Reagents
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Operations Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="top" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('maintenance.*') || request()->routeIs('calibration.*') || request()->routeIs('sops.*') ? 'border-indigo-400 dark:border-indigo-600' : 'border-transparent' }} text-sm font-medium leading-5 {{ request()->routeIs('maintenance.*') || request()->routeIs('calibration.*') || request()->routeIs('sops.*') ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400' }} hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                    <div>Operations</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('maintenance.index')">
                                    Maintenance
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('calibration.index')">
                                    Calibration
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('sops.index')">
                                    SOPs
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Services Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="top" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('services.*') || request()->routeIs('service-requests.*') ? 'border-indigo-400 dark:border-indigo-600' : 'border-transparent' }} text-sm font-medium leading-5 {{ request()->routeIs('services.*') || request()->routeIs('service-requests.*') ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400' }} hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                    <div>Services</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('services.index')">
                                    Service Catalog
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('service-requests.index')">
                                    Service Requests
                                </x-dropdown-link>
                                @can('verify-service-requests')
                                <x-dropdown-link :href="route('service-requests.pending-approval')">
                                    <span class="flex items-center">
                                        Pending Approval
                                        @php
                                            $user = auth()->user();
                                            $statusToCheck = 'pending';
                                            if ($user->hasRole(['Super Admin', 'TU & Keuangan'])) {
                                                $statusToCheck = 'pending';
                                            } elseif ($user->hasRole('Direktur')) {
                                                $statusToCheck = 'verified';
                                            } elseif ($user->hasRole('Wakil Direktur')) {
                                                $statusToCheck = 'approved';
                                            }
                                            $pendingCount = \App\Models\ServiceRequest::where('status', $statusToCheck)->count();
                                        @endphp
                                        @if($pendingCount > 0)
                                        <span class="ml-2 px-2 py-0.5 text-xs font-bold rounded-full bg-red-500 text-white">
                                            {{ $pendingCount }}
                                        </span>
                                        @endif
                                    </span>
                                </x-dropdown-link>
                                @endcan
                                <x-dropdown-link :href="route('service-requests.tracking')">
                                    Track Request
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Booking Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="top" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('bookings.*') ? 'border-indigo-400 dark:border-indigo-600' : 'border-transparent' }} text-sm font-medium leading-5 {{ request()->routeIs('bookings.*') ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400' }} hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                    <div>Booking</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('bookings.calendar')">
                                    Calendar
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('bookings.my-bookings')">
                                    My Bookings
                                </x-dropdown-link>
                                @can('view-users')
                                <x-dropdown-link :href="route('bookings.index')">
                                    All Bookings
                                </x-dropdown-link>
                                @endcan
                                @if(auth()->user()->hasRole(['Kepala Lab']))
                                <x-dropdown-link :href="route('bookings.approval-queue')">
                                    <span class="flex items-center">
                                        Approval Queue
                                        @php
                                            $user = auth()->user();
                                            $labIds = \App\Models\Laboratory::where('head_user_id', $user->id)->pluck('id');
                                            $pendingBookings = \App\Models\Booking::whereIn('laboratory_id', $labIds)->where('status', 'pending')->count();
                                        @endphp
                                        @if($pendingBookings > 0)
                                        <span class="ml-2 px-2 py-0.5 text-xs font-bold rounded-full bg-red-500 text-white">
                                            {{ $pendingBookings }}
                                        </span>
                                        @endif
                                    </span>
                                </x-dropdown-link>
                                @endif
                                <x-dropdown-link :href="route('bookings.kiosk')">
                                    Check-in Kiosk
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    @can('view-users')
                    <!-- User Management Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="top" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('users.*') || request()->routeIs('admin.user-approvals.*') ? 'border-indigo-400 dark:border-indigo-600' : 'border-transparent' }} text-sm font-medium leading-5 {{ request()->routeIs('users.*') || request()->routeIs('admin.user-approvals.*') ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400' }} hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                    <div>Users</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('users.index')">
                                    All Users
                                </x-dropdown-link>
                                @if(auth()->user()->hasRole('Super Admin'))
                                <x-dropdown-link :href="route('admin.user-approvals.index')">
                                    <span class="flex items-center">
                                        Pending Approvals
                                        @php
                                            $pendingUsers = \App\Models\User::where('approval_status', 'pending')->count();
                                        @endphp
                                        @if($pendingUsers > 0)
                                        <span class="ml-2 px-2 py-0.5 text-xs font-bold rounded-full bg-yellow-500 text-white">
                                            {{ $pendingUsers }}
                                        </span>
                                        @endif
                                    </span>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.user-approvals.approved')">
                                    Approved Users
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.user-approvals.rejected')">
                                    Rejected Users
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.user-approvals.rejected')">
                                    Rejected Users
                                </x-dropdown-link>
                                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                                <x-dropdown-link :href="route('admin.public-documents.index')">
                                    Dokumen Publik
                                </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->full_name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <!-- Master Data Section -->
            <div class="px-4 pt-2 pb-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Master Data
            </div>
            <x-responsive-nav-link :href="route('laboratories.index')" :active="request()->routeIs('laboratories.*')">
                Laboratories
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.*')">
                Rooms
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('equipment.index')" :active="request()->routeIs('equipment.*')">
                Equipment
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('samples.index')" :active="request()->routeIs('samples.*')">
                Samples
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reagents.index')" :active="request()->routeIs('reagents.*')">
                Reagents
            </x-responsive-nav-link>

            <!-- Operations Section -->
            <div class="px-4 pt-2 pb-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Operations
            </div>
            <x-responsive-nav-link :href="route('maintenance.index')" :active="request()->routeIs('maintenance.*')">
                Maintenance
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('calibration.index')" :active="request()->routeIs('calibration.*')">
                Calibration
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('sops.index')" :active="request()->routeIs('sops.*')">
                SOPs
            </x-responsive-nav-link>

            <!-- Services Section -->
            <div class="px-4 pt-2 pb-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Services
            </div>
            <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')">
                Service Catalog
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('service-requests.index')" :active="request()->routeIs('service-requests.*')">
                Service Requests
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('service-requests.tracking')" :active="request()->routeIs('service-requests.tracking')">
                Track Request
            </x-responsive-nav-link>

            @can('view-users')
            <div class="px-4 pt-2 pb-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Administration
            </div>
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                Users
            </x-responsive-nav-link>
            @if(auth()->user()->hasRole('Super Admin'))
            <x-responsive-nav-link :href="route('admin.public-documents.index')" :active="request()->routeIs('admin.public-documents.*')">
                Dokumen Publik
            </x-responsive-nav-link>
            @endif
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->full_name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
