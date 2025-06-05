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
        $alumni = Alumni::where('tahun_lulus', '>=', 2020)->count();

        // status pekerjaan alumni
        $employment_status = Alumni::where('tahun_lulus', '>=', 2020)
            ->groupBy('status_saat_ini')
            ->select('status_saat_ini', DB::raw('count(*) as total'))
            ->get();

        if ($employment_status->isEmpty()) {
            $employment_status = collect(['Belum Ada Data' => 1]);
        }

        // alumni per angkatan
        $graduationChart = Alumni::where('tahun_lulus', '>=', 2020)
            ->selectRaw('tahun_lulus, COUNT(*) as total')
            ->groupBy('tahun_lulus')
            ->orderBy('tahun_lulus')
            ->pluck('total', 'tahun_lulus');

        if ($graduationChart->isEmpty()) {
            $graduationChart = collect(['Belum Ada Data' => 1]);
        }

        // Hapus bagian alumni per jurusan karena kolom 'major' tidak ada
        // Kalau mau tampilkan data jurusan, pastikan kolomnya ada di database dulu

        return view('admin.dashboard', compact(
            'alumni',
            'employment_status',
            'graduationChart'
        ));
    }
}