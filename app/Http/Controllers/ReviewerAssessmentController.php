<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\ActivityLogger;

class ReviewerAssessmentController extends Controller
{
    /**
     * List all assessment tasks for the logged-in reviewer.
     */
    public function index(Request $request)
    {
        $user     = Auth::user();
        $employee = DB::table('employees')->where('id', $user->employee_id)->first();

        $forms = [];

        if ($employee) {
            $reviewerRows = DB::table('reviewers')
                ->join('employees as ratee', 'reviewers.employee_id', '=', 'ratee.id')
                ->join('assessment_programs', 'reviewers.program_id', '=', 'assessment_programs.id')
                ->where('reviewers.reviewer_id', $employee->id)
                ->select(
                    'reviewers.*',
                    'ratee.nama as ratee_nama',
                    'ratee.jabatan as ratee_jabatan',
                    'ratee.divisi as ratee_divisi',
                    'assessment_programs.nama_program',
                    'assessment_programs.tanggal_selesai'
                )
                ->orderBy('reviewers.status')
                ->get();

            foreach ($reviewerRows as $row) {
                // Check if a form already exists
                $form = DB::table('assessment_forms')
                    ->where('program_id', $row->program_id)
                    ->where('employee_id', $row->employee_id)
                    ->where('reviewer_id', $employee->id)
                    ->first();

                $row->form_id     = $form ? $form->id : null;
                $row->form_status = $form ? $form->status : 'Belum Dimulai';

                // Count how many indicators filled
                if ($form) {
                    $filled = DB::table('assessment_details')
                        ->where('form_id', $form->id)
                        ->whereNotNull('score')
                        ->count();
                    $total  = DB::table('assessment_details')->where('form_id', $form->id)->count();
                    $row->filled_count = $filled;
                    $row->total_count  = $total;
                } else {
                    $row->filled_count = 0;
                    $row->total_count  = 0;
                }

                $forms[] = $row;
            }
        }

        return view('reviewer.assessments', compact('user', 'employee', 'forms'));
    }

