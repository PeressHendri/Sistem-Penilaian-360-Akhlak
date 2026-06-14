<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

class HCDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_karyawan'       => Employee::count(),
            'program_aktif'        => DB::table('assessment_programs')->where('status', 'Aktif')->count(),
            'penilaian_berjalan'   => DB::table('reviewers')->where('status', '!=', 'Selesai')->count(),
            'penilaian_selesai'    => DB::table('reviewers')->where('status', '=', 'Selesai')->count(),
        ];

        // Recent evaluation cycles details
        $programs = DB::table('assessment_programs')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('hc.dashboard', compact('stats', 'programs'));
    }
}
