<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kalender Booking') }}
            </h2>
            <a href="{{ route('bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Booking Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filters --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filter</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Laboratory Filter --}}
                        <div>
                            <label for="filter_laboratory" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Laboratorium
                            </label>
                            <select id="filter_laboratory" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Laboratorium</option>
                                @foreach($laboratories as $lab)
                                    <option value="{{ $lab->id }}">{{ $lab->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Equipment Filter --}}
                        <div>
                            <label for="filter_equipment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Alat
                            </label>
                            <select id="filter_equipment" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Alat</option>
                                @foreach($equipment as $equip)
                                    <option value="{{ $equip->id }}">{{ $equip->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Calendar --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== CALENDAR INIT ===');

            var calendarEl = document.getElementById('calendar');

            if (!calendarEl) {
                console.error('Calendar element not found');
                return;
            }

            if (typeof FullCalendar === 'undefined' || !FullCalendar.Calendar) {
                console.error('FullCalendar not loaded from Vite');
                calendarEl.innerHTML = '<div style="padding: 20px; background: #ffebee; border: 2px solid #f44336; border-radius: 5px;">' +
                    '<h3 style="color: #d32f2f;">Calendar Error</h3>' +
                    '<p>FullCalendar library not loaded. Please run: npm run build</p></div>';
                return;
            }

            console.log('✓ FullCalendar loaded, initializing...');

            try {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [
                        FullCalendar.dayGridPlugin,
                        FullCalendar.timeGridPlugin,
                        FullCalendar.interactionPlugin
                    ],
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    buttonText: {
                        today: 'Hari Ini',
                        month: 'Bulan',
                        week: 'Minggu',
                        day: 'Hari'
                    },
                    locale: 'id',
                    editable: false,
                    selectable: true,
                    selectMirror: true,
                    dayMaxEvents: true,
                    weekends: true,

                    // Fetch events from API
                    events: function(info, successCallback, failureCallback) {
                        var labId = document.getElementById('filter_laboratory').value;
                        var equipId = document.getElementById('filter_equipment').value;

                        var url = '{{ route("bookings.events") }}';
                        url += '?start=' + info.startStr + '&end=' + info.endStr;

                        if (labId) {
                            url += '&laboratory_id=' + labId;
                        }
                        if (equipId) {
                            url += '&equipment_id=' + equipId;
                        }

                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                console.log('Events loaded:', data.length);
                                successCallback(data);
                            })
                            .catch(error => {
                                console.error('Error fetching events:', error);
                                failureCallback(error);
                            });
                    },

                    // Click on event to view details
                    eventClick: function(info) {
                        window.location.href = info.event.extendedProps.url;
                    },

                    // Drag to select date range and create booking
                    select: function(info) {
                        var startDate = info.startStr;
                        var endDate = info.endStr;
                        var labId = document.getElementById('filter_laboratory').value;

                        var url = '{{ route("bookings.create") }}';
                        url += '?start=' + startDate + '&end=' + endDate;

                        if (labId) {
                            url += '&laboratory_id=' + labId;
                        }

                        window.location.href = url;
                    },

                    // Click on date to create new booking
                    dateClick: function(info) {
                        var url = '{{ route("bookings.create") }}';
                        url += '?date=' + info.dateStr;

                        var labId = document.getElementById('filter_laboratory').value;
                        if (labId) {
                            url += '&laboratory_id=' + labId;
                        }

                        window.location.href = url;
                    },

                    // Event content
                    eventContent: function(arg) {
                        return {
                            html: '<div class="fc-event-main-frame">' +
                                  '<div class="fc-event-time">' + arg.timeText + '</div>' +
                                  '<div class="fc-event-title-container">' +
                                  '<div class="fc-event-title fc-sticky">' + arg.event.title + '</div>' +
                                  '</div>' +
                                  '</div>'
                        };
                    }
                });

                console.log('Rendering calendar...');
                calendar.render();
                console.log('✓ Calendar rendered successfully!');

                // Reload calendar when filters change
                document.getElementById('filter_laboratory').addEventListener('change', function() {
                    console.log('Laboratory filter changed, refetching events...');
                    calendar.refetchEvents();
                });

                document.getElementById('filter_equipment').addEventListener('change', function() {
                    console.log('Equipment filter changed, refetching events...');
                    calendar.refetchEvents();
                });

            } catch (error) {
                console.error('❌ Error initializing calendar:', error);
                console.error('Error stack:', error.stack);

                // Show error message on page
                calendarEl.innerHTML = '<div style="padding: 20px; background: #ffebee; border: 2px solid #f44336; border-radius: 5px; margin: 20px;">' +
                    '<h3 style="color: #d32f2f;">Calendar Initialization Error</h3>' +
                    '<p style="color: #d32f2f;"><strong>Error:</strong> ' + error.message + '</p>' +
                    '<p style="color: #666;">Please check the browser console for more details.</p>' +
                    '</div>';
            }
        });
    </script>

    <style>
        /* Aggressive FullCalendar styling for debugging */
        #calendar {
            height: 600px !important;
            min-height: 400px !important;
            width: 100% !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 1 !important;
            background: white !important;
            border: 3px solid #2196f3 !important;
            margin: 10px 0 !important;
            padding: 10px !important;
            box-sizing: border-box !important;
        }

        /* Ensure FullCalendar container is visible */
        #calendar .fc,
        #calendar .fc-view-harness,
        #calendar .fc-view,
        #calendar .fc-daygrid,
        #calendar .fc-daygrid-body {
            height: 100% !important;
            width: 100% !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Override any hiding styles */
        #calendar * {
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Make sure calendar is not collapsed */
        #calendar .fc-daygrid-day,
        #calendar .fc-daygrid-day-frame {
            min-height: 80px !important;
            height: auto !important;
        }

        /* FullCalendar dark mode styling */
        .dark #calendar {
            --fc-border-color: #374151;
            --fc-button-bg-color: #4f46e5;
            --fc-button-border-color: #4f46e5;
            --fc-button-hover-bg-color: #4338ca;
            --fc-button-hover-border-color: #4338ca;
            --fc-button-active-bg-color: #3730a3;
            --fc-button-active-border-color: #3730a3;
            --fc-event-bg-color: #4f46e5;
            --fc-event-border-color: #4f46e5;
            --fc-event-text-color: #ffffff;
            --fc-page-bg-color: #1f2937;
            --fc-neutral-bg-color: #374151;
            --fc-neutral-text-color: #e5e7eb;
            --fc-list-event-hover-bg-color: #374151;
        }

        .dark .fc-theme-standard th,
        .dark .fc-theme-standard td,
        .dark .fc-theme-standard .fc-scrollgrid {
            border-color: #374151;
        }

        .dark .fc-col-header-cell-cushion,
        .dark .fc-daygrid-day-number {
            color: #e5e7eb;
        }

        .dark .fc-button {
            background-color: #4f46e5 !important;
            border-color: #4f46e5 !important;
        }

        .dark .fc-button:hover {
            background-color: #4338ca !important;
            border-color: #4338ca !important;
        }

        .dark .fc-toolbar-title {
            color: #e5e7eb;
        }
    </style>
    @endpush
</x-app-layout>
