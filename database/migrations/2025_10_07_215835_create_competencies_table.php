<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competencies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_id')
                  ->constrained('exams')
                  ->cascadeOnDelete();

            $table->foreignId('centre_id')
                  ->nullable()
                  ->constrained('centres')
                  ->cascadeOnDelete();

            $table->foreignId('group_id')
                  ->nullable()
                  ->constrained('groups')
                  ->nullOnDelete();

            $table->string('name')->nullable();
            $table->tinyInteger('round')->default(1);
            $table->integer('coefficient')->default(1);
            $table->integer('order')->default(0);

            $table->string('code')->nullable();
            $table->string('title');
            $table->text('description')->nullable();

            $table->float('max_score')->default(0);

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('competencies');
    }
};
