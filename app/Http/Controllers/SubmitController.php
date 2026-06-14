<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubmitController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->hasPermissionTo('lihat hasil')) {
            abort(403, 'Anda tidak memiliki akses ke modul Submit Penilaian.');
        }

        $employee = DB::table('employees')->where('id', 1)->first();
        $result = DB::table('results')->where('employee_id', 1)->first();

        $ratee = (object)[
            'nama' => $employee ? $employee->nama : 'Budi Santoso',
            'jabatan' => $employee ? $employee->jabatan : 'Senior Software Engineer',
            'divisi' => $employee ? $employee->divisi : 'Engineering Dept',
            'nik' => $employee ? $employee->nik : 'ENG-2021-045',
            'masa_kerja' => '3 Tahun 5 Bulan',
            'penilai_utama' => 'Admin User (Engineering Manager)',
            'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=150',
            'overall_score' => $result ? $result->nilai_akhir : 85,
            'kategori' => $result ? $result->kategori : 'Melebihi Ekspektasi (A-)',
            'kekuatan' => 'Budi menunjukkan kemampuan problem-solving yang luar biasa pada proyek X. Inisiatif dalam memimpin sesi knowledge-sharing sangat membantu tim junior.',
            'pengembangan' => 'Perlu meningkatkan komunikasi proaktif dengan stakeholder eksternal terkait timeline rilis. Disarankan mengikuti pelatihan manajemen proyek dasar.',
        ];

        return view('submit.index', compact('user', 'ratee'));
    }

    public function store(Request $request)
    {
        $agree = $request->has('agree');

        if (!$agree) {
            return redirect()->back()->withErrors(['agree' => 'Anda harus memberikan persetujuan penilai sebelum mengirimkan penilaian.']);
        }

        // Finalize submit
        return redirect()->route('dashboard')->with('success', 'Penilaian untuk Budi Santoso berhasil diserahkan secara permanen!');
    }
}
