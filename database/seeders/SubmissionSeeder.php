<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Submission;
use App\Models\Alumni;

class SubmissionSeeder extends Seeder
{
    public function run()
    {
        $alumnis = Alumni::all();

        foreach ($alumnis as $alumni) {
            Submission::create([
                'alumni_id' => $alumni->id,
            ]);
        }
    }
}
