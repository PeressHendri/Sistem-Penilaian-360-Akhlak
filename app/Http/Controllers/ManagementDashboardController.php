<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagementDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Count stats
        $totalKaryawan = DB::table('employees')->where('status', 'Aktif')->count();
        
        $program = DB::table('assessment_programs')->orderByDesc('id')->first();
        $programId = $program ? $program->id : 1;

        // Completion status
        $totalReviewers = DB::table('reviewers')->where('program_id', $programId)->count();
        $completedReviewers = DB::table('reviewers')->where('program_id', $programId)->where('status', 'Selesai')->count();
        $completionRate = $totalReviewers > 0 ? round(($completedReviewers / $totalReviewers) * 100) : 0;

        // Average score
        $avgScore = DB::table('results')->where('program_id', $programId)->avg('nilai_akhir') ?? 0;
        $avgScoreFormatted = number_format($avgScore, 1);

        // Top Performers
        $topPerformers = DB::table('results')
            ->join('employees', 'results.employee_id', '=', 'employees.id')
            ->where('results.program_id', $programId)
            ->select('results.*', 'employees.nama', 'employees.jabatan', 'employees.divisi')
            ->orderByDesc('results.nilai_akhir')
            ->limit(5)
            ->get();

        // Recent assessment submissions
        $recentAssessments = DB::table('assessment_forms')
            ->join('employees as ratee', 'assessment_forms.employee_id', '=', 'ratee.id')
            ->join('employees as rater', 'assessment_forms.reviewer_id', '=', 'rater.id')
            ->where('assessment_forms.program_id', $programId)
            ->where('assessment_forms.status', 'Submitted')
            ->select('assessment_forms.*', 'ratee.nama as ratee_nama', 'rater.nama as rater_nama')
            ->orderByDesc('assessment_forms.submitted_at')
            ->limit(5)
            ->get();

        return view('management.dashboard', compact(
            'user', 'program', 'totalKaryawan', 
            'completionRate', 'avgScoreFormatted', 
            'topPerformers', 'recentAssessments'
        ));
    }

    public function ranking(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search', '');
        $divisi = $request->get('divisi', '');

        $program = DB::table('assessment_programs')->orderByDesc('id')->first();
        $programId = $program ? $program->id : 1;

        $query = DB::table('results')
            ->join('employees', 'results.employee_id', '=', 'employees.id')
            ->where('results.program_id', $programId)
            ->select('results.*', 'employees.nama', 'employees.nik', 'employees.jabatan', 'employees.divisi');

        if ($search) {
            $query->where('employees.nama', 'like', "%{$search}%")
                  ->orWhere('employees.nik', 'like', "%{$search}%");
        }

        if ($divisi) {
            $query->where('employees.divisi', $divisi);
        }

        $results = $query->orderByDesc('results.nilai_akhir')->get();

        $rankedResults = [];
        foreach ($results as $index => $row) {
            $row->rank = $index + 1;
            $rankedResults[] = $row;
        }

        $divisions = DB::table('employees')->whereNotNull('divisi')->distinct()->pluck('divisi');

        return view('management.ranking', compact('user', 'rankedResults', 'divisions', 'search', 'divisi'));
    }
}
