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
        Schema::create('equipment_calibrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();

            $table->date('calibration_date'); // Tanggal kalibrasi
            $table->date('valid_until'); // Berlaku sampai
            $table->string('calibration_number')->nullable(); // Nomor sertifikat kalibrasi

            $table->enum('status', [
                'scheduled',   // Dijadwalkan
                'in_progress', // Sedang dikalibrasi
                'passed',      // Lulus kalibrasi
                'failed',      // Tidak lulus
                'cancelled'    // Dibatalkan
            ])->default('scheduled');

            $table->enum('method', [
                'internal',    // Kalibrasi internal
                'external'     // Kalibrasi eksternal (vendor)
            ])->default('internal');

            // Calibration details
            $table->text('procedure')->nullable(); // Prosedur kalibrasi
            $table->json('parameters')->nullable(); // Parameter yang dikalibrasi
            $table->json('results')->nullable(); // Hasil kalibrasi
            $table->text('deviations')->nullable(); // Deviasi/penyimpangan
            $table->text('recommendations')->nullable(); // Rekomendasi

            // Performed by
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete(); // Teknisi/Kalibrtor
            $table->string('vendor')->nullable(); // Vendor eksternal
            $table->decimal('cost', 12, 2)->nullable(); // Biaya kalibrasi

            // Certificate
            $table->string('certificate_file')->nullable(); // Sertifikat kalibrasi PDF

            // Documentation
            $table->json('attachments')->nullable(); // Photos/documents

            $table->timestamps();

            // Indexes
            $table->index('equipment_id');
            $table->index('status');
            $table->index('calibration_date');
            $table->index('valid_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_calibrations');
    }
};
