<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\AlumniAnswerController;
use App\Http\Controllers\AlumniFormController;

// Redirect dari halaman utama ke halaman register
Route::get('/', function () {
    return redirect()->route('register');
});

// Setelah login, arahkan ke halaman CRUD pertanyaan admin
Route::get('/dashboard', function () {
    return redirect()->route('admin.questions.index'); // ✅ route yang benar
})->middleware(['auth', 'verified'])->name('dashboard');

// Group middleware untuk user yang sudah login (Profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Group route admin dengan prefix "admin" dan nama "admin."
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // CRUD pertanyaan
    Route::resource('questions', QuestionController::class);

    // Jawaban alumni (semua jawaban) - Tampilkan jawaban alumni dengan showAnswers
    Route::get('alumni-answers', [AnswerController::class, 'showAnswers'])->name('alumni-answers.index'); 

    // Nested route untuk jawaban dari masing-masing pertanyaan
    Route::resource('questions.answers', AnswerController::class);
});

// Route untuk alumni mengisi form
Route::get('/alumni/form', [AlumniFormController::class, 'showForm'])->name('alumni.form');
Route::post('/alumni/form', [AlumniFormController::class, 'storeForm'])->name('alumni.form.submit');

// Route auth (dari Laravel Breeze)
require __DIR__ . '/auth.php';
