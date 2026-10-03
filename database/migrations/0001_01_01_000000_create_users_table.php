<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ------------------------------
        // USERS
        // ------------------------------
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Informations personnelles
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->nullable(); // nom complet
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('sex', ['M','F'])->nullable();
            $table->date('birthdate')->nullable();
            $table->string('national_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_photo_path')->nullable();

            // Informations professionnelles / organisationnelles
            $table->foreignId('centre_id')->nullable()->constrained('centres')->nullOnDelete();
            $table->string('role')->nullable(); // ex: super-admin, ministere...
            $table->string('status')->default('active'); // actif/inactif
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->timestamp('hired_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        // ------------------------------
        // PASSWORD RESET TOKENS
        // ------------------------------
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // ------------------------------
        // SESSIONS
        // ------------------------------
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
