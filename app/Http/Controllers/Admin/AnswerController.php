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
    
    // public function create(Question $question)
    // {
    //     return view('admin.answers.create', compact('question'));
    // }

    // public function store(Request $request, Question $question)
    // {
    //     $validated = $request->validate([
    //         'answer_text' => 'required|string',
    //     ]);

    //     AlumniAnswer::create([
    //         'question_id' => $question->id,
    //         'answer_text' => $validated['answer_text'],
    //     ]);

    //     return redirect()->route('admin.answers.index', $question)
    //                      ->with('success', 'Jawaban berhasil ditambahkan!');
    // }

    public function destroyBySubmission($submissionId)
    {
        $submission = Submission::with('alumni', 'alumniAnswers')->findOrFail($submissionId);
        $submission->alumniAnswers()->delete();
        $submission->alumni()->delete();
        $submission->delete();
    
        return redirect()->back()->with('success', 'Data alumni dan jawabannya berhasil dihapus.');
    }


    public function showAnswers()
{
    $keyword = request('keyword');
    $withQuestions = !empty($keyword);

    $questionIds = [];
    $questions = collect();

    if ($withQuestions) {
        $questions = Question::where('question_text', 'like', '%' . $keyword . '%')->get();
        $questionIds = $questions->pluck('id')->toArray();
    } else {
        $questions = Question::all();
    }

    $submissionQuery = Submission::with(['alumni', 'alumniAnswers.question']);

    if ($withQuestions && count($questionIds) > 0) {
        $submissionQuery->whereHas('alumniAnswers', function ($q) use ($questionIds) {
            $q->whereIn('question_id', $questionIds)
              ->whereNotNull('answer')
              ->where('answer', '!=', '');
        });
    }

    if ($startDate = request('start_date')) {
        $submissionQuery->whereDate('created_at', $startDate);
    }

    if (($graduationYear = request('graduation_year')) && $graduationYear !== 'all') {
        $submissionQuery->whereHas('alumni', function ($q) use ($graduationYear) {
            $q->where('graduation_year', $graduationYear);
        });
    }

    if (($status = request('status')) && $status !== 'all') {
        $submissionQuery->whereHas('alumni', function ($q) use ($status) {
            $q->where('employment_status', $status);
        });
    }

    $submissions = $submissionQuery->paginate(10)->withQueryString();

    //nyusundata jawaban per alumni
    $alumniRows = [];

    foreach ($submissions as $submission) {
        $row = [
            'submission_id' => $submission->id,
            'created_at' => $submission->created_at,
            'alumni' => $submission->alumni,
        ];

        foreach ($questions as $q) {
            $row[$q->question_text] = '-';
        }

        foreach ($submission->alumniAnswers as $answer) {
            $row[$answer->question->question_text] = $answer->answer;
        }

        $alumniRows[] = $row;
    }

    $graduationYears = Alumni::pluck('graduation_year')->unique()->sort()->values();
    $employmentStatuses = Alumni::pluck('employment_status')->unique()->sort()->values();

    return view('admin.alumni_answers.index', [
        'questions' => $questions,
        'submissions' => $submissions,
        'alumniRows' => $alumniRows,
        'graduationYears' => $graduationYears,
        'employmentStatuses' => $employmentStatuses,
        'withQuestions' => $withQuestions,
    ]);
}



public function detailJawaban($submissionId)
{
    $submission = Submission::with(['alumni', 'alumniAnswers.question'])->findOrFail($submissionId);

    $alumni = $submission->alumni;
    return response()->json([
        'submission_id' => $submission->id,
        'created_at' => $submission->created_at,
        'alumni' => [
            'name' => $alumni->name,
            'email' => $alumni->email,
            'major' => $alumni->major,
            'graduation_year' => $alumni->graduation_year,
            'employment_status' => $alumni->employment_status,
            'mounth_waiting' => $alumni->mounth_waiting,
            'type_company' => $alumni->type_company,
            'closeness_workfield' => $alumni->closeness_workfield,
            'phone_number' => $alumni->phone_number,
            'address' => $alumni->address
        ],
        //mapp jawaban
        'alumniAnswers' => $submission->alumniAnswers->map(function ($answer) {
            return [
                'question' => $answer->question->question_text, 
                'answer' => $answer->answer  
            ];
        })->toArray()
    ]);
}



}
