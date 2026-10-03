<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_id')
                ->constrained('exams')
                ->cascadeOnDelete();

            $table->foreignId('centre_id')
                ->constrained('centres')
                ->cascadeOnDelete();

            $table->string('name'); // Session 1, Session 2...
            $table->string('academic_year'); // 2025-2026

            $table->date('start_date');
            $table->date('end_date');

            $table->enum('type', ['normale', 'rattrapage', 'speciale'])
                ->default('normale');

            $table->json('settings')->nullable();

            $table->timestamps();

            // 🔐 unicité métier (ESSENTIEL)
            $table->unique([
                'exam_id',
                'centre_id',
                'academic_year',
                'type',
                'name'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_sessions');
    }
};
