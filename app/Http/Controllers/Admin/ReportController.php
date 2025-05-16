<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
// use App\Http\Controllers\Admin\DB;
use Illuminate\Support\Facades\DB;
use App\Models\Alumni;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function showReport(Request $request)
    {
        // tahun lulus unik
        $graduationYears = Alumni::selectRaw('DISTINCT graduation_year')->orderBy('graduation_year', 'desc')
                                ->pluck('graduation_year')
                                ->toArray();
        // status pekerjaan unik
        $employmentStatuses = Alumni::selectRaw('DISTINCT employment_status')
                                    ->pluck('employment_status')
                                    ->toArray();
        // mengambil data dari request
        $selectedYears = $request->input('graduation_year', []); 
        $selectedStatus = $request->input('employment_status', 'semua');

        // query dasar buat chart dari dropdown
        $query = Alumni::query();
        if (!empty($selectedYears)) {
            $query->whereIn('graduation_year', $selectedYears);
        }
        
        if ($selectedStatus !== 'semua') {
            $query->where('employment_status', $selectedStatus);
        }

        $result = $query->select('graduation_year', DB::raw('COUNT(*) as total'))
                        ->groupBy('graduation_year')
                        ->orderBy('graduation_year')
                        ->get();

        $labels = $result->pluck('graduation_year')->toArray();
        $counts = $result->pluck('total')->toArray();

        return view('admin.reports.index', compact(
            'graduationYears',
            'employmentStatuses',
            'selectedYears',
            'selectedStatus',
            'labels',
            'counts'
        ));
    }


}



