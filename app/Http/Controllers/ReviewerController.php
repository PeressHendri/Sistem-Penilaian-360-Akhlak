<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Helpers\ActivityLogger;

class ReviewerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search', '');

        $employees = Employee::when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
            })
            ->where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        $demoRatees = [];
        $totalRatees = 0;
        $readyRatees = 0;
        $incompleteRatees = 0;

        $program = DB::table('assessment_programs')->first();
        $programId = $program ? $program->id : 1;

        foreach ($employees as $emp) {
            $reviewersCount = DB::table('reviewers')
                ->where('program_id', $programId)
                ->where('employee_id', $emp->id)
                ->count();

            // Status is 'Ready' if they have at least 2 reviewers, otherwise 'Incomplete'
            $status = $reviewersCount >= 2 ? 'Ready' : 'Incomplete';

            $totalRatees++;
            if ($status === 'Ready') {
                $readyRatees++;
            } else {
                $incompleteRatees++;
            }

            // Generate initials
            $words = explode(' ', $emp->nama);
            $initials = strtoupper(($words[0][0] ?? '') . (isset($words[1][0]) ? $words[1][0] : ''));

            $colors = ['bg-emerald-100 text-emerald-600', 'bg-indigo-100 text-indigo-600', 'bg-sky-100 text-sky-600', 'bg-teal-100 text-teal-600'];
            $color = $colors[$emp->id % count($colors)];

            // Get reviewers list
            $listPenilai = DB::table('reviewers')
                ->join('employees', 'reviewers.reviewer_id', '=', 'employees.id')
                ->select('employees.nama', 'reviewers.tipe_penilai', 'reviewers.status')
                ->where('reviewers.program_id', $programId)
                ->where('reviewers.employee_id', $emp->id)
                ->get();

            $demoRatees[] = [
                'id' => $emp->id,
                'nik' => $emp->nik,
                'nama' => $emp->nama,
                'jabatan' => $emp->jabatan,
                'divisi' => $emp->divisi,
                'avatar' => $initials,
                'avatar_color' => $color,
                'jumlah_penilai' => $reviewersCount,
                'status' => $status,
                'penilai_list' => $listPenilai
            ];
        }

        $percentageReady = $totalRatees > 0 ? round(($readyRatees / $totalRatees) * 100) : 0;

        $stats = [
            'total_ratees' => $totalRatees,
            'ready_ratees' => $readyRatees,
            'incomplete_ratees' => $incompleteRatees,
            'percentage_ready' => $percentageReady
        ];

        return view('hc.reviewers', compact('user', 'demoRatees', 'search', 'stats'));
    }

    public function generateReviewers(Request $request)
    {
        $program = DB::table('assessment_programs')->first();
        $programId = $program ? $program->id : 1;

        $employees = Employee::where('status', 'Aktif')->get();
        $count = 0;

        foreach ($employees as $emp) {
            // Delete existing reviewers for this employee in this program
            DB::table('reviewers')
                ->where('program_id', $programId)
                ->where('employee_id', $emp->id)
                ->delete();

            // 1. Atasan (Manager)
            if ($emp->atasan_id) {
                DB::table('reviewers')->insert([
                    'program_id' => $programId,
                    'employee_id' => $emp->id,
                    'reviewer_id' => $emp->atasan_id,
                    'tipe_penilai' => 'Atasan',
                    'status' => 'Belum',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $count++;
            }

            // 2. Rekan Kerja (Peers) in same division
            $peers = Employee::where('divisi', $emp->divisi)
                ->where('id', '!=', $emp->id)
                ->where('id', '!=', $emp->atasan_id)
                ->where('status', 'Aktif')
                ->limit(2)
                ->get();

            foreach ($peers as $peer) {
                DB::table('reviewers')->insert([
                    'program_id' => $programId,
                    'employee_id' => $emp->id,
                    'reviewer_id' => $peer->id,
                    'tipe_penilai' => 'Rekan',
                    'status' => 'Belum',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $count++;
            }

            // 3. Bawahan (Subordinates)
            $subordinates = Employee::where('atasan_id', $emp->id)
                ->where('status', 'Aktif')
                ->limit(2)
                ->get();

            foreach ($subordinates as $sub) {
                DB::table('reviewers')->insert([
                    'program_id' => $programId,
                    'employee_id' => $emp->id,
                    'reviewer_id' => $sub->id,
                    'tipe_penilai' => 'Bawahan',
                    'status' => 'Belum',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $count++;
            }
        }

        ActivityLogger::log("Membentuk {$count} relasi penilai (Atasan, Rekan, Bawahan) secara otomatis", 'Penilai');

        return redirect()->route('hc.reviewers.index')->with('success', 'Relasi Rater penilai (' . $count . ' rater) berhasil dibuat secara otomatis berdasarkan struktur organisasi!');
    }

    public function sendManualNotification(Request $request)
    {
        // Fetch all reviewers with 'Belum' status
        $pendingCount = DB::table('reviewers')->where('status', '!=', 'Selesai')->count();

        ActivityLogger::log("Mengirim {$pendingCount} notifikasi pengingat evaluasi", 'Penilai');

        return redirect()->route('hc.reviewers.index')->with('success', "Notifikasi pengingat berhasil dikirim secara realtime kepada {$pendingCount} Rater yang belum menyelesaikan penilaian!");
    }
}
