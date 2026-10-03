<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ccp_weights', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_id')
                ->constrained('exams')
                ->cascadeOnDelete();

            $table->foreignId('competency_id')
                ->constrained('competencies')
                ->cascadeOnDelete();

            $table->decimal('weight', 5, 2)->default(1.0);

            $table->unique(['exam_id', 'competency_id']);

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('ccp_weights');
    }
};
