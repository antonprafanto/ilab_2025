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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Profile Information
            $table->string('avatar')->nullable(); // Profile photo path
            $table->string('title', 100)->nullable(); // Academic title: Dr., Prof., S.Kom., M.T., dll
            $table->text('bio')->nullable(); // Short biography
            $table->string('expertise', 255)->nullable(); // Field of expertise

            // Contact Information (extended)
            $table->string('phone_office', 20)->nullable();
            $table->string('phone_mobile', 20)->nullable();
            $table->string('email_alternate', 255)->nullable();
            $table->string('website', 255)->nullable();

            // Professional Information
            $table->string('department', 255)->nullable(); // Department/Unit
            $table->string('faculty', 255)->nullable(); // For academic users
            $table->string('position', 255)->nullable(); // Job position
            $table->string('employment_status', 50)->nullable(); // PNS, PPPK, Contract, Student

            // Identity Information
            $table->string('id_card_number', 50)->nullable(); // KTP/Passport
            $table->string('tax_id', 50)->nullable(); // NPWP

            // Address Information
            $table->text('address_office')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('country', 100)->default('Indonesia');

            // Social Media & Links
            $table->string('linkedin', 255)->nullable();
            $table->string('google_scholar', 255)->nullable();
            $table->string('researchgate', 255)->nullable();
            $table->string('orcid', 100)->nullable();

            // Preferences
            $table->string('language', 10)->default('id'); // id, en
            $table->string('timezone', 50)->default('Asia/Makassar');
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);

            // Metadata
            $table->timestamp('last_profile_update')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
