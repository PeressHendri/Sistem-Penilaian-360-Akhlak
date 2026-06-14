<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\ActivityLogger;

class HCWeightController extends Controller
{
    public function index()
    {
        $program = DB::table('assessment_programs')->first();
        $programId = $program ? $program->id : 1;

        $indicators = DB::table('indicators')
            ->join('core_values', 'indicators.core_value_id', '=', 'core_values.id')
            ->select('indicators.*', 'core_values.nama as core_value_nama')
            ->where('indicators.program_id', $programId)
            ->get();

        if ($indicators->isEmpty()) {
            $indicators = DB::table('indicators')->get();
        }

        return view('hc.weights', compact('indicators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'weights' => 'required|array',
            'weights.*' => 'required|integer|min:0|max:100',
        ]);

        $weights = $request->input('weights');
        $sum = array_sum($weights);

        if ($sum !== 100) {
            return back()->withErrors(['weights' => 'Total bobot harus tepat 100%. Akumulasi saat ini: ' . $sum . '%'])->withInput();
        }

        // Update database
        foreach ($weights as $id => $weight) {
            DB::table('indicators')->where('id', $id)->update([
                'bobot' => $weight,
                'updated_at' => now(),
            ]);
        }

        ActivityLogger::log('Memperbarui bobot kriteria AKHLAK', 'Bobot');

        return redirect()->route('hc.weights.index')->with('success', 'Konfigurasi bobot indikator berhasil disimpan!');
    }
}
