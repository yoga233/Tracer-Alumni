<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use App\Models\GraduateCompetencie;
use App\Models\WorkCompetencie;
use Illuminate\Support\Facades\DB;
use App\Models\Alumni;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    // public function showReport(Request $request)
    // {
    //     // tahun lulus unik
    //     $graduationYears = Alumni::selectRaw('DISTINCT graduation_year')->orderBy('graduation_year', 'desc')
    //                             ->pluck('graduation_year')
    //                             ->toArray();
    //     // status pekerjaan unik
    //     $employmentStatuses = Alumni::selectRaw('DISTINCT employment_status')
    //                                 ->pluck('employment_status')
    //                                 ->toArray();
    //     // mengambil data dari request
    //     $selectedYears = $request->input('graduation_year', []); 
    //     $selectedStatus = $request->input('employment_status', 'semua');

    //     // query dasar buat chart dari dropdown
    //     $query = Alumni::query();
    //     if (!empty($selectedYears)) {
    //         $query->whereIn('graduation_year', $selectedYears);
    //     }
        
    //     if ($selectedStatus !== 'semua') {
    //         $query->where('employment_status', $selectedStatus);
    //     }

    //     $result = $query->select('graduation_year', DB::raw('COUNT(*) as total'))
    //                     ->groupBy('graduation_year')
    //                     ->orderBy('graduation_year')
    //                     ->get();

    //     $labels = $result->pluck('graduation_year')->toArray();
    //     $counts = $result->pluck('total')->toArray();

    //     return view('admin.reports.index', compact(
    //         'graduationYears',
    //         'employmentStatuses',
    //         'selectedYears',
    //         'selectedStatus',
    //         'labels',
    //         'counts'
    //     ));
    // }

        public function showReport(Request $request)
        {
            // Data kategori & subkategori
            $categories = [
                'status_kerja' => ['Status Pekerjaan'],
                'waktu_tunggu' => ['Waktu Tunggu'],
                'jenis_perusahaan' => ['Jenis Perusahaan'],
                'keeratan_bidang_studi' => ['Keeratan Bidang Studi dengan Pekerjaan'],
                'kompetensi_lulus' => [
                    'Etika',
                    'Keahlian berdasarkan bidang ilmu',
                    'Bahasa Inggris',
                    'Penggunaan Teknologi Informasi',
                    'Komunikasi',
                    'Kerjasama Tim',
                    'Pengembangan Diri',
                ],
                'kompetensi_bekerja' => [
                    'Etika',
                    'Keahlian berdasarkan bidang ilmu',
                    'Bahasa Inggris',
                    'Penggunaan Teknologi Informasi',
                    'Komunikasi',
                    'Kerjasama Tim',
                    'Pengembangan Diri',
                ],
            ];

            // Ambil filter tahun lulus dan status kerja dari request
            $graduationYears = Alumni::selectRaw('DISTINCT graduation_year')->orderBy('graduation_year', 'desc')->pluck('graduation_year')->toArray();
            $employmentStatuses = Alumni::selectRaw('DISTINCT employment_status')->pluck('employment_status')->toArray();

            $selectedYears = $request->input('graduation_year', []);
            $selectedStatus = $request->input('employment_status', 'semua');

            $category = $request->input('category');
            $subcategory = $request->input('subcategory'); // fix: jangan pakai sub_category

            $chartLabels = [];
            $chartCounts = [];

          if ($category && isset($categories[$category])) {
                // Untuk kompetensi -> butuh subkategori
                if (in_array($category, ['kompetensi_lulus', 'kompetensi_bekerja'])) {
                    if ($subcategory) {
                        // Proses kompetensi
                        $modelClass = $category === 'kompetensi_lulus' ? GraduateCompetencie::class : WorkCompetencie::class;

                        $fieldMap = [
                            'Etika' => 'ethics',
                            'Keahlian berdasarkan bidang ilmu' => 'field_expertise',
                            'Bahasa Inggris' => 'english',
                            'Penggunaan Teknologi Informasi' => 'it_usage',
                            'Komunikasi' => 'communication',
                            'Kerjasama Tim' => 'teamwork',
                            'Pengembangan Diri' => 'self_development',
                        ];
                        $field = $fieldMap[$subcategory] ?? null;

                        if ($field) {
                            $query = $modelClass::query()
                                ->join('alumnis', 'alumnis.id', '=', $modelClass::getModel()->getTable() . '.alumni_id');

                            if (!empty($selectedYears)) {
                                $query->whereIn('alumnis.graduation_year', $selectedYears);
                            }
                            if ($selectedStatus !== 'semua') {
                                $query->where('alumnis.employment_status', $selectedStatus);
                            }

                            $data = $query->select($field, DB::raw('COUNT(*) as total'))
                                ->groupBy($field)
                                ->orderBy($field)
                                ->get();

                            $chartLabels = $data->pluck($field)->toArray();
                            $chartCounts = $data->pluck('total')->toArray();
                        }
                    }
                } else {
                    // Untuk kategori lain, langsung tampilkan chart tanpa subkategori
                    $fieldMap = [
                        'status_kerja' => 'employment_status',
                        'waktu_tunggu' => 'mounth_waiting',
                        'jenis_perusahaan' => 'type_company',
                        'keeratan_bidang_studi' => 'closeness_workfield',
                    ];
                    $field = $fieldMap[$category] ?? null;

                    if ($field) {
                        $query = Alumni::query();

                        if (!empty($selectedYears)) {
                            $query->whereIn('graduation_year', $selectedYears);
                        }
                        if ($selectedStatus !== 'semua') {
                            $query->where('employment_status', $selectedStatus);
                        }

                        $data = $query->select($field, DB::raw('COUNT(*) as total'))
                            ->groupBy($field)
                            ->orderBy($field)
                            ->get();

                        $chartLabels = $data->pluck($field)->toArray();
                        $chartCounts = $data->pluck('total')->toArray();
                    }
                }
            }

            return view('admin.reports.index', compact(
                'categories', 'category', 'subcategory',
                'chartLabels', 'chartCounts',
                'graduationYears', 'employmentStatuses', 'selectedYears', 'selectedStatus'
            ));
        }



}



