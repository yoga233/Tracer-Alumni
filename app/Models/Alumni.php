<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'major',
        'graduation_year',
        'employment_status',
        'mounth_waiting',
        'type_company',
        'closeness_workfield',
        'phone_number',
        'address',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function graduateCompetency()
{
    return $this->hasOne(GraduateCompetencie::class);
}

public function workCompetency()
{
    return $this->hasOne(WorkCompetencie::class);
}

}
