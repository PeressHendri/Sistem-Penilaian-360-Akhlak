<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AssessmentProgram;
use App\Helpers\ActivityLogger;

class HCProgramController extends Controller
{
    public function index()
    {
        $programs = DB::table('assessment_programs')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hc.programs', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|string',
        ]);

        $programId = DB::table('assessment_programs')->insertGetId([
            'nama_program' => $request->input('nama_program'),
            'deskripsi' => $request->input('deskripsi'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'status' => $request->input('status'),
            'created_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        ActivityLogger::log('Membuat program penilaian baru: ' . $request->input('nama_program'), 'Program');

        return redirect()->route('hc.programs.index')->with('success', 'Program penilaian berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|string',
        ]);

        DB::table('assessment_programs')->where('id', $id)->update([
            'nama_program' => $request->input('nama_program'),
            'deskripsi' => $request->input('deskripsi'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'status' => $request->input('status'),
            'updated_at' => now(),
        ]);

        ActivityLogger::log('Memperbarui program penilaian: ' . $request->input('nama_program'), 'Program');

        return redirect()->route('hc.programs.index')->with('success', 'Program penilaian berhasil diperbarui!');
    }
}
