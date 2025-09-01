<?php

namespace Database\Factories;

use App\Models\AlumniAnswer;
use App\Models\Submission;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumniAnswerFactory extends Factory
{
    protected $model = AlumniAnswer::class;


    public function definition(): array
    {
        return [
            'submission_id' => Submission::factory(),
            'question_id' => Question::factory(),
            'answer' => $this->faker->sentence(4),
        ];
    }
}
