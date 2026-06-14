<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\ActivityLogger;

class HCIdpController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $program = DB::table('assessment_programs')
            ->orderByDesc('id')
            ->first();
        $programId = $program ? $program->id : null;

        $employeeList = [];

        if ($programId) {
            // Get employees with talent mapping by joining results and employees
            $employees = DB::table('results')
                ->join('employees', 'results.employee_id', '=', 'employees.id')
                ->leftJoin('talent_mappings', 'talent_mappings.result_id', '=', 'results.id')
                ->where('results.program_id', $programId)
                ->select(
                    'talent_mappings.box_position as kategori', 
                    'results.id as result_id', 
                    'results.nilai_akhir', 
                    'employees.nama', 
                    'employees.jabatan', 
                    'employees.divisi', 
                    'employees.nik', 
                    'employees.id as employee_id',
                    'results.program_id'
                )
                ->orderBy('employees.nama')
                ->get();

            // Fetch existing IDPs linked to these results
            $idps = DB::table('idps')
                ->whereIn('result_id', $employees->pluck('result_id'))
                ->get()
                ->keyBy('result_id');

            $employeeList = $employees->map(function ($emp) use ($idps) {
                // Fallback category if not yet mapped
                if (!$emp->kategori) {
                    $emp->kategori = $this->autoCategory($emp->nilai_akhir);
                }
                
                $idp = $idps->get($emp->result_id);
                if ($idp) {
                    // Map schema fields to view compatible fields
                    $idp->target_kompetensi = $idp->strength;
                    $idp->rencana_aksi      = $idp->development_plan;
                    $idp->timeline          = $idp->weakness;
                }
                $emp->idp = $idp;
                return $emp;
            });
        }

        return view('hc.idp', compact('user', 'program', 'employeeList'));
    }

    private function autoCategory(float $nilai): string
    {
        if ($nilai >= 85) return 'Star';
        if ($nilai >= 70) return 'Core';
        if ($nilai >= 55) return 'Need Improvement';
        return 'Underperformer';
    }


    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'program_id'  => 'required|integer',
            'target_kompetensi'  => 'required|string|max:500',
            'rencana_aksi'       => 'required|string|max:1000',
            'timeline'           => 'required|string|max:255',
            'status'             => 'required|string|in:Rencana,Sedang Berjalan,Selesai',
        ]);

        $result = DB::table('results')
            ->where('employee_id', $request->employee_id)
            ->where('program_id', $request->program_id)
            ->first();

        $resultId = $result ? $result->id : null;

        $existing = DB::table('idps')
            ->where('employee_id', $request->employee_id)
            ->where('result_id', $resultId)
            ->first();

        $data = [
            'employee_id'      => $request->employee_id,
            'result_id'        => $resultId,
            'strength'         => $request->target_kompetensi,
            'development_plan' => $request->rencana_aksi,
            'weakness'         => $request->timeline, // save timeline in weakness field
            'status'           => $request->status,
            'updated_at'       => now(),
        ];

        if ($existing) {
            DB::table('idps')->where('id', $existing->id)->update($data);
            $action = 'memperbarui';
        } else {
            $data['created_at'] = now();
            DB::table('idps')->insert($data);
            $action = 'membuat';
        }

        $emp = DB::table('employees')->find($request->employee_id);
        ActivityLogger::log("HC {$action} IDP untuk " . ($emp->nama ?? 'karyawan'), 'IDP');

        return redirect()->route('hc.idp.index')->with('success', 'IDP berhasil disimpan!');
    }
}

