<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number', 50)->unique()->comment('Format: BOOK-YYYYMMDD-XXXX');

            // Relationships
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('User who booked');
            $table->foreignId('laboratory_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->nullable()->constrained()->onDelete('set null')->comment('Specific equipment if needed');
            $table->foreignId('service_request_id')->nullable()->constrained()->onDelete('set null')->comment('Link to service request');

            // Booking Details
            $table->enum('booking_type', ['research', 'testing', 'training', 'maintenance', 'other'])->default('research');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->text('purpose');

            // Schedule
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('duration_hours', 4, 2)->comment('Calculated duration');

            // Recurring Bookings
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurrence_pattern', ['daily', 'weekly', 'monthly'])->nullable();
            $table->date('recurrence_end_date')->nullable();
            $table->foreignId('parent_booking_id')->nullable()->constrained('bookings')->onDelete('cascade');

            // Status Workflow
            $table->enum('status', [
                'pending',        // Submitted, awaiting approval
                'approved',       // Approved by Kepala Lab
                'confirmed',      // User confirmed booking
                'checked_in',     // User arrived
                'in_progress',    // Currently using
                'checked_out',    // User left
                'completed',      // Session completed
                'cancelled',      // Cancelled by user/admin
                'no_show'         // User didn't show up
            ])->default('pending');

            // Approval
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_notes')->nullable();

            // Check-in/out
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('checked_out_by')->nullable()->constrained('users')->onDelete('set null');

            // Cancellation
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();

            // Additional Info
            $table->integer('expected_participants')->default(1);
            $table->text('special_requirements')->nullable();
            $table->text('internal_notes')->nullable()->comment('JSON for staff notes');

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['laboratory_id', 'booking_date', 'start_time']);
            $table->index(['equipment_id', 'booking_date', 'start_time']);
            $table->index(['user_id', 'status']);
            $table->index('booking_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
