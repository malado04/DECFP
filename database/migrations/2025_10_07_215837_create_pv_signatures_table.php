<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pv_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_session_id')->constrained('exam_sessions')->onDelete('cascade');
            $table->string('pv_path');             // Chemin du PV PDF
            $table->json('signatures')->nullable(); // Signatures stockées en JSON
            $table->string('qr_code_path')->nullable(); // Chemin QR code
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pv_signatures');
    }
};
