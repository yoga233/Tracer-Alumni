<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KompetensiKerja extends Model
{
    protected $table = 'kompetensi_kerja';

    protected $fillable = [
        'alumni_id',
        'etika',
        'keahlian_bidang_ilmu',
        'bahasa_inggris',
        'penggunaan_teknologi_informasi',
        'komunikasi',
        'kerjasama_tim',
        'pengembangan_diri',
    ];

    public function Alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
