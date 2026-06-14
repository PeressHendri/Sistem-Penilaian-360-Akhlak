<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Helpers\ActivityLogger;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search', '');

        $employees = Employee::with('atasan')
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('divisi', 'like', "%{$search}%")
                      ->orWhere('jabatan', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->get();

        // Get list of potential managers (all employees)
        $managers = Employee::orderBy('nama')->get();

        return view('hc.employees', compact('employees', 'search', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|unique:employees,nik',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string',
            'jabatan' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|string',
            'atasan_id' => 'nullable|exists:employees,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employees', 'public');
            $data['photo'] = $path;
        }

        $emp = Employee::create($data);

        ActivityLogger::log('Menambahkan karyawan baru: ' . $emp->nama . ' (' . $emp->nik . ')', 'Karyawan');

        return redirect()->route('hc.employees.index')->with('success', 'Karyawan ' . $emp->nama . ' berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|string|unique:employees,nik,' . $id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'nullable|string',
            'jabatan' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|string',
            'atasan_id' => 'nullable|exists:employees,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        $emp = Employee::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($emp->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($emp->photo);
            }
            $path = $request->file('photo')->store('employees', 'public');
            $data['photo'] = $path;
        } elseif ($request->boolean('remove_photo')) {
            if ($emp->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($emp->photo);
            }
            $data['photo'] = null;
        }

        $emp->update($data);

        ActivityLogger::log('Memperbarui data karyawan: ' . $emp->nama, 'Karyawan');

        return redirect()->route('hc.employees.index')->with('success', 'Karyawan ' . $emp->nama . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $emp = Employee::findOrFail($id);
        $name = $emp->nama;
        
        if ($emp->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($emp->photo);
        }
        
        $emp->delete();

        ActivityLogger::log('Menghapus data karyawan: ' . $name, 'Karyawan');

        return redirect()->route('hc.employees.index')->with('success', 'Karyawan ' . $name . ' berhasil dihapus!');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:txt,csv',
        ]);

        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();

        $handle = fopen($filePath, 'r');
        
        // Skip header
        $header = fgetcsv($handle, 1000, ',');

        $imported = 0;
        $skipped = 0;

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Mapping: NIK, Nama, Email, Phone, Jabatan, Divisi, Tanggal Masuk, Status
            if (count($data) >= 7) {
                $nik = trim($data[0]);
                $nama = trim($data[1]);
                $email = trim($data[2]);
                $phone = trim($data[3] ?? '');
                $jabatan = trim($data[4]);
                $divisi = trim($data[5]);
                $tanggal_masuk = trim($data[6]);
                $status = trim($data[7] ?? 'Aktif');

                // Check duplicate NIK or email
                $existing = Employee::where('nik', $nik)->orWhere('email', $email)->first();
                if ($existing) {
                    $skipped++;
                    continue;
                }

                Employee::create([
                    'nik' => $nik,
                    'nama' => $nama,
                    'email' => $email,
                    'phone' => $phone,
                    'jabatan' => $jabatan,
                    'divisi' => $divisi,
                    'tanggal_masuk' => $tanggal_masuk,
                    'status' => $status,
                ]);
                $imported++;
            }
        }

        fclose($handle);

        ActivityLogger::log("Mengimpor {$imported} karyawan via CSV", 'Karyawan');

        return redirect()->route('hc.employees.index')
            ->with('success', "Impor berhasil! {$imported} karyawan ditambahkan, {$skipped} dilewati (karena NIK/Email ganda).");
    }
}
