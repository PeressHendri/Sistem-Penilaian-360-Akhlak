<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\ActivityLogger;

class IndicatorController extends Controller
{
    public function index()
    {
        // Get core values and indicators mapped to the first program
        $program = DB::table('assessment_programs')->first();
        $programId = $program ? $program->id : 1;

        $indicators = DB::table('indicators')
            ->join('core_values', 'indicators.core_value_id', '=', 'core_values.id')
            ->select('indicators.*', 'core_values.nama as core_value_nama')
            ->where('indicators.program_id', $programId)
            ->get();

        if ($indicators->isEmpty()) {
            // Seeder fallback query
            $indicators = DB::table('indicators')->get();
        }

        return view('hc.indicators', compact('indicators'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'indicators' => 'required|array',
            'indicators.*.deskripsi' => 'required|string',
            'indicators.*.bobot' => 'required|numeric|min:0|max:100',
        ]);

        $totalBobot = 0;
        foreach ($request->input('indicators') as $id => $data) {
            $totalBobot += (int) $data['bobot'];
        }

        if ($totalBobot !== 100) {
            return redirect()->back()->with('error', 'Total bobot harus tepat 100%! Saat ini totalnya: ' . $totalBobot . '%')->withInput();
        }

        foreach ($request->input('indicators') as $id => $data) {
            DB::table('indicators')->where('id', $id)->update([
                'deskripsi' => $data['deskripsi'],
                'bobot' => $data['bobot'],
                'updated_at' => now(),
            ]);
        }

        ActivityLogger::log('Memperbarui indikator & bobot AKHLAK', 'Indikator');

        return redirect()->route('hc.indicators.index')->with('success', 'Konfigurasi indikator & bobot AKHLAK berhasil disimpan!');
    }
}
