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
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();

            // Equipment Reference
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();

            // Maintenance Information
            $table->string('maintenance_code', 50)->unique(); // MAINT-EQ-001-2025-001
            $table->enum('type', [
                'preventive',     // Pemeliharaan Preventif
                'corrective',     // Pemeliharaan Korektif
                'breakdown',      // Perbaikan Kerusakan
                'inspection',     // Inspeksi Rutin
                'cleaning',       // Pembersihan
                'calibration',    // Kalibrasi (ringan)
                'replacement',    // Penggantian Parts
            ]);
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');

            // Schedule
            $table->date('scheduled_date');
            $table->date('completed_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('duration_hours')->nullable(); // Auto-calculated

            // Status
            $table->enum('status', [
                'scheduled',      // Dijadwalkan
                'in_progress',    // Sedang Dikerjakan
                'completed',      // Selesai
                'cancelled',      // Dibatalkan
                'postponed',      // Ditunda
            ])->default('scheduled');

            // Work Details
            $table->text('description')->nullable();              // Deskripsi pekerjaan
            $table->text('work_performed')->nullable();           // Pekerjaan yang dilakukan
            $table->text('parts_replaced')->nullable();           // Parts yang diganti
            $table->text('findings')->nullable();                 // Temuan
            $table->text('recommendations')->nullable();          // Rekomendasi

            // Personnel
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete(); // Teknisi
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();  // Verifikator

            // Cost & Parts
            $table->decimal('labor_cost', 12, 2)->nullable();
            $table->decimal('parts_cost', 12, 2)->nullable();
            $table->decimal('total_cost', 12, 2)->nullable();

            // Attachments
            $table->json('attachments')->nullable();              // Photos, documents

            // Next Maintenance
            $table->date('next_maintenance_date')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('scheduled_date');
            $table->index('completed_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_records');
    }
};
