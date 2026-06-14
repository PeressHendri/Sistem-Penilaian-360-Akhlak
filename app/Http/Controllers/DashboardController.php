<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_karyawan'   => DB::table('employees')->count(),
            'evaluasi_aktif'   => DB::table('assessment_programs')->where('status', 'Aktif')->count(),
            'rata_kpi'         => round(DB::table('results')->avg('nilai_akhir') ?? 0, 1),
        ];

        $programs = DB::table('assessment_programs')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('dashboard.main', compact('user', 'stats', 'programs'));
    }
}
