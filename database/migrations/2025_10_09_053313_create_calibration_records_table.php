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
        Schema::create('calibration_records', function (Blueprint $table) {
            $table->id();

            // Equipment Reference
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();

            // Calibration Information
            $table->string('calibration_code', 50)->unique(); // CAL-EQ-001-2025-001
            $table->enum('type', [
                'internal',       // Kalibrasi Internal
                'external',       // Kalibrasi Eksternal
                'verification',   // Verifikasi
                'adjustment',     // Penyesuaian
            ]);
            $table->enum('method', [
                'comparison',     // Perbandingan dengan standar
                'direct',         // Pengukuran langsung
                'simulation',     // Simulasi
                'functional',     // Pengujian fungsi
            ])->nullable();

            // Schedule
            $table->date('calibration_date');
            $table->date('due_date')->nullable();              // Tanggal jatuh tempo kalibrasi berikutnya
            $table->integer('interval_months')->default(12);   // Interval kalibrasi (bulan)

            // Status
            $table->enum('status', [
                'scheduled',      // Dijadwalkan
                'in_progress',    // Sedang Dikerjakan
                'passed',         // Lulus
                'failed',         // Tidak Lulus
                'conditional',    // Lulus Bersyarat
                'cancelled',      // Dibatalkan
            ])->default('scheduled');

            // Results
            $table->enum('result', ['pass', 'fail', 'conditional'])->nullable();
            $table->text('measurement_results')->nullable();   // Hasil pengukuran (JSON atau text)
            $table->json('test_points')->nullable();           // Titik uji
            $table->json('deviations')->nullable();            // Deviasi yang ditemukan
            $table->text('adjustments_made')->nullable();      // Penyesuaian yang dilakukan

            // Accuracy & Uncertainty
            $table->string('accuracy')->nullable();            // Akurasi (contoh: ±0.01g)
            $table->string('uncertainty')->nullable();         // Ketidakpastian pengukuran
            $table->string('range_calibrated')->nullable();    // Rentang yang dikalibrasi

            // Standards Used
            $table->text('standards_used')->nullable();        // Standar yang digunakan
            $table->text('equipment_used')->nullable();        // Alat yang digunakan untuk kalibrasi
            $table->text('reference_conditions')->nullable();  // Kondisi referensi (suhu, tekanan, dll)

            // Personnel
            $table->foreignId('calibrated_by')->nullable()->constrained('users')->nullOnDelete(); // Kalibrator
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();   // Verifikator

            // External Calibration
            $table->string('external_lab')->nullable();        // Lab eksternal
            $table->string('certificate_number')->nullable();  // Nomor sertifikat
            $table->date('certificate_issue_date')->nullable();
            $table->date('certificate_expiry_date')->nullable();
            $table->string('certificate_file')->nullable();    // Path ke file PDF sertifikat

            // Cost
            $table->decimal('calibration_cost', 12, 2)->nullable();

            // Next Calibration
            $table->date('next_calibration_date')->nullable();
            $table->text('recommendations')->nullable();
            $table->text('notes')->nullable();

            // Attachments
            $table->json('attachments')->nullable();           // Photos, documents, reports

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('calibration_date');
            $table->index('due_date');
            $table->index('status');
            $table->index('result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calibration_records');
    }
};
