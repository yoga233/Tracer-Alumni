<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = Question::all();

        // Opsi untuk pertanyaan tipe radio
        $radioQuestion = $questions->where('question_text', 'What is your favorite color?')->first();
        Option::create([
            'question_id' => $radioQuestion->id,
            'option_text' => 'Red',
        ]);
        Option::create([
            'question_id' => $radioQuestion->id,
            'option_text' => 'Blue',
        ]);
        Option::create([
            'question_id' => $radioQuestion->id,
            'option_text' => 'Green',
        ]);

        // Opsi untuk pertanyaan tipe checkbox
        $checkboxQuestion = $questions->where('question_text', 'Select your favorite hobbies.')->first();
        Option::create([
            'question_id' => $checkboxQuestion->id,
            'option_text' => 'Reading',
        ]);
        Option::create([
            'question_id' => $checkboxQuestion->id,
            'option_text' => 'Swimming',
        ]);
        Option::create([
            'question_id' => $checkboxQuestion->id,
            'option_text' => 'Traveling',
        ]);

        // Opsi untuk pertanyaan tipe select
        $selectQuestion = $questions->where('question_text', 'What is your gender?')->first();
        Option::create([
            'question_id' => $selectQuestion->id,
            'option_text' => 'Male',
        ]);
        Option::create([
            'question_id' => $selectQuestion->id,
            'option_text' => 'Female',
        ]);
        Option::create([
            'question_id' => $selectQuestion->id,
            'option_text' => 'Other',
        ]);
    }
}
