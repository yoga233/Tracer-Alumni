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
            Schema::create('keeratan_studi_kerja', function (Blueprint $table) {
                $table->id();
                $table->foreignId('alumni_id')->constrained()->onDelete('cascade');
                $table->enum('keeratan_bidang_studi', ['Sangat Erat', 'Erat', 'Cukup Erat', 'Kurang Erat'])->nullable();
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keeratan_studi_kerja');
    }
};
