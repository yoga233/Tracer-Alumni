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
            $table->string('name'); 
            $table->string('email')->unique(); 
            $table->string('major');
            $table->year('graduation_year');  
            $table->enum('employment_status', ['Bekerja', 'Belum Bekerja','Wirausaha','Freelance','Studi Lanjut'])->default('Belum Bekerja');
            $table->enum('mounth_waiting',['<= 3 bulan','<= 6 bulan','<= 9 bulan','<= 12 bulan'])->nullable();
            $table->enum('type_company', ['Lokal','Nasional','Internasional'])->nullable();
            $table->enum('closeness_workfield', ['Sangat erat','Erat','Cukup erat','Tidak erat'])->nullable();
            $table->string('phone_number')->nullable();  
            $table->string('address')->nullable(); 
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
