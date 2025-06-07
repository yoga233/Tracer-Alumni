<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Models\JenisPerusahaan;
use App\Models\KompetensiKerja;
use App\Models\KompetensiLulus;
use App\Models\WaktuTungguKerja;
use App\Models\KeeratanStudiKerja;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    //     public function showReport(Request $request)
    // {
    //     // Kategori utama untuk laporan (dropdown utama)
    //     $categories = [
    //         'status_kerja' => ['Status Pekerjaan'],
    //         'waktu_tunggu' => ['Waktu Tunggu Pekerjaan'],
    //         'jenis_perusahaan' => ['Jenis Perusahaan'],
    //         'keeratan_bidang_studi' => ['Keeratan Bidang Studi dengan Pekerjaan'],
    //         'kompetensi_lulus' => [
    //             'Etika', 'Keahlian berdasarkan bidang ilmu', 'Bahasa Inggris',
    //             'Penggunaan Teknologi Informasi', 'Komunikasi', 'Kerjasama Tim', 'Pengembangan Diri',
    //         ],
    //         'kompetensi_bekerja' => [
    //             'Etika', 'Keahlian berdasarkan bidang ilmu', 'Bahasa Inggris',
    //             'Penggunaan Teknologi Informasi', 'Komunikasi', 'Kerjasama Tim', 'Pengembangan Diri',
    //         ],
    //     ];

    //     // Ambil daftar tahun lulusan yang unik dan urutkan dari terbaru
    //     $graduationYears = Alumni::selectRaw('DISTINCT tahun_lulus')
    //         ->orderBy('tahun_lulus', 'desc')
    //         ->pluck('tahun_lulus')
    //         ->toArray();

    //     // Ambil daftar status kerja yang unik
    //     $employmentStatuses = Alumni::selectRaw('DISTINCT status_saat_ini')
    //         ->pluck('status_saat_ini')
    //         ->toArray();

    //     // Ambil input dari request untuk filter
    //     $selectedYears = $request->input('graduation_year', []); // filter tahun
    //     $selectedStatus = $request->input('employment_status', 'semua'); // filter status kerja
    //     $category = $request->input('category'); // kategori utama
    //     $subcategory = $request->input('subcategory'); // subkategori (khusus kompetensi)

    //     // Inisialisasi data untuk chart
    //     $chartLabels = [];
    //     $chartCounts = [];

    //     // Proses jika kategori dipilih dan valid
    //     if ($category && isset($categories[$category])) {

    //         // ==================== A. Jika Kategori adalah Kompetensi ====================
    //         if (in_array($category, ['kompetensi_lulus', 'kompetensi_bekerja'])) {
    //             if ($subcategory) {
    //                 // Tentukan model sesuai kategori
    //                 $modelClass = $category === 'kompetensi_lulus' ? KompetensiLulus::class : KompetensiKerja::class;

    //                 // Peta subkategori ke nama field di database
    //                 $fieldMap = [
    //                     'Etika' => 'etika',
    //                     'Keahlian berdasarkan bidang ilmu' => 'keahlian_bidang_ilmu',
    //                     'Bahasa Inggris' => 'bahasa_inggris',
    //                     'Penggunaan Teknologi Informasi' => 'penggunaan_teknologi_informasi',
    //                     'Komunikasi' => 'komunikasi',
    //                     'Kerjasama Tim' => 'kerjasama_tim',
    //                     'Pengembangan Diri' => 'pengembangan_diri',
    //                 ];
    //                 $field = $fieldMap[$subcategory] ?? null;

    //                 // Proses jika field valid
    //                 if ($field) {
    //                     $query = $modelClass::query()
    //                         ->join('alumnis', 'alumnis.id', '=', $modelClass::getModel()->getTable() . '.alumni_id');

    //                     // Tambahkan filter tahun & status jika ada
    //                     if (!empty($selectedYears)) {
    //                         $query->whereIn('alumnis.tahun_lulus', $selectedYears);
    //                     }
    //                     if ($selectedStatus !== 'semua') {
    //                         $query->where('alumnis.status_saat_ini', $selectedStatus);
    //                     }

    //                     $data = $query->select($field, DB::raw('COUNT(*) as total'))
    //                         ->groupBy($field)
    //                         ->orderBy($field)
    //                         ->get();

    //                     $chartLabels = $data->pluck($field)->toArray();
    //                     $chartCounts = $data->pluck('total')->toArray();
    //                 }
    //             }

    //         // ==================== B. Kategori Lain ====================
    //         } else {
    //             $fieldMap = [
    //                 'status_kerja' => 'status_saat_ini',
    //             ];

    //             // ----------- Kategori waktu tunggu kerja (relasi tabel) -----------
    //             if ($category === 'waktu_tunggu') {
    //                 $query = WaktuTungguKerja::query()
    //                     ->join('alumnis', 'alumnis.id', '=', 'waktu_tunggu_kerja.alumni_id');

    //                 if (!empty($selectedYears)) {
    //                     $query->whereIn('alumnis.tahun_lulus', $selectedYears);
    //                 }
    //                 if ($selectedStatus !== 'semua') {
    //                     $query->where('alumnis.status_saat_ini', $selectedStatus);
    //                 }

    //                 $data = $query->select('waktu_tunggu_bulan', DB::raw('COUNT(*) as total'))
    //                     ->groupBy('waktu_tunggu_bulan')
    //                     ->orderBy('waktu_tunggu_bulan')
    //                     ->get();

    //                 $chartLabels = $data->pluck('waktu_tunggu_bulan')->toArray();
    //                 $chartCounts = $data->pluck('total')->toArray();

    //             // ----------- Kategori jenis perusahaan (relasi tabel) -----------
    //             } elseif ($category === 'jenis_perusahaan') {
    //                 $query = JenisPerusahaan::query()
    //                     ->join('alumnis', 'alumnis.id', '=', 'jenis_perusahaan.alumni_id');

    //                 if (!empty($selectedYears)) {
    //                     $query->whereIn('alumnis.tahun_lulus', $selectedYears);
    //                 }
    //                 if ($selectedStatus !== 'semua') {
    //                     $query->where('alumnis.status_saat_ini', $selectedStatus);
    //                 }

    //                 $data = $query->select('jenis_perusahaan', DB::raw('COUNT(*) as total'))
    //                     ->groupBy('jenis_perusahaan')
    //                     ->orderBy('jenis_perusahaan')
    //                     ->get();

    //                 $chartLabels = $data->pluck('jenis_perusahaan')->toArray();
    //                 $chartCounts = $data->pluck('total')->toArray();

    //             // ----------- Kategori keeratan bidang studi (relasi tabel) -----------
    //             } elseif ($category === 'keeratan_bidang_studi') {
    //                 $query = KeeratanStudiKerja::query()
    //                     ->join('alumnis', 'alumnis.id', '=', 'keeratan_studi_kerja.alumni_id');

    //                 if (!empty($selectedYears)) {
    //                     $query->whereIn('alumnis.tahun_lulus', $selectedYears);
    //                 }
    //                 if ($selectedStatus !== 'semua') {
    //                     $query->where('alumnis.status_saat_ini', $selectedStatus);
    //                 }

    //                 $data = $query->select('keeratan_bidang_studi', DB::raw('COUNT(*) as total'))
    //                     ->groupBy('keeratan_bidang_studi')
    //                     ->orderBy('keeratan_bidang_studi')
    //                     ->get();

    //                 $chartLabels = $data->pluck('keeratan_bidang_studi')->toArray();
    //                 $chartCounts = $data->pluck('total')->toArray();

    //             // ----------- Kategori status kerja -----------
    //             } elseif ($category === 'status_kerja') {
    //                 $query = Alumni::query();

    //                 if (!empty($selectedYears)) {
    //                     $query->whereIn('tahun_lulus', $selectedYears);
    //                 }
    //                 if ($selectedStatus !== 'semua') {
    //                     $query->where('status_saat_ini', $selectedStatus);
    //                 }

    //                 $data = $query->select('status_saat_ini', DB::raw('COUNT(*) as total'))
    //                     ->groupBy('status_saat_ini')
    //                     ->orderBy('status_saat_ini')
    //                     ->get();

    //                 $chartLabels = $data->pluck('status_saat_ini')->toArray();
    //                 $chartCounts = $data->pluck('total')->toArray();

    //             // ----------- Kategori lain -----------
    //             } else {
    //                 $field = $fieldMap[$category] ?? null;

    //                 if ($field) {
    //                     $query = Alumni::query();

    //                     if (!empty($selectedYears)) {
    //                         $query->whereIn('tahun_lulus', $selectedYears);
    //                     }
    //                     if ($selectedStatus !== 'semua') {
    //                         $query->where('status_saat_ini', $selectedStatus);
    //                     }

    //                     $data = $query->select($field, DB::raw('COUNT(*) as total'))
    //                         ->groupBy($field)
    //                         ->orderBy($field)
    //                         ->get();

    //                     $chartLabels = $data->pluck($field)->toArray();
    //                     $chartCounts = $data->pluck('total')->toArray();
    //                 }
    //             }
    //         }
    //     }

    //     // Render view laporan
    //     return view('admin.reports.index', compact(
    //         'categories', 'category', 'subcategory',
    //         'chartLabels', 'chartCounts',
    //         'graduationYears', 'employmentStatuses',
    //         'selectedYears', 'selectedStatus'
    //     ));
    // }


    public function showReport(Request $request)
{
    // Kategori utama untuk dropdown utama
    $categories = [
        'status_kerja' => ['Status Pekerjaan'],
        'waktu_tunggu' => ['Waktu Tunggu Pekerjaan'],
        'jenis_perusahaan' => ['Jenis Perusahaan'],
        'keeratan_bidang_studi' => ['Keeratan Bidang Studi dengan Pekerjaan'],
        'kompetensi_lulus' => [
            'Etika', 'Keahlian berdasarkan bidang ilmu', 'Bahasa Inggris',
            'Penggunaan Teknologi Informasi', 'Komunikasi', 'Kerjasama Tim', 'Pengembangan Diri',
        ],
        'kompetensi_bekerja' => [
            'Etika', 'Keahlian berdasarkan bidang ilmu', 'Bahasa Inggris',
            'Penggunaan Teknologi Informasi', 'Komunikasi', 'Kerjasama Tim', 'Pengembangan Diri',
        ],
    ];

    // Ambil daftar tahun lulusan yang unik dan urutkan dari terbaru
    $graduationYears = Alumni::selectRaw('DISTINCT tahun_lulus')
        ->orderBy('tahun_lulus', 'desc')
        ->pluck('tahun_lulus')
        ->toArray();

    // Ambil daftar status kerja yang unik
    $employmentStatuses = Alumni::selectRaw('DISTINCT status_saat_ini')
        ->pluck('status_saat_ini')
        ->toArray();

    // Ambil input dari request untuk filter
    $selectedYears = $request->input('graduation_year', []); // filter tahun
    $selectedStatus = $request->input('employment_status', 'semua'); // filter status kerja
    $category = $request->input('category'); // kategori utama
    $subcategory = $request->input('subcategory'); // subkategori (khusus kompetensi)

    // Inisialisasi data untuk chart
    $chartLabels = [];
    $chartCounts = [];

    // Proses jika kategori dipilih dan valid
    if ($category && isset($categories[$category])) {

        // ==================== A. Jika Kategori adalah Kompetensi ====================
        if (in_array($category, ['kompetensi_lulus', 'kompetensi_bekerja'])) {
            if ($subcategory) {
                // Tentukan model sesuai kategori
                $modelClass = $category === 'kompetensi_lulus' ? KompetensiLulus::class : KompetensiKerja::class;

                // Peta subkategori ke nama field di database
                $fieldMap = [
                    'Etika' => 'etika',
                    'Keahlian berdasarkan bidang ilmu' => 'keahlian_bidang_ilmu',
                    'Bahasa Inggris' => 'bahasa_inggris',
                    'Penggunaan Teknologi Informasi' => 'penggunaan_teknologi_informasi',
                    'Komunikasi' => 'komunikasi',
                    'Kerjasama Tim' => 'kerjasama_tim',
                    'Pengembangan Diri' => 'pengembangan_diri',
                ];
                $field = $fieldMap[$subcategory] ?? null;

                // Proses jika field valid
                if ($field) {
                    $query = $modelClass::query()
                        ->join('alumnis', 'alumnis.id', '=', $modelClass::getModel()->getTable() . '.alumni_id');

                    // Tambahkan filter tahun & status jika ada
                    if (!empty($selectedYears)) {
                        $query->whereIn('alumnis.tahun_lulus', $selectedYears);
                    }
                    if ($selectedStatus !== 'semua') {
                        $query->where('alumnis.status_saat_ini', $selectedStatus);
                    }

                    // whereNotNull untuk menghindari nampilkan data null
                    $query->whereNotNull($field);

                    $data = $query->select($field, DB::raw('COUNT(*) as total'))
                        ->groupBy($field)
                        ->orderBy($field)
                        ->get();

                    $chartLabels = $data->pluck($field)->toArray();
                    $chartCounts = $data->pluck('total')->toArray();
                }
            }

        // ==================== B. Kategori Lain ====================
        } else {
            $fieldMap = [
                'status_kerja' => 'status_saat_ini',
            ];

            // ----------- Kategori waktu tunggu kerja (relasi tabel) -----------
            if ($category === 'waktu_tunggu') {
                $query = WaktuTungguKerja::query()
                    ->join('alumnis', 'alumnis.id', '=', 'waktu_tunggu_kerja.alumni_id');

                if (!empty($selectedYears)) {
                    $query->whereIn('alumnis.tahun_lulus', $selectedYears);
                }
                if ($selectedStatus !== 'semua') {
                    $query->where('alumnis.status_saat_ini', $selectedStatus);
                }

                 // whereNotNull untuk menghindari nampilkan data null
                $query->whereNotNull('waktu_tunggu_bulan');

                $data = $query->select('waktu_tunggu_bulan', DB::raw('COUNT(*) as total'))
                    ->groupBy('waktu_tunggu_bulan')
                    ->orderBy('waktu_tunggu_bulan')
                    ->get();

                $chartLabels = $data->pluck('waktu_tunggu_bulan')->toArray();
                $chartCounts = $data->pluck('total')->toArray();

            // ----------- Kategori jenis perusahaan (relasi tabel) -----------
            } elseif ($category === 'jenis_perusahaan') {
                $query = JenisPerusahaan::query()
                    ->join('alumnis', 'alumnis.id', '=', 'jenis_perusahaan.alumni_id');

                if (!empty($selectedYears)) {
                    $query->whereIn('alumnis.tahun_lulus', $selectedYears);
                }
                if ($selectedStatus !== 'semua') {
                    $query->where('alumnis.status_saat_ini', $selectedStatus);
                }

                // whereNotNull untuk menghindari nampilkan data null
                $query->whereNotNull('jenis_perusahaan');

                $data = $query->select('jenis_perusahaan', DB::raw('COUNT(*) as total'))
                    ->groupBy('jenis_perusahaan')
                    ->orderBy('jenis_perusahaan')
                    ->get();

                $chartLabels = $data->pluck('jenis_perusahaan')->toArray();
                $chartCounts = $data->pluck('total')->toArray();

            // ----------- Kategori keeratan bidang studi (relasi tabel) -----------
            } elseif ($category === 'keeratan_bidang_studi') {
                $query = KeeratanStudiKerja::query()
                    ->join('alumnis', 'alumnis.id', '=', 'keeratan_studi_kerja.alumni_id');

                if (!empty($selectedYears)) {
                    $query->whereIn('alumnis.tahun_lulus', $selectedYears);
                }
                if ($selectedStatus !== 'semua') {
                    $query->where('alumnis.status_saat_ini', $selectedStatus);
                }

                // Filter null pada keeratan_bidang_studi
                $query->whereNotNull('keeratan_bidang_studi');

                $data = $query->select('keeratan_bidang_studi', DB::raw('COUNT(*) as total'))
                    ->groupBy('keeratan_bidang_studi')
                    ->orderBy('keeratan_bidang_studi')
                    ->get();

                $chartLabels = $data->pluck('keeratan_bidang_studi')->toArray();
                $chartCounts = $data->pluck('total')->toArray();

            // ----------- Kategori status kerja -----------
            } elseif ($category === 'status_kerja') {
                $query = Alumni::query();

                if (!empty($selectedYears)) {
                    $query->whereIn('tahun_lulus', $selectedYears);
                }
                if ($selectedStatus !== 'semua') {
                    $query->where('status_saat_ini', $selectedStatus);
                }

                 // whereNotNull untuk menghindari nampilkan data null
                $query->whereNotNull('status_saat_ini');

                $data = $query->select('status_saat_ini', DB::raw('COUNT(*) as total'))
                    ->groupBy('status_saat_ini')
                    ->orderBy('status_saat_ini')
                    ->get();

                $chartLabels = $data->pluck('status_saat_ini')->toArray();
                $chartCounts = $data->pluck('total')->toArray();

            // ----------- Kategori lain -----------
            } else {
                $field = $fieldMap[$category] ?? null;

                if ($field) {
                    $query = Alumni::query();

                    if (!empty($selectedYears)) {
                        $query->whereIn('tahun_lulus', $selectedYears);
                    }
                    if ($selectedStatus !== 'semua') {
                        $query->where('status_saat_ini', $selectedStatus);
                    }

                     // whereNotNull untuk menghindari nampilkan data null
                    $query->whereNotNull($field);

                    $data = $query->select($field, DB::raw('COUNT(*) as total'))
                        ->groupBy($field)
                        ->orderBy($field)
                        ->get();

                    $chartLabels = $data->pluck($field)->toArray();
                    $chartCounts = $data->pluck('total')->toArray();
                }
            }
        }
    }

    // Render view laporan
    return view('admin.reports.index', compact(
        'categories', 'category', 'subcategory',
        'chartLabels', 'chartCounts',
        'graduationYears', 'employmentStatuses',
        'selectedYears', 'selectedStatus'
    ));
}


}