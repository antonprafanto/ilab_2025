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
        Schema::create('reagents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratory_id')->constrained('laboratories')->cascadeOnDelete();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->string('cas_number')->nullable()->comment('CAS Registry Number');
            $table->string('formula')->nullable()->comment('Chemical formula');
            $table->enum('category', ['acid', 'base', 'salt', 'organic', 'inorganic', 'solvent', 'indicator', 'standard', 'oxidizing', 'other'])->default('other');
            $table->string('grade')->nullable()->comment('Purity grade: AR, PA, LR, etc.');
            $table->string('purity')->nullable()->comment('Purity percentage');
            $table->string('manufacturer')->nullable();
            $table->string('supplier')->nullable();
            $table->string('lot_number')->nullable()->comment('Batch/Lot number');
            $table->string('catalog_number')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->string('unit', 50)->comment('Unit: mL, L, g, kg, etc.');
            $table->string('storage_location')->nullable();
            $table->enum('storage_condition', ['room_temperature', 'refrigerated', 'frozen', 'special'])->default('room_temperature')->comment('Storage condition requirement');
            $table->enum('hazard_class', ['non_hazardous', 'flammable', 'corrosive', 'toxic', 'oxidizing', 'explosive', 'radioactive'])->default('non_hazardous');
            $table->text('safety_notes')->nullable();
            $table->string('sds_file')->nullable()->comment('Safety Data Sheet file');
            $table->date('purchase_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->date('opened_date')->nullable();
            $table->decimal('price', 12, 2)->nullable()->comment('Purchase price');
            $table->enum('status', ['available', 'in_use', 'low_stock', 'expired', 'disposed'])->default('available');
            $table->decimal('min_stock_level', 10, 2)->nullable()->comment('Minimum stock alert level');
            $table->text('description')->nullable();
            $table->text('usage_instructions')->nullable();
            $table->text('disposal_instructions')->nullable();
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
        Schema::dropIfExists('reagents');
    }
};
