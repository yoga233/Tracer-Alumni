<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\AlumniAnswer;  // Tambahkan use statement ini
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index(Question $question)
    {
        $answers = $question->answers; // Menampilkan jawaban untuk pertanyaan tertentu
        return view('admin.answers.index', compact('answers', 'question'));
    }

    public function create(Question $question)
    {
        return view('admin.answers.create', compact('question'));
    }

    public function store(Request $request, Question $question)
    {
        $validated = $request->validate([
            'answer_text' => 'required|string',
        ]);

        Answer::create([
            'question_id' => $question->id,
            'answer_text' => $validated['answer_text'],
        ]);

        return redirect()->route('admin.answers.index', $question)
                         ->with('success', 'Jawaban berhasil ditambahkan!');
    }

    public function edit(Question $question, Answer $answer)
    {
        return view('admin.answers.edit', compact('question', 'answer'));
    }

    public function update(Request $request, Question $question, Answer $answer)
    {
        $validated = $request->validate([
            'answer_text' => 'required|string',
        ]);

        $answer->update([
            'answer_text' => $validated['answer_text'],
        ]);

        return redirect()->route('admin.answers.index', $question)
                         ->with('success', 'Jawaban berhasil diperbarui!');
    }

    public function destroy(Question $question, Answer $answer)
    {
        $answer->delete();
        return redirect()->route('admin.answers.index', $question)
                         ->with('success', 'Jawaban berhasil dihapus!');
    }

    // Method untuk menampilkan jawaban berdasarkan submission_id
    public function showAnswers()
{
    // Ambil semua pertanyaan
    $questions = Question::all();

    // Ambil semua jawaban dan relasi ke pertanyaan
    $answers = AlumniAnswer::with('question')->get();

    // Kelompokkan berdasarkan submission_id
    $groupedBySubmission = $answers->groupBy('submission_id');

    $alumniRows = [];

    foreach ($groupedBySubmission as $submissionId => $answersGroup) {
        $row = ['submission_id' => $submissionId];

        foreach ($answersGroup as $answer) {
            $row[$answer->question->question_text] = $answer->answer;
        }

        $row['created_at'] = $answersGroup->first()->created_at;
        $alumniRows[] = $row;
    }

    // Kirim ke view
    return view('admin.alumni_answers.index', [
        'questions' => $questions,
        'alumniRows' => $alumniRows
    ]);
}




}
