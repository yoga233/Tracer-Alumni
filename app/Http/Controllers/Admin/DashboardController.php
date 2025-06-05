<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alumni;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function showdashboard()
    {
        $alumni = Alumni::where('graduation_year', '>=', 2020)->count();

        //status pekerjaan alumni
        $employment_status = Alumni::where('graduation_year', '>=', 2020)
            ->select('employment_status', DB::raw('count(*) as total'))
            ->groupBy('employment_status')
            ->pluck('total', 'employment_status');

        if ($employment_status->isEmpty()) {
            $employment_status = collect(['Belum Ada Data' => 1]);
        }

        //alumni per angkatan
        $graduationChart = Alumni::where('graduation_year', '>=', 2020)
            ->selectRaw('graduation_year, COUNT(*) as total')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year')
            ->pluck('total', 'graduation_year');

            if ($graduationChart->isEmpty()) {
                $graduationChart = collect(['Belum Ada Data' => 1]);
            }

        //alumni per jurusan
        $majorChart = Alumni::where('graduation_year', '>=', 2020)
            ->select('major', DB::raw('count(*) as total'))
            ->groupBy('major')
            ->pluck('total', 'major');

            if ($majorChart->isEmpty()) {
                $majorChart = collect(['Belum Ada Data' => 1]);
            }

        return view('admin.dashboard', compact(
            'alumni',
            'employment_status',
            'graduationChart',
            'majorChart'
        ));
    }
}
