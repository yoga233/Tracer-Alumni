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
        $table->enum('Etika', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable(); 
        $table->enum('Keahlian berdasarkan bidang ilmu', ['Sangat Rendah','Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->enum('Bahasa Inggris', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->enum('Penggunaan Teknologi Informasi', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->enum('Komunikasi', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->enum('Kerjasama tim', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
        $table->enum('Pengembangan diri', ['Sangat Rendah', 'Rendah', 'Cukup', 'Tinggi', 'Sangat Tinggi'])->nullable();
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
