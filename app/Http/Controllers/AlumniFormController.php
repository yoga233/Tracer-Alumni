<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\AlumniAnswer;
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
        $questions = Question::with('type')->get();

        return view('alumni.form', compact('questions'));
    }

    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'answers.*' => 'required',
        ]);

        $submissionId = session('submission_id'); // Ambil submission_id dari session

        foreach ($request->answers as $questionId => $answer) {
            AlumniAnswer::create([
                'submission_id' => $submissionId,
                'question_id' => $questionId,
                'answer' => is_array($answer) ? implode(', ', $answer) : $answer,
            ]);
        }

        // Reset session setelah disubmit supaya alumni lain dapat submission_id baru
        session()->forget('submission_id');

        return redirect()->route('alumni.form')
                         ->with('success', 'Formulir berhasil disubmit!');
    }
}
