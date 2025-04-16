<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumniAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('alumni_answers', function (Blueprint $table) {
            $table->id();
            $table->uuid('submission_id'); // Tambahan kolom untuk identifikasi setiap pengisian
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->text('answer'); // Kolom untuk menyimpan jawaban alumni
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumni_answers');
    }
}
