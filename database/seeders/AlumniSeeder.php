<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    public function run()
    {
        $alumnis = [
            [
                'name' => 'Alice Smith',
                'email' => 'alice@example.com',
                'major' => 'Computer Science',
                'graduation_year' => 2020,
                'employment_status' => 'Employed',
                'phone_number' => '081234567890',
                'address' => 'Surabaya',
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'major' => 'Informatics',
                'graduation_year' => 2020,
                'employment_status' => 'Unemployed',
                'phone_number' => '081234567891',
                'address' => 'Malang',
            ],
            [
                'name' => 'Charlie Brown',
                'email' => 'charlie@example.com',
                'major' => 'Informatics',
                'graduation_year' => 2020,
                'employment_status' => 'Freelancer',
                'phone_number' => '081234567892',
                'address' => 'Sidoarjo',
            ],
            [
                'name' => 'Diana Prince',
                'email' => 'diana@example.com',
                'major' => 'Computer Science',
                'graduation_year' => 2022,
                'employment_status' => 'Entrepreneur',
                'phone_number' => '081234567893',
                'address' => 'Gresik',
            ],
            [
                'name' => 'Evan Wright',
                'email' => 'evan@example.com',
                'major' => 'Information Systems',
                'graduation_year' => 2021,
                'employment_status' => 'Studying',
                'phone_number' => '081234567894',
                'address' => 'Lamongan',
            ],
            [
                'name' => 'Fiona Davis',
                'email' => 'fiona@example.com',
                'major' => 'Informatics',
                'graduation_year' => 2022,
                'employment_status' => 'Employed',
                'phone_number' => '081234567895',
                'address' => 'Surabaya',
            ],
            [
                'name' => 'George King',
                'email' => 'george@example.com',
                'major' => 'Informatics',
                'graduation_year' => 2020,
                'employment_status' => 'Freelancer',
                'phone_number' => '081234567896',
                'address' => 'Jombang',
            ],
            [
                'name' => 'Hannah Miles',
                'email' => 'hannah@example.com',
                'major' => 'Computer Science',
                'graduation_year' => 2022,
                'employment_status' => 'Entrepreneur',
                'phone_number' => '081234567897',
                'address' => 'Blitar',
            ],
            [
                'name' => 'Ian Clark',
                'email' => 'ian@example.com',
                'major' => 'Informatics',
                'graduation_year' => 2023,
                'employment_status' => 'Unemployed',
                'phone_number' => '081234567898',
                'address' => 'Kediri',
            ],
            [
                'name' => 'Jane Foster',
                'email' => 'jane@example.com',
                'major' => 'Information Systems',
                'graduation_year' => 2020,
                'employment_status' => 'Employed',
                'phone_number' => '081234567899',
                'address' => 'Mojokerto',
            ],
        ];

        foreach ($alumnis as $data) {
            Alumni::create($data);
        }
    }
}
