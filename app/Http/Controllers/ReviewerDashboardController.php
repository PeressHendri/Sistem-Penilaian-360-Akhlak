<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = DB::table('employees')->where('id', $user->employee_id)->first();


        $totalTugas    = 0;
        $selesai       = 0;
        $belum         = 0;
        $sedang        = 0;
        $recentForms   = [];
        $upcomingDeadlines = [];

        if ($employee) {
            // All forms where this employee is a reviewer
            $reviewerRows = DB::table('reviewers')
                ->join('employees as ratee', 'reviewers.employee_id', '=', 'ratee.id')
                ->join('assessment_programs', 'reviewers.program_id', '=', 'assessment_programs.id')
                ->where('reviewers.reviewer_id', $employee->id)
                ->select(
                    'reviewers.*',
                    'ratee.nama as ratee_nama',
                    'ratee.jabatan as ratee_jabatan',
                    'ratee.divisi as ratee_divisi',
                    'assessment_programs.nama_program',
                    'assessment_programs.tanggal_mulai',
                    'assessment_programs.tanggal_selesai'
                )
                ->orderByDesc('reviewers.updated_at')
                ->get();

            $totalTugas = $reviewerRows->count();
            $selesai    = $reviewerRows->where('status', 'Selesai')->count();
            $sedang     = $reviewerRows->where('status', 'Sedang')->count();
            $belum      = $reviewerRows->where('status', 'Belum')->count();

            // Enrich each row with form_id if exists
            foreach ($reviewerRows as $row) {
                $form = DB::table('assessment_forms')
                    ->where('program_id', $row->program_id)
                    ->where('employee_id', $row->employee_id)
                    ->where('reviewer_id', $employee->id)
                    ->first();

                $row->form_id    = $form ? $form->id : null;
                $row->form_status = $form ? $form->status : 'Draft';
            }

            $recentForms = $reviewerRows->take(10)->values();

            // Upcoming deadlines = programs that are not ended yet
            $upcomingDeadlines = $reviewerRows
                ->filter(fn($r) => $r->status !== 'Selesai')
                ->take(5)
                ->values();
        }

        $progress = $totalTugas > 0 ? round(($selesai / $totalTugas) * 100) : 0;

        return view('reviewer.dashboard', compact(
            'user', 'employee',
            'totalTugas', 'selesai', 'belum', 'sedang',
            'recentForms', 'upcomingDeadlines', 'progress'
        ));
    }
}
