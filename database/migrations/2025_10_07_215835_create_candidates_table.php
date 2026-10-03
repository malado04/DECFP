<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();

            // 🔢 Identifiants / ANO
            $table->string('ano_number')->nullable();        // N° ANO
            $table->string('ano_number_2')->nullable();      // N° ANO2
            $table->string('registration_number')->nullable()->unique(); // N°
            $table->string('n_base')->nullable();            // N° Base

            // 🧍 Identité
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('sex', ['M', 'F'])->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birth_place')->nullable();       // Lieu de naissance
            $table->string('national_id')->nullable();       // N° CI

            // 📞 Contact
            $table->string('tel')->nullable();
            $table->string('adresse')->nullable();

            // 🎓 Historique académique
            // $table->boolean('admission_2016')->default(false); // ADM 2016
            $table->string('provenance')->nullable();          // PROVENANCE

            // 👤 Lien étudiant (compte utilisateur)
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // 🔗 Relations institutionnelles
            $table->foreignId('centre_id')
                ->nullable()
                ->constrained('centres')
                ->nullOnDelete();

            $table->foreignId('jury_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('exam_id')
                ->nullable()
                ->constrained('exams')
                ->cascadeOnDelete();

            $table->foreignId('exam_session_id')
                ->nullable()
                ->constrained('exam_sessions')
                ->cascadeOnDelete();

            // ⚙️ Statut de l'examen
            $table->enum('status', [
                'inscrit',
                'present',
                'absent',
                'ajourné'
            ])->default('present');

            $table->float('attendance_rate')->default(0); // 0 à 100
            
            // 🚀 Index
            $table->index([
                'ano_number',
                'centre_id',
                'exam_id',
                'exam_session_id'
            ]);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('candidates');
        Schema::enableForeignKeyConstraints();
    }
};
