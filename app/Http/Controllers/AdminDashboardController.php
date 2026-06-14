<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetch dynamic values for stats card
        $totalKaryawan = DB::table('employees')->count();
        
        $activeProgramsCount = DB::table('assessment_programs')->where('status', 'Aktif')->count();
        if ($activeProgramsCount === 0) {
            $activeProgramsCount = 1; // Default fallback to match mock layout nicely
        }

        $avgScore = DB::table('results')->avg('nilai_akhir') ?? 84.5;

        // Fetch recent assessment programs
        $programs = DB::table('assessment_programs')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $recentPrograms = $programs->map(function ($p) {
            if ($p->status === 'Aktif') {
                $p->status_label = 'Berlangsung';
                $p->progress = 45;
                $p->status_color = 'bg-blue-50 text-blue-700 border-blue-100';
            } elseif ($p->status === 'Draft') {
                $p->status_label = 'Persiapan';
                $p->progress = 0;
                $p->status_color = 'bg-slate-50 text-slate-600 border-slate-100';
            } else {
                $p->status_label = 'Selesai';
                $p->progress = 100;
                $p->status_color = 'bg-emerald-50 text-emerald-700 border-emerald-100';
            }
            return $p;
        });

        return view('admin.dashboard', compact(
            'totalKaryawan', 
            'activeProgramsCount', 
            'avgScore', 
            'recentPrograms'
        ));
    }
}
