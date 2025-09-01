<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_graduate_competencies_table.php
public function up(): void
{
    Schema::create('kompetensi_lulus', function (Blueprint $table) {
        $table->id();
        $table->foreignId('alumni_id')->constrained()->onDelete('cascade');
        $table->enum('etika', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable(); 
        $table->enum('keahlian_bidang_ilmu', ['Sangat Rendah','Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->enum('bahasa_inggris', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->enum('penggunaan_teknologi_informasi', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->enum('komunikasi', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->enum('kerjasama_tim', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->enum('pengembangan_diri', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kompetensi_lulus');
    }
};
