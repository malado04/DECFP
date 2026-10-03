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
        Schema::create('session_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_session_id')
                ->constrained('exam_sessions')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('file_path'); // chemin du fichier uploadé

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_documents');
    }

};
