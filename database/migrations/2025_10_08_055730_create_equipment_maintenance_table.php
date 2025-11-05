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
        Schema::create('equipment_maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();

            $table->enum('type', [
                'preventive',  // Maintenance terjadwal/preventif
                'corrective',  // Perbaikan karena kerusakan
                'emergency'    // Perbaikan darurat
            ]);

            $table->date('scheduled_date'); // Tanggal jadwal maintenance
            $table->date('completed_date')->nullable(); // Tanggal selesai maintenance
            $table->time('duration_hours')->nullable(); // Durasi maintenance

            $table->enum('status', [
                'scheduled',   // Dijadwalkan
                'in_progress', // Sedang dikerjakan
                'completed',   // Selesai
                'cancelled'    // Dibatalkan
            ])->default('scheduled');

            $table->text('description')->nullable(); // Deskripsi pekerjaan
            $table->text('findings')->nullable(); // Temuan saat maintenance
            $table->text('actions_taken')->nullable(); // Tindakan yang dilakukan
            $table->text('recommendations')->nullable(); // Rekomendasi

            // Technician & Cost
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete(); // Teknisi
            $table->decimal('cost', 12, 2)->nullable(); // Biaya maintenance
            $table->string('vendor')->nullable(); // Vendor jika dikerjakan pihak luar

            // Parts replaced
            $table->json('parts_replaced')->nullable(); // [{part: 'Filter', qty: 2, cost: 100000}]

            // Documentation
            $table->json('attachments')->nullable(); // Photos/documents

            $table->timestamps();

            // Indexes
            $table->index('equipment_id');
            $table->index('status');
            $table->index('scheduled_date');
            $table->index('performed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenance');
    }
};
