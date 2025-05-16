<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\AlumniAnswerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AlumniFormController;


// 🔁 Redirect halaman utama ke register
Route::get('/', fn () => redirect()->route('login'));

// ✅ Redirect setelah login ke dashboard admin
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 🔒 Route untuk user yang sudah login (Profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔐 Admin route group
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // 📊 Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'showdashboard'])->name('dashboard');

    // ❓ CRUD Pertanyaan
    Route::resource('questions', QuestionController::class);

    // 📝 Jawaban Alumni
    Route::get('admin/alumni-answers', [AnswerController::class, 'kebutuhanFilter'])->name('admin.alumni_answers.index');

    // 📝 Jawaban Alumni - daftar & hapus
    Route::get('alumni-answers', [AnswerController::class, 'showAnswers'])->name('alumni-answers.index');
    Route::delete('alumni-answers/{submissionId}', [AnswerController::class, 'destroyBySubmission'])->name('alumni_answers.destroy');
  
    // Sudah di dalam prefix('admin') dan name('admin.')
    Route::get('alumni_answers/detail/{id}', [AnswerController::class, 'detailJawaban'])->name('alumni_answers.detail');




    // 🧩 Nested Jawaban per Pertanyaan
    Route::resource('questions.answers', AnswerController::class);

    // 📈 Statistik & Laporan
    Route::get('reports', [ReportController::class, 'showReport'])->name('reports.showReport');
});

// 🧑‍🎓 Route untuk alumni isi form
Route::get('/alumni/form', [AlumniFormController::class, 'showForm'])->name('alumni.form');
Route::post('/alumni/form', [AlumniFormController::class, 'storeForm'])->name('alumni.form.submit');

// 🛡️ Auth Routes (Laravel Breeze)
require __DIR__ . '/auth.php';
