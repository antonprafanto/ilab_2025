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
        Schema::create('laboratories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama laboratorium
            $table->string('code', 50)->unique(); // Kode lab (LAB-KIM-001)
            $table->enum('type', [
                'chemistry',
                'biology',
                'physics',
                'geology',
                'engineering',
                'computer',
                'other'
            ]); // 7 types sesuai spec
            $table->text('description')->nullable(); // Deskripsi lab
            $table->string('location')->nullable(); // Lokasi fisik (gedung, lantai, ruang)
            $table->decimal('area_sqm', 8, 2)->nullable(); // Luas ruangan (m²)
            $table->integer('capacity')->nullable(); // Kapasitas orang
            $table->string('photo')->nullable(); // Foto lab

            // Kepala Lab (FK ke users table)
            $table->foreignId('head_user_id')->nullable()->constrained('users')->nullOnDelete();

            // Contact info
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();

            // Operating hours
            $table->time('operating_hours_start')->nullable();
            $table->time('operating_hours_end')->nullable();
            $table->json('operating_days')->nullable(); // ["Monday", "Tuesday", ...]

            // Status
            $table->enum('status', ['active', 'maintenance', 'closed'])->default('active');
            $table->text('status_notes')->nullable(); // Catatan status (misal: alasan maintenance)

            // Metadata
            $table->json('facilities')->nullable(); // Fasilitas lab (AC, internet, dll)
            $table->json('certifications')->nullable(); // Sertifikasi lab (ISO, dll)

            $table->timestamps();
            $table->softDeletes(); // Soft delete untuk history

            // Indexes
            $table->index('type');
            $table->index('status');
            $table->index('head_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratories');
    }
};
