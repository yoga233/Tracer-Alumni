<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KompetensiLulus extends Model
{
    protected $table = 'kompetensi_lulus';

    protected $fillable = [
        'alumni_id',
        'Etika',
        'Keahlian berdasarkan bidang ilmu',
        'Bahasa Inggris',
        'Penggunaan Teknologi Informasi',
        'Komunikasi',
        'Kerjasama tim',
        'Pengembangan diri',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
