<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCondition extends Model
{
    protected $fillable = ['question_id', 'field', 'value_status_kerja'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
