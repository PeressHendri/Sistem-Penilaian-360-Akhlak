<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagementTalentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $program = DB::table('assessment_programs')
            ->where('status', 'Aktif')
            ->orWhere('status', 'Selesai')
            ->orderByDesc('id')
            ->first();

        $programId = $program ? $program->id : null;

        $talentData = [];
        $quadrantStats = [
            'Star'       => 0,
            'Core'       => 0,
            'Need Improvement' => 0,
            'Underperformer'   => 0,
        ];

        if ($programId) {
            $results = DB::table('results')
                ->join('employees', 'results.employee_id', '=', 'employees.id')
                ->where('results.program_id', $programId)
                ->select('results.*', 'employees.nama', 'employees.jabatan', 'employees.divisi', 'employees.nik')
                ->orderByDesc('results.nilai_akhir')
                ->get();

            foreach ($results as $r) {
                $talent = DB::table('talent_mappings')
                    ->where('result_id', $r->id)
                    ->first();

                $kategori = $talent ? $talent->box_position : $this->autoCategory($r->nilai_akhir);
                $potentialStr = $this->autoPotential($r->nilai_akhir);
                $potentialScore = $talent ? $talent->potential_score : ($potentialStr === 'High' ? 85.0 : ($potentialStr === 'Medium' ? 70.0 : 50.0));

                $quadrantStats[$kategori] = ($quadrantStats[$kategori] ?? 0) + 1;

                $talentData[] = [
                    'id'         => $r->employee_id,
                    'nik'        => $r->nik,
                    'nama'       => $r->nama,
                    'jabatan'    => $r->jabatan,
                    'divisi'     => $r->divisi,
                    'nilai'      => $r->nilai_akhir,
                    'kategori'   => $kategori,
                    'potential'  => $potentialScore >= 80 ? 'High' : ($potentialScore >= 60 ? 'Medium' : 'Low'),
                ];
            }
        }

        return view('management.talent', compact('user', 'program', 'talentData', 'quadrantStats'));
    }

    private function autoCategory(float $nilai): string
    {
        if ($nilai >= 85) return 'Star';
        if ($nilai >= 70) return 'Core';
        if ($nilai >= 55) return 'Need Improvement';
        return 'Underperformer';
    }

    private function autoPotential(float $nilai): string
    {
        if ($nilai >= 85) return 'High';
        if ($nilai >= 70) return 'Medium';
        return 'Low';
    }
}

