<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question_text', 'question_type_id', 'options', 'scale_labels'];

    protected $casts = [
        'options' => 'array',
        'scale_labels' => 'array',
    ];

    public function type()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    public function answerDetails()
    {
        return $this->hasMany(AnswerDetail::class);
    }
}
