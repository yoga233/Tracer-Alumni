<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeeratanStudiKerja extends Model
{
    protected $table = 'keeratan_studi_kerja';

    protected $fillable = [
        'alumni_id',
        'keeratan_bidang_studi',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
