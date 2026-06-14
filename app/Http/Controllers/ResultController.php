<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\ActivityLogger;

class ResultController extends Controller
{
    public function index()
    {
        $program = DB::table('assessment_programs')->first();
        $programId = $program ? $program->id : 1;

        // Fetch all assessment results sorted by final score desc to calculate ranks
        $results = DB::table('results')
            ->join('employees', 'results.employee_id', '=', 'employees.id')
            ->join('assessment_programs', 'results.program_id', '=', 'assessment_programs.id')
            ->select('results.*', 'employees.nama as employee_nama', 'employees.nik as employee_nik', 'employees.jabatan as employee_jabatan', 'employees.divisi as employee_divisi', 'assessment_programs.nama_program')
            ->where('results.program_id', $programId)
            ->orderBy('results.nilai_akhir', 'desc')
            ->get();

        $rankedResults = [];
        foreach ($results as $index => $row) {
            $row->rank = $index + 1;

            // Fetch comments from assessment details
            $comments = DB::table('assessment_details')
                ->join('assessment_forms', 'assessment_details.form_id', '=', 'assessment_forms.id')
                ->where('assessment_forms.employee_id', $row->employee_id)
                ->whereNotNull('assessment_details.comment')
                ->where('assessment_details.comment', '!=', '')
                ->pluck('assessment_details.comment')
                ->toArray();

            $row->comments = !empty($comments) ? $comments : ['Sangat baik mempertahankan kinerjanya.'];
            $rankedResults[] = $row;
        }

        return view('hc.results', compact('rankedResults'));
    }
}
