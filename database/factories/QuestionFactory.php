<?php
namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'question_text' => $this->faker->sentence(5),
            'question_type_id' => QuestionType::factory(),
            'is_required' => $this->faker->boolean(70),
        ];
    }
}
