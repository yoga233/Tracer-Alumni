<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Question;
use App\Models\Submission;
use Illuminate\Support\Str;
use App\Models\AlumniAnswer;
use Illuminate\Http\Request;
use App\Models\JenisPerusahaan;
use App\Models\KompetensiKerja;
use App\Models\KompetensiLulus;
use App\Models\WaktuTungguKerja;
use App\Models\KeeratanStudiKerja;

class AlumniFormController extends Controller
{
    protected array $kompetensiFields = [
        'etika' => 'Etika',
        'keahlian_bidang_ilmu' => 'Keahlian berdasarkan bidang ilmu',
        'bahasa_inggris' => 'Bahasa Inggris',
        'penggunaan_teknologi_informasi' => 'Penggunaan Teknologi Informasi',
        'komunikasi' => 'Komunikasi',
        'kerjasama_tim' => 'Kerjasama tim',
        'pengembangan_diri' => 'Pengembangan diri',
    ];


    protected array $kompetensiOptions = [
        'Sangat Rendah',
        'Rendah',
        'Cukup',
        'Tinggi',
        'Sangat Tinggi',
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
        $rules = [
            'answers.*' => 'required',
            'tahun_lulus' => 'required|digits:4|numeric',
            'npm' => 'required|string|unique:alumnis,npm',
            'nama_mahasiswa' => 'required|string',
            'nik' => 'required|string|max:20|unique:alumnis,nik',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:alumnis,email',
            'nomor_telepon' => 'nullable|string',
            'npwp' => 'nullable|string',
            'nama_dosen_pembimbing' => 'required|string',
            'status_saat_ini' => 'required|in:Bekerja (full time/part time),Belum Memungkinkan Bekerja,Tidak Kerja tetapi sedang mencari kerja,Wiraswasta,Melanjutkan Pendidikan',
        ];

        $validated = $request->validate($rules);

        $sumberPembiayaan = $request->input('sumber_pembiayaan_kuliah');
        if ($sumberPembiayaan === 'Yang lain') {
            $sumberPembiayaan = $request->input('sumber_lainnya');
        }

        $alumni = Alumni::create([
            'tahun_lulus' => $request->tahun_lulus,
            'npm' => $request->npm,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'npwp' => $request->npwp,
            'nama_dosen_pembimbing' => $request->nama_dosen_pembimbing,
            'status_saat_ini' => $request->status_saat_ini,
            'sumber_pembiayaan_kuliah' => $sumberPembiayaan,
        ]); 

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
            KompetensiLulus::create(array_merge(
            ['alumni_id' => $alumni->id],
            $request->input('kompetensi_lulus')
        ));

        KompetensiKerja::create(array_merge(
            ['alumni_id' => $alumni->id],
            $request->input('kompetensi_kerja')
        ));

     KeeratanStudiKerja::create([
    'alumni_id' => $alumni->id,
    'keeratan_bidang_studi' => $request->input('keeratan_bidang_studi.keeratan'), 
]);

JenisPerusahaan::create([
    'alumni_id' => $alumni->id,
    'jenis_perusahaan' => $request->input('jenis_perusahaan'),
]);

WaktuTungguKerja::create([
    'alumni_id' => $alumni->id,
    'waktu_tunggu_bulan' => $request->input('waktu_tunggu_pekerjaan'),  
]);
        session()->forget('submission_id');

        return redirect()->route('alumni.form')->with('success', 'Formulir sudah disubmit bree!');
    }

    // private function buildKompetensiValidation(): array
    // {
    //     $rules = [];

    //     foreach ($this->kompetensiFields as $field => $label) {
    //         $inValues = implode(',', $this->kompetensiOptions);
    //         $rules["kompetensi_lulus.$field"] = "required|in:$inValues";
    //         $rules["kompetensi_kerja.$field"] = "required|in:$inValues";
    //     }

    //     return $rules;
    // }
}
