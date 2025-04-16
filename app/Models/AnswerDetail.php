<?php

// app/Models/AnswerDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerDetail extends Model
{
    protected $fillable = ['answer_id', 'question_id', 'value'];

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
