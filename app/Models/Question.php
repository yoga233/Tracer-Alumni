<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    use HasFactory;
    protected $fillable = ['question_text', 'question_type_id', 'is_required'];

  

    public function questiontype()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    // public function answerDetails()
    // {
    //     return $this->hasMany(AnswerDetail::class);
    // }

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function alumniAnswers(){
        return $this->hasMany(AlumniAnswer::class, 'question_id');
    }
}
