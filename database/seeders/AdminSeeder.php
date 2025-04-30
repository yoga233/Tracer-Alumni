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
        // Menambahkan data dummy untuk tabel users
        User::create([
            'name' => 'John Doe',
            'email' => 'agung@gmail.com',
            'password' => Hash::make('12345678'),  // Password harus di-hash
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password456'),
        ]);

        User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice.johnson@example.com',
            'password' => Hash::make('password789'),
        ]);

        // Menambahkan lebih banyak user sesuai kebutuhan
    }
}
