<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Migration untuk questions table
   public function up(): void
        {
            Schema::create('questions', function (Blueprint $table) {
                $table->id();
                $table->text('question_text');
                $table->foreignId('question_type_id')->constrained('question_types')->onDelete('cascade');
                $table->boolean('is_required');
                $table->boolean('other_option')->default(false); 
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
