<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'question_type_id',
        'is_required',
        'scale_labels',
    ];

    protected $casts = [
        'scale_labels' => 'array',
    ];

    public const EMPLOYMENT_STATUSES = [
        'Bekerja (full time/part time)',
        'Belum Memungkinkan Bekerja',
        'Wiraswasta',
        'Melanjutkan Pendidikan',
        'Tidak Kerja Tetapi Sedang Mencari Kerja',
    ];

    public function questiontype()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function alumniAnswers()
    {
        return $this->hasMany(AlumniAnswer::class, 'question_id');
    }

    public function questionConditions()
    {
        return $this->hasMany(QuestionCondition::class);
    }
}
