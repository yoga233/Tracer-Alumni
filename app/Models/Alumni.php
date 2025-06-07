<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_lulus',             
        'npm',                    
        'nama_mahasiswa',          
        'nik',                     
        'tanggal_lahir',           
        'email',                  
        'nomor_telepon',          
        'npwp',                    
        'nama_dosen_pembimbing',  
        'sumber_pembiayaan_kuliah',
        'status_saat_ini',         
        'alamat',                  
    ];

    // Relasi sesuai kebutuhan (misal kalau ada submissions)
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function KompetensiLulus()
{
    return $this->hasOne(KompetensiLulus::class);
}

public function KompetensiKerja()
{
    return $this->hasOne(KompetensiKerja::class);
}

public function WaktuTungguKerja(){
    return $this->hasOne(WaktuTungguKerja::class);
}

public function JenisPerusahaan(){
    return $this->hasOne(JenisPerusahaan::class);
}

public function KeeratanStudiKerja(){
    return $this->hasOne(KeeratanStudiKerja::class);    
}

}


