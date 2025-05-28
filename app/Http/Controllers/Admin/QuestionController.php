<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Alumni;
use App\Models\QuestionType;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $employmentStatus = $request->get('employment_status');

        $query = Question::with(['questiontype', 'options', 'questionConditions'])
            ->when($search, function ($query) use ($search) {
                $query->where('question_text', 'like', '%' . $search . '%');
            });

        if ($employmentStatus) {
            $query->whereHas('questionConditions', function ($q) use ($employmentStatus) {
                $q->where('field', 'employment_status')->where('value_status_kerja', $employmentStatus);
            });
        }

        $questions = $query->paginate(10)->appends($request->query());

        $employmentStatuses = Question::EMPLOYMENT_STATUSES;

        return view('admin.questions.index', compact('questions', 'employmentStatuses'));
    }
//    public function index(Request $request)
//     {
//         $questions = Question::with('questiontype', 'questionConditions')
//             ->paginate(10);

//         $employmentStatuses = Question::EMPLOYMENT_STATUSES;

//         return view('admin.questions.index', compact('questions', 'employmentStatuses'));
//     }



    public function create()
    {
        $employmentStatuses = Question::EMPLOYMENT_STATUSES;  // Ambil dari const di model
        $questionTypes = QuestionType::all();

        return view('admin.questions.create', compact('employmentStatuses', 'questionTypes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question_text' => 'required|string|max:255',
            'question_type_id' => 'required|exists:question_types,id',
            'options' => 'nullable|array',
            'is_required' => 'nullable|boolean',
            'other_option' => 'nullable|boolean',
            'scale_range' => 'nullable|string',
            'matrix_rows' => 'nullable|array', 
            'matrix_columns' => 'nullable|array',
            'employment_conditions' => 'nullable|array',
        ]);
        
        $type = QuestionType::findOrFail($validatedData['question_type_id']);
        $typeName = $type->name;
    
        $options = null;
        $scaleLabels = null;
    
        if (in_array($typeName, ['radio', 'checkbox', 'select']) && $request->options) {
            $options = array_map('trim', $request->options);
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
                'rows' => array_map('trim', $request->matrix_rows),
                'columns' => array_map('trim', $request->matrix_columns),
            ];
        }
        
    
        $question = Question::create([
            'question_text' => $validatedData['question_text'],
            'question_type_id' => $validatedData['question_type_id'],
            'scale_labels' => !empty($scaleLabels) ? json_encode($scaleLabels) : null,
            'is_required' => $validatedData['is_required'] ?? false,
            'other_option' => $validatedData['other_option'] ?? false,
        ]);
    if (in_array($typeName, ['radio', 'checkbox', 'select']) && !empty($options)) {
        foreach ($options as $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
            ]);
        }
    }
    elseif ($typeName === 'scale' && !empty($options)) {
        foreach ($options as $optionValue) {
            $question->options()->create([
                'option_text' => $optionValue,
            ]);
        }
    }
    elseif ($typeName === 'matrix' && !empty($options['rows']) && !empty($options['columns'])) {
        foreach ($options['rows'] as $row) {
            foreach ($options['columns'] as $column) {
                $question->options()->create([
                    'option_text' => $row . ' - ' . $column,
                ]);
            }
        }
    }
    

   if (!empty($validatedData['employment_conditions'])) {
        foreach ($validatedData['employment_conditions'] as $status) {
            $question->questionConditions()->create([
                'field' => 'employment_status',   
                'value_status_kerja' => $status,               
            ]);
        }
    }

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
