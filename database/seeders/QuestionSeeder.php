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
            [
                'question_text' => 'How often do you use our product?',
                'question_type_id' => $questionTypes->where('name', 'radio')->first()->id,
                'is_required' => true,
            ],
            [
                'question_text' => 'Any additional feedback?',
                'question_type_id' => $questionTypes->where('name', 'textarea')->first()->id,
                'is_required' => false,
            ],
            [
                'question_text' => 'What is your birth year?',
                'question_type_id' => $questionTypes->where('name', 'text')->first()->id,
                'is_required' => false,
            ],
            [
                'question_text' => 'Select all devices you own.',
                'question_type_id' => $questionTypes->where('name', 'checkbox')->first()->id,
                'is_required' => false,
            ],
            [
                'question_text' => 'Which country are you from?',
                'question_type_id' => $questionTypes->where('name', 'select')->first()->id,
                'is_required' => true,
            ],
            [
                'question_text' => 'What time do you usually wake up?',
                'question_type_id' => $questionTypes->where('name', 'text')->first()->id,
                'is_required' => false,
            ],
            [
                'question_text' => 'How satisfied are you with our support?',
                'question_type_id' => $questionTypes->where('name', 'radio')->first()->id,
                'is_required' => true,
            ],
            [
                'question_text' => 'Any suggestions for improvement?',
                'question_type_id' => $questionTypes->where('name', 'textarea')->first()->id,
                'is_required' => false,
            ],
            [
                'question_text' => 'Select your favorite cuisines.',
                'question_type_id' => $questionTypes->where('name', 'checkbox')->first()->id,
                'is_required' => false,
            ],
            [
                'question_text' => 'Which department do you belong to?',
                'question_type_id' => $questionTypes->where('name', 'select')->first()->id,
                'is_required' => true,
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
