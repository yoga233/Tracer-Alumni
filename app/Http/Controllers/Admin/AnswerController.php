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

    $questions = $withQuestions
    ? Question::where('question_text', 'like', '%' . $keyword . '%')->get()
    : Question::all(); 

    $query = AlumniAnswer::with('question', 'submission.alumni');
    if ($withQuestions) {
        $query->whereHas('question', function ($q) use ($keyword) {
            $q->where('question_text', 'like', '%' . $keyword . '%');
        });
    }

    if ($startDate = request('start_date')) {
        $query->whereHas('submission', function ($q) use ($startDate) {
            $q->whereDate('created_at', $startDate);
        });
    }

    if (($graduationYear = request('graduation_year')) && $graduationYear !== 'all') {
        $query->whereHas('submission.alumni', function ($q) use ($graduationYear) {
            $q->where('graduation_year', $graduationYear);
        });
    }

    if (($status = request('status')) && $status !== 'all') {
        $query->whereHas('submission.alumni', function ($q) use ($status) {
            $q->where('employment_status', $status);
        });
    }

    $answers = $query->get();

    $groupedBySubmission = $answers->groupBy('submission_id');
    $alumniRows = [];


    foreach ($groupedBySubmission as $submissionId => $answersGroup) {
        $row = [
            'submission_id' => $submissionId,
            'created_at' => optional($answersGroup->first()->submission)->created_at,
            'alumni' => optional($answersGroup->first()->submission->alumni),
        ];
        
        if ($withQuestions) {
            foreach ($questions as $q) {
                $row[$q->question_text] = '-';
            }
        
            $answeredSomething = false;
            foreach ($answersGroup as $answer) {
                $row[$answer->question->question_text] = $answer->answer;
                // jawaban ga kosong dan bukancuma spasi kosong
                if ($answer->answer !== null && trim($answer->answer) !== '') {
                    $answeredSomething = true;
                }
            }
            if (!$answeredSomething) {
                continue;
            }
        }
         else {
            foreach ($answersGroup as $answer) {
                $row[$answer->question->question_text] = $answer->answer;
            }
        }
    
        $alumniRows[] = $row;
    }
    $graduationYears = Alumni::pluck('graduation_year')->unique()->sort()->values();
    $employmentStatuses = Alumni::pluck('employment_status')->unique()->sort()->values();

    return view('admin.alumni_answers.index', compact(
        'questions',
        'alumniRows',
        'graduationYears',
        'employmentStatuses',
        'withQuestions' 
    ));
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
            'phone_number' => $alumni->phone_number,
            'address' => $alumni->address
        ],
        // mapp jawaban
        'alumniAnswers' => $submission->alumniAnswers->map(function ($answer) {
            return [
                'question' => $answer->question->question_text, 
                'answer' => $answer->answer  
            ];
        })->toArray()
    ]);
}



}
