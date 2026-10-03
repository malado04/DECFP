<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();

            // 🔗 Relations
            $table->foreignId('exam_session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
            $table->foreignId('competency_id')->constrained()->cascadeOnDelete();
            $table->foreignId('entered_by')->nullable()->constrained('users')->nullOnDelete();

            // ✔️ Ajout fusionné
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('validated_at')->nullable();

            // ⚙️ Valeurs
            $table->decimal('score', 8, 2)->nullable()->default(0);
            $table->enum('status', ['present', 'absent', 'ajourne', 'validated'])
                  ->default('present');

            // 🔍 Unicité score par compétence/candidat/session
            $table->unique(
                ['exam_session_id','candidate_id','competency_id'],
                'scores_unique'
            );

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
