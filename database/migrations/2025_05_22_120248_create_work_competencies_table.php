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
    Schema::create('work_competencies', function (Blueprint $table) {
        $table->id();
        $table->foreignId('alumni_id')->constrained()->onDelete('cascade');
        $table->enum('ethics', ['Sangat Tinggi', 'Tinggi', 'Cukup', 'Rendah'])->nullable();
        $table->enum('field_expertise', ['Sangat Tinggi', 'Tinggi', 'Cukup', 'Rendah'])->nullable();
        $table->enum('english', ['Sangat Tinggi', 'Tinggi', 'Cukup', 'Rendah'])->nullable();
        $table->enum('it_usage', ['Sangat Tinggi', 'Tinggi', 'Cukup', 'Rendah'])->nullable();
        $table->enum('communication', ['Sangat Tinggi', 'Tinggi', 'Cukup', 'Rendah'])->nullable();
        $table->enum('teamwork', ['Sangat Tinggi', 'Tinggi', 'Cukup', 'Rendah'])->nullable();
        $table->enum('self_development', ['Sangat Tinggi', 'Tinggi', 'Cukup', 'Rendah'])->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_competencies');
    }
};
