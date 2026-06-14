<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagementAnalyticController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $program = DB::table('assessment_programs')->orderByDesc('id')->first();
        $programId = $program ? $program->id : 1;

        // 1. Division Average Performance Chart Data
        $divisionAverages = DB::table('results')
            ->join('employees', 'results.employee_id', '=', 'employees.id')
            ->where('results.program_id', $programId)
            ->select('employees.divisi', DB::raw('AVG(results.nilai_akhir) as avg_score'), DB::raw('COUNT(results.id) as total_employee'))
            ->groupBy('employees.divisi')
            ->orderByDesc('avg_score')
            ->get();

        // 2. Core Values Averages Chart Data
        $coreValuesRaw = DB::table('assessment_details')
            ->join('assessment_forms', 'assessment_details.form_id', '=', 'assessment_forms.id')
            ->join('indicators', 'assessment_details.indicator_id', '=', 'indicators.id')
            ->join('core_values', 'indicators.core_value_id', '=', 'core_values.id')
            ->where('assessment_forms.program_id', $programId)
            ->where('assessment_forms.status', 'Submitted')
            ->select('core_values.nama', DB::raw('AVG(assessment_details.score) as avg_score'))
            ->groupBy('core_values.id', 'core_values.nama')
            ->orderBy('core_values.id')
            ->get();

        $coreValuesAverages = $coreValuesRaw->map(function ($cv) {
            $cv->kode = strtoupper(substr($cv->nama, 0, 1));
            return $cv;
        });


        // 3. Distribution Metrics
        $totalResults = DB::table('results')->where('results.program_id', $programId)->count();
        $distribution = [
            'Star'             => DB::table('talent_mappings')->join('results', 'talent_mappings.result_id', '=', 'results.id')->where('results.program_id', $programId)->where('talent_mappings.box_position', 'Star')->count(),
            'Core'             => DB::table('talent_mappings')->join('results', 'talent_mappings.result_id', '=', 'results.id')->where('results.program_id', $programId)->where('talent_mappings.box_position', 'Core')->count(),
            'Need Improvement' => DB::table('talent_mappings')->join('results', 'talent_mappings.result_id', '=', 'results.id')->where('results.program_id', $programId)->where('talent_mappings.box_position', 'Need Improvement')->count(),
            'Underperformer'   => DB::table('talent_mappings')->join('results', 'talent_mappings.result_id', '=', 'results.id')->where('results.program_id', $programId)->where('talent_mappings.box_position', 'Underperformer')->count(),
        ];


        return view('management.analytics', compact(
            'user', 'program', 'divisionAverages', 'coreValuesAverages', 'distribution', 'totalResults'
        ));
    }
}
