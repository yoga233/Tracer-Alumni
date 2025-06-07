<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Models\WaktuTungguKerja;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // public function showdashboard()
    // {
    //     $alumni = Alumni::where('tahun_lulus', '>=', 2020)->count();

    //     // status pekerjaan alumni
    //     $employment_status = Alumni::where('tahun_lulus', '>=', 2020)
    //         ->groupBy('status_saat_ini')
    //         ->select('status_saat_ini', DB::raw('count(*) as total'))
    //         ->get();

    //     if ($employment_status->isEmpty()) {
    //         $employment_status = collect(['Belum Ada Data' => 1]);
    //     }

    //     // alumni per angkatan
    //     $graduationChart = Alumni::where('tahun_lulus', '>=', 2020)
    //         ->selectRaw('tahun_lulus, COUNT(*) as total')
    //         ->groupBy('tahun_lulus')
    //         ->orderBy('tahun_lulus')
    //         ->pluck('total', 'tahun_lulus');

    //     if ($graduationChart->isEmpty()) {
    //         $graduationChart = collect(['Belum Ada Data' => 1]);
    //     }

    //     // Hapus bagian alumni per jurusan karena kolom 'major' tidak ada
    //     // Kalau mau tampilkan data jurusan, pastikan kolomnya ada di database dulu

    //     return view('admin.dashboard', compact(
    //         'alumni',
    //         'employment_status',
    //         'graduationChart'
    //     ));
    // }

  public function showdashboard()
{
    $alumni = Alumni::count();
    $statusAlumni = Alumni::whereNotNull('status_saat_ini')
        ->select('status_saat_ini', DB::raw('count(*) as total'))
        ->groupBy('status_saat_ini')
        ->orderBy('status_saat_ini')
        ->get();

    $statusAlumniLabels = $statusAlumni->pluck('status_saat_ini');
    $statusAlumniData = $statusAlumni->pluck('total');

    $waktuTunggu = DB::table('waktu_tunggu_kerja')
        ->join('alumnis', 'alumnis.id', '=', 'waktu_tunggu_kerja.alumni_id')
        ->whereNotNull('waktu_tunggu_bulan')
        ->select('waktu_tunggu_bulan', DB::raw('COUNT(*) as total'))
        ->groupBy('waktu_tunggu_bulan')
        ->orderBy('waktu_tunggu_bulan')
        ->get();

    $waktuTungguLabels = $waktuTunggu->pluck('waktu_tunggu_bulan');
    $waktuTungguData = $waktuTunggu->pluck('total');

    $angkatan = Alumni::select('tahun_lulus', DB::raw('COUNT(*) as total'))
        ->groupBy('tahun_lulus')
        ->orderBy('tahun_lulus')
        ->get();

    $angkatanLabels = $angkatan->pluck('tahun_lulus');
    $angkatanData = $angkatan->pluck('total');

    return view('admin.dashboard', compact(
        'alumni',
        'statusAlumniLabels', 'statusAlumniData',
        'waktuTungguLabels', 'waktuTungguData',
        'angkatanLabels', 'angkatanData'
    ));
}



}