    /**
     * Show the assessment form for a specific reviewer row.
     * The {id} here is the reviewers.id
     */
    public function showForm($id)
    {
        $user     = Auth::user();
        $employee = DB::table('employees')->where('id', $user->employee_id)->firstOrFail();

        $reviewerRow = DB::table('reviewers')
            ->join('employees as ratee', 'reviewers.employee_id', '=', 'ratee.id')
            ->join('assessment_programs', 'reviewers.program_id', '=', 'assessment_programs.id')
            ->where('reviewers.id', $id)
            ->where('reviewers.reviewer_id', $employee->id) // security: only own tasks
            ->select(
                'reviewers.*',
                'ratee.nama as ratee_nama',
                'ratee.jabatan as ratee_jabatan',
                'ratee.divisi as ratee_divisi',
                'assessment_programs.nama_program',
                'assessment_programs.tanggal_selesai'
            )
            ->firstOrFail();

        // Get or create the form
        $form = DB::table('assessment_forms')
            ->where('program_id', $reviewerRow->program_id)
            ->where('employee_id', $reviewerRow->employee_id)
            ->where('reviewer_id', $employee->id)
            ->first();

        if (!$form) {
            $formId = DB::table('assessment_forms')->insertGetId([
                'program_id'   => $reviewerRow->program_id,
                'employee_id'  => $reviewerRow->employee_id,
                'reviewer_id'  => $employee->id,
                'status'       => 'Draft',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            // Update reviewer status to Sedang
            DB::table('reviewers')->where('id', $id)->update(['status' => 'Sedang', 'updated_at' => now()]);
            $form = DB::table('assessment_forms')->find($formId);
        }

        // Get indicators for this program, grouped by core value
        $indicatorsRaw = DB::table('indicators')
            ->join('core_values', 'indicators.core_value_id', '=', 'core_values.id')
            ->where('indicators.program_id', $reviewerRow->program_id)
            ->select('indicators.*', 'core_values.nama as core_value_nama')
            ->orderBy('core_values.id')
            ->orderBy('indicators.id')
            ->get();

        $indicators = $indicatorsRaw->map(function ($ind) {
            $ind->kode = strtoupper(substr($ind->core_value_nama, 0, 1));
            return $ind;
        });


        // Get existing answers
        $existingDetails = DB::table('assessment_details')
            ->where('form_id', $form->id)
            ->get()
            ->keyBy('indicator_id');

        // Group indicators by core value
        $groupedIndicators = [];
        foreach ($indicators as $ind) {
            $cvKey = $ind->core_value_nama;
            if (!isset($groupedIndicators[$cvKey])) {
                $groupedIndicators[$cvKey] = [
                    'kode'  => $ind->kode,
                    'nama'  => $cvKey,
                    'items' => [],
                ];
            }
            $detail = $existingDetails->get($ind->id);
            $groupedIndicators[$cvKey]['items'][] = [
                'id'          => $ind->id,
                'nama'        => $ind->nama_indikator,
                'deskripsi'   => $ind->deskripsi,
                'bobot'       => $ind->bobot,
                'score'       => $detail ? $detail->score : null,
                'comment'     => $detail ? $detail->comment : '',
            ];
        }

        $isSubmitted = $form->status === 'Submitted';

        return view('reviewer.form', compact(
            'user', 'employee', 'reviewerRow', 'form',
            'groupedIndicators', 'isSubmitted'
        ));
    }

    /**
     * Save draft (auto-save partial scores).
     */
    public function saveDraft(Request $request, $id)
    {
        $user     = Auth::user();
        $employee = DB::table('employees')->where('id', $user->employee_id)->firstOrFail();

        $form = DB::table('assessment_forms')->where('id', $id)
            ->where('reviewer_id', $employee->id)
            ->firstOrFail();

        $scores   = $request->input('scores', []);
        $comments = $request->input('comments', []);

        foreach ($scores as $indicatorId => $score) {
            $existing = DB::table('assessment_details')
                ->where('form_id', $form->id)
                ->where('indicator_id', $indicatorId)
                ->first();

            $data = [
                'score'      => is_numeric($score) ? (int) $score : null,
                'comment'    => $comments[$indicatorId] ?? null,
                'updated_at' => now(),
            ];

            if ($existing) {
                DB::table('assessment_details')->where('id', $existing->id)->update($data);
            } else {
                DB::table('assessment_details')->insert(array_merge($data, [
                    'form_id'      => $form->id,
                    'indicator_id' => $indicatorId,
                    'created_at'   => now(),
                ]));
            }
        }

        DB::table('assessment_forms')->where('id', $form->id)->update(['updated_at' => now()]);

        return response()->json(['message' => 'Draft tersimpan!', 'status' => 'ok']);
    }

    /**
     * Final submit – lock form, update reviewer status, calculate results.
     */
    public function submitAssessment(Request $request, $id)
    {
        $user     = Auth::user();
        $employee = DB::table('employees')->where('id', $user->employee_id)->firstOrFail();

        $form = DB::table('assessment_forms')->where('id', $id)
            ->where('reviewer_id', $employee->id)
            ->firstOrFail();

        if ($form->status === 'Submitted') {
            return redirect()->route('reviewer.assessments.index')
                ->with('info', 'Penilaian sudah pernah disubmit sebelumnya.');
        }

        // Save all scores first
        $scores   = $request->input('scores', []);
        $comments = $request->input('comments', []);

        foreach ($scores as $indicatorId => $score) {
            $existing = DB::table('assessment_details')
                ->where('form_id', $form->id)
                ->where('indicator_id', $indicatorId)
                ->first();

            $data = [
                'score'      => is_numeric($score) ? (int) $score : null,
                'comment'    => $comments[$indicatorId] ?? null,
                'updated_at' => now(),
            ];

            if ($existing) {
                DB::table('assessment_details')->where('id', $existing->id)->update($data);
            } else {
                DB::table('assessment_details')->insert(array_merge($data, [
                    'form_id'      => $form->id,
                    'indicator_id' => $indicatorId,
                    'created_at'   => now(),
                ]));
            }
        }

        // Lock form
        DB::table('assessment_forms')->where('id', $form->id)->update([
            'status'       => 'Submitted',
            'submitted_at' => now(),
            'updated_at'   => now(),
        ]);

        // Update reviewer row status to Selesai
        DB::table('reviewers')
            ->where('program_id', $form->program_id)
            ->where('employee_id', $form->employee_id)
            ->where('reviewer_id', $employee->id)
            ->update(['status' => 'Selesai', 'completed_at' => now(), 'updated_at' => now()]);

        // Try to calculate final result for the ratee in this program
        $this->calculateResult($form->program_id, $form->employee_id);

        ActivityLogger::log("Menyelesaikan penilaian untuk karyawan ID {$form->employee_id}", 'Form Penilaian');

        return redirect()->route('reviewer.assessments.summary', $form->id)
            ->with('success', 'Penilaian berhasil disubmit!');
    }

    /**
     * Summary page after submission.
     */
    public function showSummary($id)
    {
        $user     = Auth::user();
        $employee = DB::table('employees')->where('id', $user->employee_id)->firstOrFail();

        $form = DB::table('assessment_forms')
            ->join('employees as ratee', 'assessment_forms.employee_id', '=', 'ratee.id')
            ->join('assessment_programs', 'assessment_forms.program_id', '=', 'assessment_programs.id')
            ->where('assessment_forms.id', $id)
            ->where('assessment_forms.reviewer_id', $employee->id)
            ->select(
                'assessment_forms.*',
                'ratee.nama as ratee_nama',
                'ratee.jabatan as ratee_jabatan',
                'assessment_programs.nama_program'
            )
            ->firstOrFail();

        $detailsRaw = DB::table('assessment_details')
            ->join('indicators', 'assessment_details.indicator_id', '=', 'indicators.id')
            ->join('core_values', 'indicators.core_value_id', '=', 'core_values.id')
            ->where('assessment_details.form_id', $id)
            ->select(
                'assessment_details.*',
                'indicators.nama_indikator',
                'indicators.bobot',
                'core_values.nama as cv_nama'
            )
            ->orderBy('core_values.id')
            ->get();

        $details = $detailsRaw->map(function ($d) {
            $d->cv_kode = strtoupper(substr($d->cv_nama, 0, 1));
            return $d;
        });


        $totalScore = 0;
        $totalBobot = 0;
        foreach ($details as $d) {
            if ($d->score !== null) {
                $totalScore += $d->score * $d->bobot;
                $totalBobot += $d->bobot;
            }
        }
        $nilaiAkhir = $totalBobot > 0 ? round($totalScore / $totalBobot, 1) : 0;

        return view('reviewer.summary', compact('user', 'form', 'details', 'nilaiAkhir'));
    }

    /**
     * Internal: calculate weighted average result for a ratee.
     */
    private function calculateResult($programId, $employeeId)
    {
        // Gather all submitted forms for this employee in this program
        $forms = DB::table('assessment_forms')
            ->where('program_id', $programId)
            ->where('employee_id', $employeeId)
            ->where('status', 'Submitted')
            ->get();

        if ($forms->isEmpty()) return;

        // Get all indicators for the program with bobot/weights
        $indicators = DB::table('indicators')
            ->where('program_id', $programId)
            ->pluck('bobot', 'id');

        $totalWeightedScore = 0;
        $totalWeight        = 0;
        $totalForms         = 0;

        foreach ($forms as $form) {
            $details = DB::table('assessment_details')
                ->where('form_id', $form->id)
                ->whereNotNull('score')
                ->get();

            foreach ($details as $detail) {
                $bobot = $indicators[$detail->indicator_id] ?? 1;
                $totalWeightedScore += $detail->score * $bobot;
                $totalWeight        += $bobot;
            }
            $totalForms++;
        }

        if ($totalWeight === 0) return;

        $nilaiAkhir = round($totalWeightedScore / $totalWeight, 2);

        // Upsert result
        $existing = DB::table('results')
            ->where('program_id', $programId)
            ->where('employee_id', $employeeId)
            ->first();

        if ($existing) {
            DB::table('results')->where('id', $existing->id)->update([
                'nilai_akhir' => $nilaiAkhir,
                'updated_at'  => now(),
            ]);
        } else {
            DB::table('results')->insert([
                'program_id'  => $programId,
                'employee_id' => $employeeId,
                'nilai_akhir' => $nilaiAkhir,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
