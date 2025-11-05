<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\ReagentController;
use App\Http\Controllers\SopController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\CalibrationRecordController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Get statistics from database
    $stats = [
        'laboratories' => \App\Models\Laboratory::count(),
        'services' => \App\Models\Service::count(),
        'equipment' => \App\Models\Equipment::count(),
        'users' => \App\Models\User::approved()->count(), // Only approved users
    ];

    return view('welcome', compact('stats'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/extended', [ProfileController::class, 'updateProfile'])->name('profile.update.extended');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Management
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);

    // User Approval Management (Admin only)
    Route::prefix('admin')->name('admin.')->middleware('role:Super Admin')->group(function () {
        Route::get('/user-approvals', [\App\Http\Controllers\Admin\UserApprovalController::class, 'index'])->name('user-approvals.index');
        Route::post('/user-approvals/{user}/approve', [\App\Http\Controllers\Admin\UserApprovalController::class, 'approve'])->name('user-approvals.approve');
        Route::post('/user-approvals/{user}/reject', [\App\Http\Controllers\Admin\UserApprovalController::class, 'reject'])->name('user-approvals.reject');
        Route::get('/user-approvals/approved', [\App\Http\Controllers\Admin\UserApprovalController::class, 'approved'])->name('user-approvals.approved');
        Route::get('/user-approvals/rejected', [\App\Http\Controllers\Admin\UserApprovalController::class, 'rejected'])->name('user-approvals.rejected');
    });
});

// Equipment Management
Route::middleware('auth')->group(function () {
    Route::resource('equipment', EquipmentController::class);
});

// UI Components Demo (untuk development)
Route::middleware('auth')->get('/components', function () {
    return view('components.demo');
})->name('components.demo');

// Laboratory Management
Route::middleware('auth')->group(function () {
    Route::resource('laboratories', LaboratoryController::class);
});

// Room Management
Route::middleware('auth')->group(function () {
    Route::resource('rooms', RoomController::class);
});

// Sample Management
Route::middleware('auth')->group(function () {
    Route::resource('samples', SampleController::class);
});

// Reagent Management
Route::middleware('auth')->group(function () {
    Route::resource('reagents', ReagentController::class);
});

// SOP Management
Route::middleware('auth')->group(function () {
    Route::resource('sops', SopController::class);
});

// Maintenance Management
Route::middleware('auth')->group(function () {
    Route::resource('maintenance', MaintenanceRecordController::class);
});

// Calibration Management
Route::middleware('auth')->group(function () {
    Route::resource('calibration', CalibrationRecordController::class);
});

// Service Catalog
Route::middleware('auth')->group(function () {
    Route::resource('services', ServiceController::class);
});

// Service Request System (Chapter 10)
// Public tracking routes (no auth required)
Route::get('/tracking', [ServiceRequestController::class, 'tracking'])->name('service-requests.tracking');
Route::post('/tracking', [ServiceRequestController::class, 'tracking']);

Route::middleware('auth')->group(function () {

    // Main resource routes
    Route::resource('service-requests', ServiceRequestController::class);

    // Workflow action routes
    Route::post('service-requests/{serviceRequest}/verify', [ServiceRequestController::class, 'verify'])->name('service-requests.verify');
    Route::post('service-requests/{serviceRequest}/approve', [ServiceRequestController::class, 'approve'])->name('service-requests.approve');
    Route::post('service-requests/{serviceRequest}/assign-lab', [ServiceRequestController::class, 'assignLab'])->name('service-requests.assign-lab');
    Route::post('service-requests/{serviceRequest}/assign', [ServiceRequestController::class, 'assign'])->name('service-requests.assign');
    Route::post('service-requests/{serviceRequest}/start-progress', [ServiceRequestController::class, 'startProgress'])->name('service-requests.start-progress');
    Route::post('service-requests/{serviceRequest}/start-testing', [ServiceRequestController::class, 'startTesting'])->name('service-requests.start-testing');
    Route::post('service-requests/{serviceRequest}/complete', [ServiceRequestController::class, 'complete'])->name('service-requests.complete');
    Route::post('service-requests/{serviceRequest}/reject', [ServiceRequestController::class, 'reject'])->name('service-requests.reject');

    // Internal Notes (Chapter 12)
    Route::post('service-requests/{serviceRequest}/add-note', [ServiceRequestController::class, 'addNote'])->name('service-requests.add-note');

    // Approval Workflow Routes (Chapter 11)
    Route::get('service-requests/pending-approval', [ServiceRequestController::class, 'pendingApproval'])->name('service-requests.pending-approval');
});

// Booking & Scheduling System (Chapter 13 & 14)
Route::middleware('auth')->group(function () {

    // Calendar routes (must be before resource routes)
    Route::get('bookings/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('bookings/events', [BookingController::class, 'events'])->name('bookings.events');

    // Special view routes
    Route::get('bookings/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my-bookings');
    Route::get('bookings/approval-queue', [BookingController::class, 'approvalQueue'])->name('bookings.approval-queue');
    Route::get('bookings/kiosk', [BookingController::class, 'kiosk'])->name('bookings.kiosk');

    // Workflow action routes
    Route::post('bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
    Route::post('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('bookings/{booking}/check-in', [BookingController::class, 'checkIn'])->name('bookings.check-in');
    Route::post('bookings/{booking}/check-out', [BookingController::class, 'checkOut'])->name('bookings.check-out');
    Route::post('bookings/{booking}/no-show', [BookingController::class, 'markNoShow'])->name('bookings.no-show');

    // Main resource routes
    Route::resource('bookings', BookingController::class);
});

require __DIR__.'/auth.php';
