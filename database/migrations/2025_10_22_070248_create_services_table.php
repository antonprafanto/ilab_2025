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
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('laboratory_id')->constrained('laboratories')->cascadeOnDelete();

            // Basic Information
            $table->string('code', 50)->unique()->comment('SVC-CHEM-001');
            $table->string('name', 255)->comment('Analisis GC-MS');
            $table->text('description')->nullable();

            // Categorization
            $table->enum('category', [
                'kimia',
                'biologi',
                'fisika',
                'mikrobiologi',
                'material',
                'lingkungan',
                'pangan',
                'farmasi'
            ])->index();
            $table->string('subcategory', 100)->nullable()->comment('Analisis Organik, Analisis Anorganik, etc');
            $table->string('method', 255)->nullable()->comment('ISO 17025, SNI 2354, AOAC, etc');

            // Duration & Pricing
            $table->integer('duration_days')->default(3)->comment('Estimasi hari pengerjaan');
            $table->decimal('price_internal', 12, 2)->comment('Tarif mahasiswa/dosen UNMUL');
            $table->decimal('price_external_edu', 12, 2)->comment('Tarif universitas lain');
            $table->decimal('price_external', 12, 2)->comment('Tarif industri/umum');
            $table->integer('urgent_surcharge_percent')->default(50)->comment('Biaya urgent %');

            // Requirements & Deliverables (JSON)
            $table->json('requirements')->nullable()->comment('["Sampel min 50g", "Form permohonan"]');
            $table->json('equipment_needed')->nullable()->comment('[1, 5, 8] - equipment IDs');
            $table->text('sample_preparation')->nullable()->comment('Instruksi preparasi sampel');
            $table->json('deliverables')->nullable()->comment('["Laporan PDF", "Raw data"]');

            // Sample Limits
            $table->integer('min_sample')->nullable()->comment('Jumlah minimal sampel');
            $table->integer('max_sample')->nullable()->comment('Jumlah maksimal per batch');

            // Status & Popularity
            $table->boolean('is_active')->default(true)->index();
            $table->integer('popularity')->default(0)->comment('Hit counter');

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['category', 'is_active']);
            $table->index(['laboratory_id', 'is_active']);
            $table->index('popularity'); // For sorting by most popular
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
