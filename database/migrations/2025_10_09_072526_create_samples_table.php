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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratory_id')->constrained('laboratories')->cascadeOnDelete();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->enum('type', ['biological', 'chemical', 'environmental', 'food', 'pharmaceutical', 'other'])->default('other');
            $table->string('source')->nullable()->comment('Sample origin/source');
            $table->string('storage_location')->nullable();
            $table->enum('storage_condition', ['room_temperature', 'refrigerated', 'frozen', 'special'])->default('room_temperature');
            $table->enum('status', ['received', 'in_analysis', 'completed', 'archived', 'disposed'])->default('received');
            $table->date('received_date');
            $table->date('expiry_date')->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->string('unit', 50)->nullable()->comment('Unit of measurement');
            $table->foreignId('submitted_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('analyzed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('description')->nullable();
            $table->text('test_parameters')->nullable()->comment('Parameters to be tested');
            $table->text('analysis_results')->nullable();
            $table->string('result_file')->nullable()->comment('Analysis result file path');
            $table->date('analysis_date')->nullable();
            $table->date('result_date')->nullable();
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->text('special_requirements')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
