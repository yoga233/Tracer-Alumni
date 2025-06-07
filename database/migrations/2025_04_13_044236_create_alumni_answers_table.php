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
            // $table->uuid('submission_id');
            $table->foreignId('submission_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            // $table->foreignId('question_type_id')->constrained()->onDelete('cascade');
            $table->text('answer'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumni_answers');
    }
}
