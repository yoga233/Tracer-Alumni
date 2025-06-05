<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\QuestionCondition;
use App\Models\Option;
use App\Models\Question;
use App\Models\Submission;
use App\Models\AlumniAnswer;
use App\Models\GraduateCompetencie;
use App\Models\WorkCompetencie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlumniFormController extends Controller
{
    protected array $kompetensiFields = [
        'ethics' => 'Etika',
        'field_expertise' => 'Keahlian Bidang',
        'english' => 'Bahasa Inggris',
        'it_usage' => 'Pemanfaatan IT',
        'communication' => 'Komunikasi',
        'teamwork' => 'Kerjasama',
        'self_development' => 'Pengembangan Diri',
    ];

    protected array $kompetensiOptions = [
        'Sangat Tinggi',
        'Tinggi',
        'Cukup',
        'Rendah',
    ];

   public function showForm(Request $request)
        {
            if (!session()->has('submission_id')) {
                session(['submission_id' => (string) Str::uuid()]);
            }

            // Ambil semua pertanyaan tanpa filter kondisi apapun
            $questions = Question::with(['questiontype', 'options', 'questionConditions'])->get();

            // Olah data matrix (jika ada)
            foreach ($questions as $question) {
                if ($question->questiontype?->name === 'matrix') {
                    $rows = [];
                    $columns = [];

                    // Pisahkan baris dan kolom
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

            return view('alumni.form', [
                'questions' => $questions,
                'kompetensiFields' => $this->kompetensiFields,
                'kompetensiOptions' => $this->kompetensiOptions,
                'selectedStatus' => $request->query('employment_status') ?? null, // biar bisa dipakai di JS
            ]);
        }



    public function storeForm(Request $request)
    {
        // Validasi form umum + kompetensi
        $validated = $request->validate(array_merge([
            'answers.*' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'major' => 'required|string',
            'graduation_year' => 'required|numeric',
            'employment_status' => 'required|in:Bekerja,Belum Bekerja,Wirausaha,Freelance,Studi Lanjut',
            'mounth_waiting' => 'nullable|in:<= 3 bulan,<= 6 bulan,<= 9 bulan,<= 12 bulan',
            'type_company' => 'nullable|in:Lokal,Nasional,Internasional',
            'closeness_workfield' => 'nullable|in:Sangat erat,Erat,Cukup erat,Tidak erat',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
        ], $this->buildKompetensiValidation()));

        if (Alumni::where('email', $request->email)->exists()) {
            return back()->withInput()->with('error', 'Email sudah pernah digunakan.');
        }

        // Simpan data alumni
        $alumni = Alumni::create($request->only([
            'name', 'email', 'major', 'graduation_year',
            'employment_status', 'mounth_waiting',
            'type_company', 'closeness_workfield',
            'phone_number', 'address'
        ]));

        // Simpan submission
        $submission = Submission::create(['alumni_id' => $alumni->id]);

        // Simpan jawaban
        if (is_array($request->answers)) {
            $answers = $request->input('answers', []);
            $answersOther = $request->input('answers_other', []);

            foreach ($answers as $questionId => $answer) {
                // Gabungkan jika sebelumnya checkbox atau select
                $finalAnswer = is_array($answer) ? implode(', ', $answer) : $answer;

                // Cek apakah ada jawaban 'lainnya' untuk pertanyaan ini
                if (isset($answersOther[$questionId]) && !empty($answersOther[$questionId])) {
                    $otherText = trim($answersOther[$questionId]);
                    // Gabungkan jika sebelumnya checkbox atau select
                    if (is_array($answer)) {
                        $finalAnswer .= ', ' . $otherText;
                    } else {
                        // Ganti jika isinya memang 'lainnya'
                        if ($finalAnswer === 'lainnya') {
                            $finalAnswer = $otherText;
                        } else {
                            // Tambahkan koma jika jawaban sebelumnya bukan 'lainnya'
                            $finalAnswer .= ', ' . $otherText;
                        }
                    }
                }

                AlumniAnswer::create([
                    'submission_id' => $submission->id,
                    'question_id' => $questionId,
                    'answer' => $finalAnswer,
                ]);
            }
        }
        GraduateCompetencie::create(array_merge(
            ['alumni_id' => $alumni->id],
            $request->input('graduate_competency')
        ));
        WorkCompetencie::create(array_merge(
            ['alumni_id' => $alumni->id],
            $request->input('work_competency')
        ));
        session()->forget('submission_id');

        return redirect()->route('alumni.form')->with('success', 'Formulir sudah disubmit bree!');
    }

    private function buildKompetensiValidation(): array
    {
        $rules = [];

        foreach ($this->kompetensiFields as $field => $label) {
            $inValues = implode(',', $this->kompetensiOptions);
            $rules["graduate_competency.$field"] = "required|in:$inValues";
            $rules["work_competency.$field"] = "required|in:$inValues";
        }

        return $rules;
    }
}
