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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();

            // Request Information
            $table->string('request_number', 50)->unique()->comment('Format: SR-YYYYMMDD-XXXX');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('Requester');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');

            // Request Details
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['standard', 'urgent'])->default('standard');
            $table->boolean('is_urgent')->default(false);
            $table->text('urgency_reason')->nullable()->comment('Why urgent?');

            // Sample Information (Step 2)
            $table->integer('sample_count')->default(1);
            $table->string('sample_type')->nullable()->comment('e.g., liquid, solid, gas');
            $table->text('sample_description')->nullable();
            $table->text('sample_preparation')->nullable();
            $table->json('sample_details')->nullable()->comment('Array of samples if multiple');

            // Research Information (Step 3)
            $table->string('research_title')->nullable();
            $table->text('research_objective')->nullable();
            $table->string('institution')->nullable();
            $table->string('department')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_contact')->nullable();

            // File Uploads
            $table->string('proposal_file')->nullable();
            $table->json('supporting_documents')->nullable()->comment('Array of file paths');

            // Scheduling
            $table->date('preferred_date')->nullable();
            $table->time('preferred_time')->nullable();
            $table->date('estimated_completion_date')->nullable();
            $table->date('actual_completion_date')->nullable();

            // Status & Workflow
            $table->enum('status', [
                'pending',           // Submitted, waiting verification
                'verified',          // Admin verified
                'approved',          // Direktur/Wakil Dir approved
                'assigned',          // Assigned to Kepala Lab
                'in_progress',       // Testing in progress
                'testing',           // Analysis ongoing
                'completed',         // Completed
                'rejected',          // Rejected
                'cancelled'          // Cancelled by user
            ])->default('pending');
            $table->text('status_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // Assignment
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null')->comment('Assigned Kepala Lab');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');

            // Pricing
            $table->decimal('quoted_price', 12, 2)->nullable();
            $table->decimal('final_price', 12, 2)->nullable();
            $table->boolean('is_paid')->default(false);

            // Metadata
            $table->text('notes')->nullable()->comment('Internal notes');
            $table->text('rejection_reason')->nullable();
            $table->integer('view_count')->default(0)->comment('Tracking views');

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('request_number');
            $table->index('user_id');
            $table->index('service_id');
            $table->index('status');
            $table->index('priority');
            $table->index('is_urgent');
            $table->index('assigned_to');
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
