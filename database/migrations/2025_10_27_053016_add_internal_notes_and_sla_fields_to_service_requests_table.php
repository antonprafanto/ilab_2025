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
        Schema::table('service_requests', function (Blueprint $table) {
            // Internal Notes System (JSON field for staff notes)
            $table->text('internal_notes')->nullable()->after('status_notes')
                ->comment('JSON array of internal notes with user_id, note, created_at');

            // Multi-stage SLA Tracking
            $table->timestamp('sla_deadline_verification')->nullable()->after('submitted_at')
                ->comment('Deadline for verification (24h from submission)');
            $table->timestamp('sla_deadline_approval')->nullable()->after('verified_at')
                ->comment('Deadline for approval (24h from verification)');
            $table->timestamp('sla_deadline_assignment')->nullable()->after('approved_at')
                ->comment('Deadline for lab assignment (24h from approval)');

            // Additional timestamp tracking
            $table->timestamp('lab_assigned_at')->nullable()->after('assigned_at')
                ->comment('When assigned to lab');
            $table->foreignId('assigned_to_lab_id')->nullable()->after('assigned_to')
                ->constrained('laboratories')->onDelete('set null')
                ->comment('Laboratory assigned to handle request');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'internal_notes',
                'sla_deadline_verification',
                'sla_deadline_approval',
                'sla_deadline_assignment',
                'lab_assigned_at',
            ]);
            $table->dropForeign(['assigned_to_lab_id']);
            $table->dropColumn('assigned_to_lab_id');
        });
    }
};
