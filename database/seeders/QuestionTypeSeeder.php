<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('question_types')->insert([
            ['name' => 'text'],
            ['name' => 'textarea'],
            ['name' => 'radio'],
            ['name' => 'checkbox'],
            ['name' => 'select'],
            ['name' => 'scale'], // misalnya: 1-5
            ['name' => 'matrix'], // cocok untuk pertanyaan seperti kompetensi
        ]);
    }
}
