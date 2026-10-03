<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('groups', function (Blueprint $table) {
        $table->id();
        $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
        $table->foreignId('centre_id')
                ->constrained('centres')
                ->cascadeOnDelete();
        $table->string('name');
        $table->string('code')->nullable();        // <-- nullable
        $table->integer('order')->default(1);
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
