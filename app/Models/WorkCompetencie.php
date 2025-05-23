<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkCompetencie extends Model
{
    protected $table = 'work_competencies';

    protected $fillable = [
        'alumni_id',
        'ethics',
        'field_expertise',
        'english',
        'it_usage',
        'communication',
        'teamwork',
        'self_development',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
