<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run()
    {
        $questions = Question::all(); // <- tambahkan ini

        $additionalOptions = [
            'How often do you use our product?' => ['Daily', 'Weekly', 'Monthly', 'Rarely'],
            'Select all devices you own.' => ['Laptop', 'Smartphone', 'Tablet', 'Smartwatch'],
            'Which country are you from?' => ['Indonesia', 'Malaysia', 'Singapore', 'Other'],
            'How satisfied are you with our support?' => ['Very Satisfied', 'Satisfied', 'Neutral', 'Dissatisfied'],
            'Select your favorite cuisines.' => ['Indonesian', 'Italian', 'Japanese', 'Mexican'],
            'Which department do you belong to?' => ['IT', 'HR', 'Marketing', 'Finance'],
        ];
        
        foreach ($additionalOptions as $questionText => $options) {
            $question = $questions->where('question_text', $questionText)->first();
            if ($question) {
                foreach ($options as $optionText) {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $optionText,
                    ]);
                }
            }
        }
    }
}
