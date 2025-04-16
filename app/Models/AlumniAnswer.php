<?php

// app/Models/AlumniAnswer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'question_id',
        'answer',
    ];
    

    // Relasi ke model Question (Jika diperlukan)
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
}

