<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->uuid('submission_id'); // Identitas unik tiap alumni yang mengisi
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->text('answer');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
