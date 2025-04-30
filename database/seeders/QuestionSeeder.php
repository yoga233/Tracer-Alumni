<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionTypes = QuestionType::all();

        $questions = [
            [
                'question_text' => 'What is your name?',
                'question_type_id' => $questionTypes->where('name', 'text')->first()->id,
                'is_required' => true,
            ],
            [
                'question_text' => 'Describe your experience with our service.',
                'question_type_id' => $questionTypes->where('name', 'textarea')->first()->id,
                'is_required' => false,
            ],
            [
                'question_text' => 'What is your favorite color?',
                'question_type_id' => $questionTypes->where('name', 'radio')->first()->id,
                'is_required' => true,
            ],
            [
                'question_text' => 'Select your favorite hobbies.',
                'question_type_id' => $questionTypes->where('name', 'checkbox')->first()->id,
                'is_required' => false,
            ],
            [
                'question_text' => 'What is your gender?',
                'question_type_id' => $questionTypes->where('name', 'select')->first()->id,
                'is_required' => true,
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
