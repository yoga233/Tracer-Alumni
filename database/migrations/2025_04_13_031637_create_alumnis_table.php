<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_alumnis_table.php

    public function up()
    {
            Schema::create('alumnis', function (Blueprint $table) {
                $table->id();
                $table->year('tahun_lulus'); // Tahun Lulus
                $table->string('npm')->unique(); // Nomor Pokok Mahasiswa
                $table->string('nama_mahasiswa'); // Nama Mahasiswa
                $table->string('nik', 20)->unique(); // NIK / Nomor KTP
                $table->date('tanggal_lahir'); // Tanggal Lahir
                $table->string('email')->unique(); // Alamat Email
                $table->string('nomor_telepon')->nullable(); // Nomor Telepon / HP
                $table->string('npwp')->nullable(); // NPWP
                $table->string('nama_dosen_pembimbing'); // Nama Dosen Pembimbing (tanpa gelar)
                $table->string('sumber_pembiayaan_kuliah')->nullable();
                $table->enum('status_saat_ini', [
                    'Bekerja (full time/part time)',
                    'Belum Memungkinkan Bekerja',
                    'Wiraswasta',
                    'Melanjutkan Pendidikan',
                    'Tidak Kerja Tetapi Sedang Mencari Kerja'
                ])->nullable();            
                $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
