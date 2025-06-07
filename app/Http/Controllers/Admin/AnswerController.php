<?php
namespace App\Http\Controllers\Admin;

use App\Models\Submission;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\WaktuTungguKerja;
use App\Models\AlumniAnswer;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    

    public function destroyBySubmission($submissionId)
    {
        $submission = Submission::with('alumni', 'alumniAnswers')->findOrFail($submissionId);
        $submission->alumniAnswers()->delete();
        $submission->alumni()->delete();
        $submission->delete();
    
        return redirect()->back()->with('success', 'Data alumni dan jawabannya berhasil dihapus.');
    }

//     public function showAnswers()
// {
//     $keyword = request('keyword');
//     $withQuestions = !empty($keyword);

//     $questionIds = [];
//     $questions = collect();

//     if ($withQuestions) {
//         $questions = Question::where('question_text', 'like', '%' . $keyword . '%')->get();
//         $questionIds = $questions->pluck('id')->toArray();
//     } else {
//         $questions = Question::all();
//     }

//     $submissionQuery = Submission::with(['alumni', 'alumniAnswers.question']);

//     if ($withQuestions && count($questionIds) > 0) {
//         $submissionQuery->whereHas('alumniAnswers', function ($q) use ($questionIds) {
//             $q->whereIn('question_id', $questionIds)
//               ->whereNotNull('answer')
//               ->where('answer', '!=', '');
//         });
//     }

//     if ($startDate = request('start_date')) {
//         $submissionQuery->whereDate('created_at', $startDate);
//     }

//     if (($graduationYear = request('graduation_year')) && $graduationYear !== 'all') {
//         $submissionQuery->whereHas('alumni', function ($q) use ($graduationYear) {
//             $q->where('tahun_lulus', $graduationYear);
//         });
//     }

//     if (($status = request('status')) && $status !== 'all') {
//         $submissionQuery->whereHas('alumni', function ($q) use ($status) {
//             $q->where('status_saat_ini', $status);
//         });
//     }

//     $submissions = $submissionQuery->paginate(10)->withQueryString();

//     // Susun data jawaban per alumni
//     $alumniRows = [];

//     foreach ($submissions as $submission) {
//         $alumni = $submission->alumni;

//         $row = [
//             'submission_id' => $submission->id,
//             'created_at' => $submission->created_at,
//             'alumni' => [
//                 'npm' => $alumni->npm,
//                 'nama_mahasiswa' => $alumni->nama_mahasiswa,
//                 'email' => $alumni->email,
//                 'nomor_telepon' => $alumni->nomor_telepon,
//                 'status_saat_ini' => $alumni->status_saat_ini,
//                 'tahun_lulus' => $alumni->tahun_lulus,
//             ],
//         ];

//         foreach ($questions as $q) {
//             $row[$q->question_text] = '-';
//         }

//         foreach ($submission->alumniAnswers as $answer) {
//             $row[$answer->question->question_text] = $answer->answer;
//         }

//         $alumniRows[] = $row;
//     }

//     // Sesuaikan kolom filter
//     $graduationYears = Alumni::pluck('tahun_lulus')->unique()->sort()->values();
//     $employmentStatuses = Alumni::pluck('status_saat_ini')->unique()->sort()->values();

