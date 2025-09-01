<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPerusahaan extends Model
{
    protected $table = 'jenis_perusahaan';

    protected $fillable = [
        'alumni_id',
        'jenis_perusahaan',
    ];
    
    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
