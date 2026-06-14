<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Employee;
use App\Helpers\ActivityLogger;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Load users from DB and join employee department info
        $usersList = User::leftJoin('employees', 'users.employee_id', '=', 'employees.id')
            ->select('users.*', 'employees.divisi as department', 'employees.photo as photo')
            ->get()
            ->map(function ($usr) {
                // Get Spatie role
                $roleName = $usr->roles->first() ? $usr->roles->first()->name : 'Penilai';

                // Generate initials
                $words = explode(' ', $usr->name);
                $initials = strtoupper(($words[0][0] ?? '') . (isset($words[1][0]) ? $words[1][0] : ''));

                $roleClass = 'bg-slate-50 text-slate-700 border border-slate-100';
                $color = 'bg-slate-100 text-slate-700';

                if ($roleName === 'Administrator') {
                    $roleClass = 'bg-emerald-50 text-emerald-700 border border-emerald-100';
                    $color = 'bg-emerald-600 text-white';
                } elseif ($roleName === 'Human Capital') {
                    $roleClass = 'bg-blue-50 text-blue-700 border border-blue-100';
                    $color = 'bg-blue-600 text-white';
                } elseif ($roleName === 'Penilai') {
                    $roleClass = 'bg-amber-50 text-amber-700 border border-amber-100';
                    $color = 'bg-amber-600 text-white';
                } elseif ($roleName === 'Management') {
                    $roleClass = 'bg-purple-50 text-purple-700 border border-purple-100';
                    $color = 'bg-purple-600 text-white';
                }

                return [
                    'id' => $usr->id,
                    'name' => $usr->name,
                    'email' => $usr->email,
                    'department' => $usr->department ?? 'Engineering Dept',
                    'role' => $roleName,
                    'initials' => $initials,
                    'color' => $color,
                    'role_class' => $roleClass,
                    'photo' => $usr->photo ? asset('storage/' . $usr->photo) : null,
                ];
            })
            ->toArray();
        
        return view('admin.users', compact('user', 'usersList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'department' => 'required|string|max:255',
            'role' => 'required|string',
        ]);

        // Find or create employee for department mapping
        $employee = Employee::where('email', $request->input('email'))->first();
        if (!$employee) {
            $nik = '2026' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $employeeId = DB::table('employees')->insertGetId([
                'nik' => $nik,
                'nama' => $request->input('name'),
                'email' => $request->input('email'),
                'jabatan' => $request->input('role') === 'Penilai' ? 'Staff' : ($request->input('role') === 'Management' ? 'Manager' : 'HC Specialist'),
                'divisi' => $request->input('department'),
                'tanggal_masuk' => now()->toDateString(),
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $employeeId = $employee->id;
        }

        $newUser = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make('password'),
            'employee_id' => $employeeId,
            'status' => 'aktif'
        ]);

        $newUser->syncRoles([$request->input('role')]);

        ActivityLogger::log('Membuat user baru: ' . $request->input('name') . ' (' . $request->input('email') . ')', 'User Management');

        return redirect()->route('admin.users.index')->with('success', 'Akun baru ' . $request->input('name') . ' berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . '|max:255',
            'department' => 'required|string|max:255',
            'role' => 'required|string',
        ]);

        $userObj = User::findOrFail($id);
        $userObj->name = $request->input('name');
        $userObj->email = $request->input('email');
        $userObj->save();

        if ($userObj->employee_id) {
            DB::table('employees')->where('id', $userObj->employee_id)->update([
                'nama' => $request->input('name'),
                'email' => $request->input('email'),
                'divisi' => $request->input('department'),
                'updated_at' => now(),
            ]);
        }

        $userObj->syncRoles([$request->input('role')]);

        ActivityLogger::log('Memperbarui user: ' . $request->input('name') . ' (' . $request->input('email') . ')', 'User Management');

        return redirect()->route('admin.users.index')->with('success', 'Akun ' . $request->input('name') . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $userObj = User::findOrFail($id);
        $deletedName = $userObj->name;
        $userObj->delete();

        ActivityLogger::log('Menghapus user: ' . $deletedName, 'User Management');

        return redirect()->route('admin.users.index')->with('success', 'Akun ' . $deletedName . ' berhasil dihapus!');
    }
}
