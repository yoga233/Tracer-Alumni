<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $fillable = [
        'name',
        'email',
        'major',
        'graduation_year',
        'employment_status',
        'phone_number',
        'address',
    ];

    use HasFactory;

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
