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
        Schema::create('sops', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('code', 50)->unique(); // SOP-LAB-001
            $table->string('title'); // Judul SOP
            $table->enum('category', [
                'equipment',
                'testing',
                'safety',
                'quality',
                'maintenance',
                'calibration',
                'general'
            ]); // Kategori SOP

            $table->foreignId('laboratory_id')->nullable()->constrained('laboratories')->nullOnDelete();

            // Version Control
            $table->string('version', 20)->default('1.0'); // e.g., 1.0, 1.1, 2.0
            $table->integer('revision_number')->default(0); // Revision counter

            // Content
            $table->text('purpose')->nullable(); // Tujuan SOP
            $table->text('scope')->nullable(); // Ruang lingkup
            $table->text('description')->nullable(); // Deskripsi prosedur
            $table->json('steps')->nullable(); // Langkah-langkah (array of steps)
            $table->text('requirements')->nullable(); // Persyaratan/Prerequisites
            $table->text('safety_precautions')->nullable(); // Precautions keselamatan
            $table->text('references')->nullable(); // Referensi

            // Document Files
            $table->string('document_file')->nullable(); // PDF file utama
            $table->json('attachments')->nullable(); // File pendukung lain

            // Status & Approval
            $table->enum('status', [
                'draft',
                'review',
                'approved',
                'archived'
            ])->default('draft');

            // Approval Workflow
            $table->foreignId('prepared_by')->nullable()->constrained('users')->nullOnDelete(); // Pembuat
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete(); // Reviewer
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete(); // Approver

            $table->date('review_date')->nullable(); // Tanggal review
            $table->date('approval_date')->nullable(); // Tanggal approval
            $table->date('effective_date')->nullable(); // Tanggal efektif
            $table->date('next_review_date')->nullable(); // Tanggal review berikutnya
            $table->integer('review_interval_months')->default(12); // Interval review (bulan)

            // Metadata
            $table->text('revision_notes')->nullable(); // Catatan revisi
            $table->json('change_history')->nullable(); // History perubahan

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('laboratory_id');
            $table->index('category');
            $table->index('status');
            $table->index('effective_date');
            $table->index('next_review_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sops');
    }
};
