<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagementEmployeeDetailController extends Controller
{
    public function index($id)
    {
        $user = Auth::user();

        $employee = DB::table('employees')->where('id', $id)->firstOrFail();

        $program = DB::table('assessment_programs')->orderByDesc('id')->first();
        $programId = $program ? $program->id : 1;

        // Fetch result
        $result = DB::table('results')
            ->where('employee_id', $id)
            ->where('program_id', $programId)
            ->first();

        $resultId = $result ? $result->id : null;

        // Fetch IDP
        $idp = null;
        if ($resultId) {
            $idp = DB::table('idps')
                ->where('employee_id', $id)
                ->where('result_id', $resultId)
                ->first();
            if ($idp) {
                // Map schema fields to view compatible fields
                $idp->target_kompetensi = $idp->strength;
                $idp->rencana_aksi      = $idp->development_plan;
                $idp->timeline          = $idp->weakness;
            }
        }


        // Fetch rating breakdown from all reviewers (submitted only)
        $detailsRaw = DB::table('assessment_details')
            ->join('assessment_forms', 'assessment_details.form_id', '=', 'assessment_forms.id')
            ->join('indicators', 'assessment_details.indicator_id', '=', 'indicators.id')
            ->join('core_values', 'indicators.core_value_id', '=', 'core_values.id')
            ->where('assessment_forms.employee_id', $id)
            ->where('assessment_forms.program_id', $programId)
            ->where('assessment_forms.status', 'Submitted')
            ->select(
                'core_values.nama as cv_nama',
                'indicators.nama_indikator',
                'indicators.bobot',
                DB::raw('AVG(assessment_details.score) as avg_score')
            )
            ->groupBy('core_values.nama', 'indicators.nama_indikator', 'indicators.bobot', 'core_values.id', 'indicators.id')
            ->orderBy('core_values.id')
            ->orderBy('indicators.id')
            ->get();

        $details = $detailsRaw->map(function ($d) {
            $d->cv_kode = strtoupper(substr($d->cv_nama, 0, 1));
            return $d;
        });


        // Fetch list of reviewers who evaluated this employee
        $reviewers = DB::table('reviewers')
            ->join('employees', 'reviewers.reviewer_id', '=', 'employees.id')
            ->where('reviewers.employee_id', $id)
            ->where('reviewers.program_id', $programId)
            ->select('employees.nama', 'reviewers.tipe_penilai', 'reviewers.status')
            ->get();

        return view('management.employee_detail', compact('user', 'employee', 'program', 'result', 'idp', 'details', 'reviewers'));
    }
}
