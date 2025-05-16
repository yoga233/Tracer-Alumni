<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'alumni_answers'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function alumniAnswers()
    {
        return $this->hasMany(AlumniAnswer::class);
    }


}
