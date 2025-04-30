<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\AlumniAnswerController;
use App\Http\Controllers\AlumniFormController;
use App\Http\Controllers\Admin\DashboardController;

// Redirect dari halaman utama ke halaman register
Route::get('/', function () {
    return redirect()->route('register');
});

// Setelah login, arahkan ke halaman CRUD pertanyaan admin
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard'); // ✅ route yang benar
})->middleware(['auth', 'verified'])->name('dashboard');

// Group middleware untuk user yang sudah login (Profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Group route admin dengan prefix "admin" dan nama "admin."
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Route untuk dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'showdashboard'])->name('dashboard');

    // Route::get('/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('dashboard');
    

    // CRUD pertanyaan
    Route::resource('questions', QuestionController::class);

    // Jawaban alumni (semua jawaban) - Tampilkan jawaban alumni dengan showAnswers
    Route::get('alumni-answers', [AnswerController::class, 'showAnswers'])->name('alumni-answers.index');
    // hapus alumni answers
    // Route::delete('alumni-answers/{question}/answers/{answer}', [AnswerController::class, 'destroy'])->name('alumni-answers.destroy'); 
    // Route::delete('/admin/answers/{answer}', [AlumniAnswerController::class, 'destroy'])->name('admin.answers.destroy');
    // Menghapus submission + jawaban + alumni (jika perlu)
    Route::delete('/alumni-answers/{submissionId}', [AnswerController::class, 'destroyBySubmission'])->name('alumni_answers.destroy');
        


    // Nested route untuk jawaban dari masing-masing pertanyaan
    Route::resource('questions.answers', AnswerController::class);
});

// Route untuk alumni mengisi form
Route::get('/alumni/form', [AlumniFormController::class, 'showForm'])->name('alumni.form');
Route::post('/alumni/form', [AlumniFormController::class, 'storeForm'])->name('alumni.form.submit');

// Route auth (dari Laravel Breeze)
require __DIR__ . '/auth.php';
