<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $questions = Question::with('type')
            ->when($search, function($query) use ($search) {
                return $query->where('question_text', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $questionTypes = QuestionType::all();
        return view('admin.questions.create', compact('questionTypes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question_text' => 'required|string|max:255',
            'question_type_id' => 'required|exists:question_types,id',
            'options' => 'nullable|string',
            'scale_range' => 'nullable|string',
            'scale_labels' => 'nullable|string',
            'matrix_rows' => 'nullable|string',
            'matrix_columns' => 'nullable|string',
        ]);

        $type = QuestionType::find($request->question_type_id);
        $typeName = $type->name;

        $options = null;
        $scaleLabels = null;

        if (in_array($typeName, ['radio', 'checkbox', 'select']) && $request->options) {
            $options = array_map('trim', explode(',', $request->options));
        }

        if ($typeName === 'scale' && $request->scale_range) {
            [$start, $end] = explode('-', $request->scale_range);
            $options = range((int)$start, (int)$end);

            if ($request->scale_labels) {
                $scaleLabels = array_map('trim', explode(',', $request->scale_labels));
            }
        }

        if ($typeName === 'matrix' && $request->matrix_rows && $request->matrix_columns) {
            $options = [
                'rows' => array_map('trim', explode(',', $request->matrix_rows)),
                'columns' => array_map('trim', explode(',', $request->matrix_columns)),
            ];
        }

        Question::create([
            'question_text' => $validatedData['question_text'],
            'question_type_id' => $validatedData['question_type_id'],
            'options' => $options,
            'scale_labels' => $scaleLabels,
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit(Question $question)
    {
        $questionTypes = QuestionType::all();
        return view('admin.questions.edit', compact('question', 'questionTypes'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string|max:255',
            'question_type_id' => 'required|exists:question_types,id',
        ]);

        $question->update($validated);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