//     return view('admin.alumni_answers.index', [
//         'questions' => $questions,
//         'submissions' => $submissions,
//         'alumniRows' => $alumniRows,
//         'graduationYears' => $graduationYears,
//         'employmentStatuses' => $employmentStatuses,
//         'withQuestions' => $withQuestions,
//     ]);
// }

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

    $submissionQuery = Submission::with(['alumni','alumni.WaktuTungguKerja', 'alumniAnswers.question']);

    //kata kunci
    if ($withQuestions && count($questionIds) > 0) {
        $submissionQuery->whereHas('alumniAnswers', function ($q) use ($questionIds) {
            $q->whereIn('question_id', $questionIds)
              ->whereNotNull('answer')
              ->where('answer', '!=', '');
        });
    }

    //waktu pengisian
    if ($startDate = request('start_date')) {
        $submissionQuery->whereDate('created_at', $startDate);
    }

    //tahun lulus
    if (($tahunlulus = request('tahun_lulus')) && $tahunlulus !== 'all') {
        $submissionQuery->whereHas('alumni', function ($q) use ($tahunlulus) {
            $q->where('tahun_lulus', $tahunlulus);
        });
    }

    //status kerja
    if (($statuskerja = request('status_kerja')) && $statuskerja !== 'all') {
        $submissionQuery->whereHas('alumni', function ($q) use ($statuskerja) {
            $q->where('status_saat_ini', $statuskerja);
        });
    }

    $submissions = $submissionQuery->paginate(10)->withQueryString();

    $alumniRows = [];

    foreach ($submissions as $submission) {
        $alumni = $submission->alumni;

        $row = [
            'submission_id' => $submission->id,
            'created_at' => $submission->created_at,
            'alumni' => $alumni,
            'waktu_tunggu' => $alumni->waktuTungguKerja,

        ];

        foreach ($questions as $q) {
            $row[$q->question_text] = '-';
        }

        foreach ($submission->alumniAnswers as $answer) {
            if ($answer->question) {
                $row[$answer->question->question_text] = $answer->answer;
            }
        }

        $alumniRows[] = $row;
    }

    // Ambil data unik dan sorting sesuai atribut schema
    $graduationYears = Alumni::pluck('tahun_lulus')->unique()->sort()->values();
    $employmentStatuses = Alumni::pluck('status_saat_ini')->unique()->sort()->values();

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
    try {
        $submission = Submission::with([
            'alumni',
            'alumniAnswers.question',
            'alumni.waktuTungguKerja',
            'alumni.jenisPerusahaan',
            'alumni.keeratanStudiKerja',
            'alumni.kompetensiLulus',
            'alumni.kompetensiKerja',
        ])->findOrFail($submissionId);

        $alumni = $submission->alumni;

       return response()->json([
    'submission_id' => $submission->id,
    'created_at' => $submission->created_at,
    'alumni' => [
        'tahun_lulus' => $alumni->tahun_lulus,
        'npm' => $alumni->npm,
        'nama_mahasiswa' => $alumni->nama_mahasiswa,
        'nik' => $alumni->nik,
        'tanggal_lahir' => $alumni->tanggal_lahir,
        'email' => $alumni->email,
        'nomor_telepon' => $alumni->nomor_telepon,
        'npwp' => $alumni->npwp,
        'nama_dosen_pembimbing' => $alumni->nama_dosen_pembimbing,
        'sumber_pembiayaan_kuliah' => $alumni->sumber_pembiayaan_kuliah,
        'status_saat_ini' => $alumni->status_saat_ini,
        'alamat' => $alumni->alamat,
    ],
    'waktu_kerja' => [
        'waktu_tunggu_kerja' => $alumni->waktuTungguKerja->waktu_tunggu_bulan ?? '-',
    ],
    'jenis_perusahaan' => [
        'jenis_perusahaan' => $alumni->jenisPerusahaan->jenis_perusahaan ?? '-',
    ],
    'keeratan_studi_kerja' => [
        'keeratan_studi_kerja' => $alumni->keeratanStudiKerja->keeratan_bidang_studi ?? '-',
    ],
    'kompetensiLulus' => [   // key ini harus sama di frontend
        'etika' => optional($alumni->kompetensiLulus)->etika,
        'keahlian_bidang_ilmu' => optional($alumni->kompetensiLulus)->keahlian_bidang_ilmu,
        'bahasa_inggris' => optional($alumni->kompetensiLulus)->bahasa_inggris,
        'penggunaan_teknologi_informasi' => optional($alumni->kompetensiLulus)->penggunaan_teknologi_informasi,
        'komunikasi' => optional($alumni->kompetensiLulus)->komunikasi,
        'kerjasama_tim' => optional($alumni->kompetensiLulus)->kerjasama_tim,
        'pengembangan_diri' => optional($alumni->kompetensiLulus)->pengembangan_diri,
    ],
    'kompetensiKerja' => [    // key ini harus sama di frontend
        'etika' => optional($alumni->kompetensiKerja)->etika,
        'keahlian_bidang_ilmu' => optional($alumni->kompetensiKerja)->keahlian_bidang_ilmu,
        'bahasa_inggris' => optional($alumni->kompetensiKerja)->bahasa_inggris,
        'penggunaan_teknologi_informasi' => optional($alumni->kompetensiKerja)->penggunaan_teknologi_informasi,
        'komunikasi' => optional($alumni->kompetensiKerja)->komunikasi,
        'kerjasama_tim' => optional($alumni->kompetensiKerja)->kerjasama_tim,
        'pengembangan_diri' => optional($alumni->kompetensiKerja)->pengembangan_diri,
    ],
    'alumniAnswers' => $submission->alumniAnswers->map(function ($answer) {
        return [
            'question' => $answer->question->question_text ?? 'Pertanyaan tidak ditemukan',
            'answer' => $answer->answer,
        ];
    })->toArray(),
]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'error' => 'Submission dengan ID ' . $submissionId . ' tidak ditemukan.'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Terjadi kesalahan server: ' . $e->getMessage()
        ], 500);
    }
}



}
