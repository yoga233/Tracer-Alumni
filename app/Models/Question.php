<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    use HasFactory;
    protected $fillable = ['question_text', 'question_type_id', 'is_required', 'other_option'];

    // untuk dropdown kategory
    public const EMPLOYMENT_STATUSES = [
        'Bekerja',
        'Freelance',
        'Wirausaha',
        'Belum Bekerja',
        'Studi Lanjut',
    ];


    public function questiontype()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    // public function answerDetails()
    // {
    //     return $this->hasMany(AnswerDetail::class);
    // }

    public function questionConditions(){
        return $this->hasMany(QuestionCondition::class);
    }

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function alumniAnswers(){
        return $this->hasMany(AlumniAnswer::class, 'question_id');
    }
}
