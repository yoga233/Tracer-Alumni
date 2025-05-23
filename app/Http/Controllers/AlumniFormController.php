<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Alumni;
use App\Models\Option;
use App\Models\AlumniAnswer;
use App\Models\AnswerDetail;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlumniFormController extends Controller
{
    public function showForm()
    {
        // Buat UUID unik sebagai submission_id, simpan di session
        if (!session()->has('submission_id')) {
            session(['submission_id' => (string) Str::uuid()]);
        }
        // Ambil semua pertanyaan beserta tipe pertanyaannya
        $questions = Question::with(['questiontype', 'options'])->get();
        foreach ($questions as $question) {
                    if ($question->questiontype && $question->questiontype->name === 'matrix') {
                        $rows = [];
                        $columns = [];
            
                        foreach ($question->options as $option) {
                            $parts = explode(' - ', $option->option_text);
            
                            if (count($parts) === 2) {
                                [$row, $column] = $parts;
                                $rows[] = trim($row);
                                $columns[] = trim($column);
                            }
                        }
            
                        $question->rows = array_unique($rows);
                        $question->columns = array_unique($columns);
                    }
                }

        return view('alumni.form', compact('questions'));
    }

    // public function storeForm(Request $request)
    // {
    //     $validated = $request->validate([
    //         'answers.*' => 'required',
    //     ]);

    //     $submissionId = session('submission_id'); // Ambil submission_id dari session

    //     foreach ($request->answers as $questionId => $answer) {
    //         AlumniAnswer::create([
    //             'submission_id' => $submissionId,
    //             'question_id' => $questionId,
    //             'answer' => is_array($answer) ? implode(', ', $answer) : $answer,
    //         ]);
    //     }

    //     // Reset session setelah disubmit supaya alumni lain dapat submission_id baru
    //     session()->forget('submission_id');

    //     return redirect()->route('alumni.form')
    //                      ->with('success', 'Formulir berhasil disubmit!');
    // }

    public function storeForm(Request $request)
{
    $validated = $request->validate([
        'answers.*' => 'required',
        'name' => 'required|string',
        'email' => 'required|email',
        'major' => 'required|string',
        'graduation_year' => 'required|numeric',
    ]);

    $existingAlumni = Alumni::where('email', $request->email)->first();

    if ($existingAlumni) {
    return redirect()->back()->with('error', 'Email sudah pernah digunakan.');
    }


    //ambil data alumni
    $alumni = Alumni::create([
        'name' => $request->name,
        'email' => $request->email,
        'major' => $request->major,
        'graduation_year' => $request->graduation_year,
    ]);

    //simpan dalam submission
    $submission = Submission::create([
        'alumni_id' => $alumni->id,
    ]);

    // //simpan semua jawaban
    foreach ($request->answers as $questionId => $answer) {
        $alumniAnswer= AlumniAnswer::create([
            'submission_id' => $submission->id,
            'question_id' => $questionId,
            'answer' => is_array($answer) ? implode(', ', $answer) : $answer,
        ]);
    }
    
    

    //reset session
    session()->forget('submission_id');

    return redirect()->route('alumni.form')
                     ->with('success', 'Formulir sudah disubmitt bree!');
    }

}
