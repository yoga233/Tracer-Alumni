<?php

// app/Http/Controllers/Admin/AlumniAnswerController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniAnswer;
use Illuminate\Http\Request;

class AlumniAnswerController extends Controller
{
    public function index()
    {
        $answers = AlumniAnswer::with('question')->latest()->paginate(10);

        return view('admin.alumni_answers.index', compact('answers'));
    }
}

