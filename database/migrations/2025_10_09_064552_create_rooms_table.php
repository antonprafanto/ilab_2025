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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratory_id')->constrained('laboratories')->cascadeOnDelete();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->enum('type', ['research', 'teaching', 'storage', 'preparation', 'meeting', 'office'])->default('research');
            $table->decimal('area', 8, 2)->nullable()->comment('Area in m²');
            $table->integer('capacity')->nullable()->comment('Maximum capacity (people)');
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->text('description')->nullable();
            $table->text('facilities')->nullable()->comment('Available facilities in the room');
            $table->string('floor')->nullable();
            $table->string('building')->nullable();
            $table->foreignId('responsible_person')->nullable()->constrained('users')->nullOnDelete();
            $table->text('safety_equipment')->nullable();
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
        Schema::dropIfExists('rooms');
    }
};
