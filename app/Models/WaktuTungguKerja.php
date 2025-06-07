<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaktuTungguKerja extends Model
{
    protected $table = 'waktu_tunggu_kerja';
     protected $fillable = ['alumni_id', 'waktu_tunggu_bulan'];

      public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
