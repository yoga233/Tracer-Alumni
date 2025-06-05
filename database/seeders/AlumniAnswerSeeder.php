<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlumniAnswer;
use App\Models\Submission;
use App\Models\Question;
use App\Models\Option;

class AlumniAnswerSeeder extends Seeder
{
    public function run()
    {
        $questions = Question::with('questionType')->get();
        $submissions = Submission::all();

        foreach ($submissions as $submission) {
            foreach ($questions as $question) {
                $answerText = '';

                switch ($question->questionType->name) {
                    case 'text':
                        $answerText = fake()->name();
                        break;

                    case 'textarea':
                        $answerText = fake()->sentence(12);
                        break;

                    case 'radio':
                    case 'select':
                        $option = Option::where('question_id', $question->id)->inRandomOrder()->first();
                        $answerText = $option?->option_text ?? 'N/A';
                        break;

                    case 'checkbox':
                        $options = Option::where('question_id', $question->id)->inRandomOrder()->take(2)->get();
                        $answerText = $options->pluck('option_text')->implode(', ');
                        break;
                }

                AlumniAnswer::create([
                    'submission_id' => $submission->id,
                    'question_id' => $question->id,
                    'answer' => $answerText,
                ]);
            }
        }
    }
}
