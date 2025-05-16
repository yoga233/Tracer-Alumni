<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Pandoe',
            'email' => 'agung@gmail.com',
            'password' => Hash::make('12345678'),  
        ]);

        User::create([
            'name' => 'Siti Aisyah',
            'email' => 'sitiaisyah@yahoo.com',
            'password' => Hash::make('siti1234'),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@outlook.com',
            'password' => Hash::make('budipassword'),
        ]);
    }

}
