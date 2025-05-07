<?php
namespace App\Http\Controllers\Admin;

use App\Models\Submission;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\AlumniAnswer;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    // public function index(Question $question)
    // {
    //     $answers = $question->answers; // Menampilkan jawaban untuk pertanyaan tertentu
    //     return view('admin.answers.index', compact('answers', 'question'));
    // }

    public function create(Question $question)
    {
        return view('admin.answers.create', compact('question'));
    }

    public function store(Request $request, Question $question)
    {
        $validated = $request->validate([
            'answer_text' => 'required|string',
        ]);

        AlumniAnswer::create([
            'question_id' => $question->id,
            'answer_text' => $validated['answer_text'],
        ]);

        return redirect()->route('admin.answers.index', $question)
                         ->with('success', 'Jawaban berhasil ditambahkan!');
    }

    // public function edit(Question $question, AlumniAnswer $answer)
    // {
    //     return view('admin.answers.edit', compact('question', 'answer'));
    // }

    // public function update(Request $request, Question $question, AlumniAnswer $answer)
    // {
    //     $validated = $request->validate([
    //         'answer_text' => 'required|string',
    //     ]);

    //     $answer->update([
    //         'answer_text' => $validated['answer_text'],
    //     ]);

    //     return redirect()->route('admin.answers.index', $question)
    //                      ->with('success', 'Jawaban berhasil diperbarui!');
    // }

    // public function destroy(Question $question, AlumniAnswer $answer)
    // {
    //     $answer->delete();
    //     return redirect()->route('admin.answers.index', $question)
    //                      ->with('success', 'Jawaban berhasil dihapus!');
    // }

    public function destroyBySubmission($submissionId)
    {
        $submission = Submission::with('alumni', 'alumniAnswers')->findOrFail($submissionId);
        $submission->alumniAnswers()->delete();
        $submission->alumni()->delete();
        $submission->delete();
    
        return redirect()->back()->with('success', 'Data alumni dan jawabannya berhasil dihapus.');
    }


//     public function showAnswers()
// {
//     $questions = Question::take(10)->get();
//     $query = AlumniAnswer::with('question', 'submission.alumni');

//     //keyword pertanyaan
//     if ($keyword = request('keyword')) {
//         $query->whereHas('question', function ($q) use ($keyword) {
//             $q->where('question_text', 'like', '%' . $keyword . '%');
//         });
//     }

//     //waktu pengisian
//     if ($startDate = request('start_date')) {
//         $query->whereHas('submission', function ($q) use ($startDate) {
//             $q->whereDate('created_at', $startDate);
//         });
//     }

//    // Filter berdasarkan tahun lulus
// if (($graduationYear = request('graduation_year')) && $graduationYear !== 'all') {
//     $query->whereHas('submission.alumni', function ($q) use ($graduationYear) {
//         $q->where('graduation_year', $graduationYear);
//     });
// }


//     //status pekerjaan alumni
//     if (($status = request('status')) && $status !== 'all') {
//         $query->whereHas('submission.alumni', function ($q) use ($status) {
//             $q->where('employment_status', $status);
//         });
//     }
//     $answers = $query->get();

//     // $graduationYears = Alumni::pluck('graduation_year')->unique()->()->values();


//     //proses pengelompokan
//     $groupedBySubmission = $answers->groupBy('submission_id');
//     $alumniRows = [];

//     foreach ($groupedBySubmission as $submissionId => $answersGroup) {
//         $row = [
//             'submission_id' => $submissionId,
//             'created_at' => optional($answersGroup->first()->submission)->created_at,
//             'alumni' => optional($answersGroup->first()->submission->alumni),
//         ];

//         foreach ($answersGroup as $answer) {
//             $row[$answer->question->question_text] = $answer->answer;
//         }

//         $alumniRows[] = $row;
//     }

//     return view('admin.alumni_answers.index', compact('questions', 'alumniRows'));
// }

public function showAnswers()
{
    $questions = Question::take(10)->get();
    $query = AlumniAnswer::with('question', 'submission.alumni');
    //keyword pertanyaan
    if ($keyword = request('keyword')) {
        $query->whereHas('question', function ($isi) use ($keyword) {
            $isi->where('question_text', 'like', '%' . $keyword . '%');
        });
    }
    //waktu pengisian
    if ($startDate = request('start_date')) {
        $query->whereHas('submission', function ($isi) use ($startDate) {
            $isi->whereDate('created_at', $startDate);
        });
    }

    //tahun lulus
    if (($graduationYear = request('graduation_year')) && $graduationYear !== 'all') {
        $query->whereHas('submission.alumni', function ($isi) use ($graduationYear) {
            $isi->where('graduation_year', $graduationYear);
        });
    }

    //status pekerjaan
    if (($status = request('status')) && $status !== 'all') {
        $query->whereHas('submission.alumni', function ($isi) use ($status) {
            $isi->where('employment_status', $status);
        });
    }

    $answers = $query->get();
    $groupedBySubmission = $answers->groupBy('submission_id');
    $alumniRows = [];

    //data untuk tabel
    foreach ($groupedBySubmission as $submissionId => $answersGroup) {
        $row = [
            'submission_id' => $submissionId,
            'created_at' => optional($answersGroup->first()->submission)->created_at,
            'alumni' => optional($answersGroup->first()->submission->alumni),
        ];
        foreach ($answersGroup as $answer) {
            $row[$answer->question->question_text] = $answer->answer;
        }
        $alumniRows[] = $row;
    }

    //datadropdown
    $graduationYears = Alumni::pluck('graduation_year')->unique()->sort()->values();
    $employmentStatuses = Alumni::pluck('employment_status')->unique()->sort()->values();

    return view('admin.alumni_answers.index', compact(
        'questions',
        'alumniRows',
        'graduationYears',
        'employmentStatuses'
    ));
}


    

}


