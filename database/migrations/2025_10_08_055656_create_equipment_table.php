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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name'); // Nama equipment
            $table->string('code', 50)->unique(); // Kode equipment (EQ-KIM-001)
            $table->foreignId('laboratory_id')->constrained('laboratories')->cascadeOnDelete();

            // Category & Type
            $table->enum('category', [
                'analytical',      // Alat analitik (FTIR, GC-MS, HPLC)
                'measurement',     // Alat ukur (pH meter, spektrofotometer)
                'preparation',     // Alat preparasi (oven, autoclave)
                'safety',          // Alat safety (fume hood, fire extinguisher)
                'computer',        // Komputer & IT equipment
                'general'          // Peralatan umum
            ]);
            $table->string('brand')->nullable(); // Merk (Shimadzu, Agilent, dll)
            $table->string('model')->nullable(); // Model/Series
            $table->string('serial_number')->nullable()->unique(); // Serial number

            // Specifications
            $table->text('description')->nullable();
            $table->json('specifications')->nullable(); // Technical specs
            $table->string('photo')->nullable();

            // Purchase Information
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->string('supplier')->nullable();
            $table->string('warranty_period')->nullable(); // e.g., "2 years"
            $table->date('warranty_until')->nullable();

            // Condition & Status
            $table->enum('condition', [
                'excellent',   // Sangat baik
                'good',        // Baik
                'fair',        // Cukup
                'poor',        // Buruk
                'broken'       // Rusak
            ])->default('good');

            $table->enum('status', [
                'available',   // Tersedia untuk digunakan
                'in_use',      // Sedang digunakan
                'maintenance', // Sedang maintenance
                'calibration', // Sedang kalibrasi
                'broken',      // Rusak
                'retired'      // Tidak digunakan lagi
            ])->default('available');

            $table->text('status_notes')->nullable();

            // Maintenance & Calibration
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->integer('maintenance_interval_days')->nullable(); // Interval maintenance (hari)

            $table->date('last_calibration')->nullable();
            $table->date('next_calibration')->nullable();
            $table->integer('calibration_interval_days')->nullable(); // Interval kalibrasi (hari)

            // Location & Assignment
            $table->string('location_detail')->nullable(); // Lokasi detail dalam lab
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); // PIC equipment

            // Usage tracking
            $table->integer('usage_count')->default(0); // Jumlah pemakaian
            $table->integer('usage_hours')->default(0); // Total jam pemakaian

            // Documentation
            $table->string('manual_file')->nullable(); // User manual PDF
            $table->json('documents')->nullable(); // Array of document paths

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('laboratory_id');
            $table->index('category');
            $table->index('status');
            $table->index('condition');
            $table->index(['next_maintenance', 'next_calibration']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
