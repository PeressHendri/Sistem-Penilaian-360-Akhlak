<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->hasPermissionTo('lihat hasil')) {
            abort(403, 'Anda tidak memiliki akses ke modul Skor Detail.');
        }

        // Default scores for Sarah Jenkins
        $defaultScores = [
            'design_system' => 8,
            'prototyping_speed' => 9,
            'teamwork' => 7,
            'design_system_notes' => '',
            'prototyping_speed_notes' => '',
            'teamwork_notes' => '',
        ];

        $scores = session()->get('eval_scores', $defaultScores);

        $ratee = DB::table('employees')->where('id', 5)->first();
        if ($ratee) {
            $ratee->avatar_url = 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150';
        } else {
            $ratee = (object)[
                'nama' => 'Sarah Jenkins',
                'jabatan' => 'Senior UX Designer',
                'divisi' => 'Product Team',
                'avatar' => 'SJ',
                'avatar_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150',
            ];
        }

        return view('scores.index', compact('user', 'ratee', 'scores'));
    }

    public function store(Request $request)
    {
        $input = $request->only([
            'design_system',
            'prototyping_speed',
            'teamwork',
            'design_system_notes',
            'prototyping_speed_notes',
            'teamwork_notes'
        ]);

        session()->put('eval_scores', $input);

        if ($request->input('action') === 'draft') {
            return redirect()->route('scores.index')->with('success', 'Skor evaluasi berhasil disimpan sebagai draft!');
        }

        // Redirect directly to submit page for step flow
        return redirect()->route('submit.index')->with('success', 'Skor berhasil disimpan! Silakan selesaikan proses penyerahan akhir.');
    }
}
