<?php
namespace Database\Factories;

use App\Models\Submission;
use App\Models\Alumni;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    public function definition(): array
    {
        return [
            'alumni_id' => Alumni::factory(),
        ];
    }
}


