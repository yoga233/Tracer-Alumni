<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            // Pertanyaan umum dengan tipe input
            ['question_text' => 'Tahun Lulus', 'question_type_id' => 1],
            ['question_text' => 'Nomor Pokok Mahasiswa (NPM)', 'question_type_id' => 1],
            ['question_text' => 'Nama Mahasiswa', 'question_type_id' => 1],
            ['question_text' => 'NIK / Nomor KTP', 'question_type_id' => 1],
            ['question_text' => 'Tanggal Lahir', 'question_type_id' => 1],
            ['question_text' => 'Alamat Email', 'question_type_id' => 1],
            ['question_text' => 'Nomor Telepon / HP', 'question_type_id' => 1],
            ['question_text' => 'NPWP', 'question_type_id' => 1],
            ['question_text' => 'Nama Dosen Pembimbing (tulis tanpa gelar)', 'question_type_id' => 1],

            // Pertanyaan dengan opsi pilihan
            [
                'question_text' => 'Sebutkan sumber dana dalam pembiayaan kuliah saat kuliah di ITATS?',
                'question_type_id' => 3,
                'options' => json_encode([
                    "Biaya Sendiri / Keluarga",
                    "Beasiswa ADIK",
                    "Beasiswa BIDIK MISI",
                    "Beasiswa PPA",
                    "Beasiswa AFIRMASI",
                    "Beasiswa Perusahaan/Swasta",
                    "Yang lain"
                ])
            ],

            [
                'question_text' => 'Jelaskan status Anda saat ini?',
                'question_type_id' => 3,
                'options' => json_encode([
                    "Bekerja (full time/part time)",
                    "Belum memungkinkan bekerja",
                    "Wiraswasta",
                    "Melanjutkan Pendidikan",
                    "Tidak Kerja Tetapi sedang mencari kerja"
                ])
            ],

            [
                'question_text' => 'Apakah Anda aktif mencari pekerjaan dalam 6 bulan terakhir?',
                'question_type_id' => 3,
                'options' => json_encode([
                    "Ya",
                    "Tidak"
                ])
            ],

            [
                'question_text' => 'Jika saat ini Anda tidak bekerja, apa alasan utamanya?',
                'question_type_id' => 3,
                'options' => json_encode([
                    "Masih menunggu hasil lamaran kerja",
                    "Melanjutkan pendidikan",
                    "Mengurus keluarga",
                    "Belum siap bekerja",
                    "Lainnya"
                ])
            ],

            [
                'question_text' => 'Berapa rata-rata pendapatan Anda per bulan saat ini?',
                'question_type_id' => 3,
                'options' => json_encode([
                    "< Rp 1.000.000",
                    "Rp 1.000.000 - Rp 3.000.000",
                    "Rp 3.000.000 - Rp 5.000.000",
                    "Rp 5.000.000 - Rp 10.000.000",
                    "> Rp 10.000.000"
                ])
            ],

            // Pertanyaan dengan input teks panjang
            [
                'question_text' => 'Apa jenis pekerjaan Anda saat ini?',
                'question_type_id' => 2
            ],

            [
                'question_text' => 'Apa nama perusahaan tempat Anda bekerja sekarang?',
                'question_type_id' => 1
            ],

            [
                'question_text' => 'Apakah pekerjaan Anda sesuai dengan bidang studi Anda?',
                'question_type_id' => 3,
                'options' => json_encode([
                    "Sangat Sesuai",
                    "Sesuai",
                    "Tidak Sesuai"
                ])
            ],

            [
                'question_text' => 'Berapa lama waktu yang Anda butuhkan untuk mendapatkan pekerjaan pertama setelah lulus?',
                'question_type_id' => 3,
                'options' => json_encode([
                    "< 3 bulan",
                    "3 - 6 bulan",
                    "6 - 12 bulan",
                    "> 12 bulan",
                    "Belum bekerja"
                ])
            ],

            [
                'question_text' => 'Saran dan masukan untuk peningkatan kualitas pembelajaran di ITATS:',
                'question_type_id' => 2
            ],
        ];

        // Menyimpan data ke dalam database
        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
