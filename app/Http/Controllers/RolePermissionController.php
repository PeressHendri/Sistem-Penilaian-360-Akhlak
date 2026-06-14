<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Helpers\ActivityLogger;

class RolePermissionController extends Controller
{
    private $modules = ['dashboard', 'karyawan', 'formulir', 'hasil'];
    private $actions = ['lihat', 'buat', 'ubah', 'hapus', 'validasi'];

    public function index()
    {
        $user = Auth::user();
        
        // Fetch all roles from DB
        $roles = Role::all();

        // Ensure all permissions exist in database
        foreach ($this->modules as $module) {
            foreach ($this->actions as $action) {
                Permission::findOrCreate("{$action} {$module}");
            }
        }

        // Build matrix
        $matrix = [];
        foreach ($roles as $role) {
            foreach ($this->modules as $module) {
                foreach ($this->actions as $action) {
                    $permissionName = "{$action} {$module}";
                    $matrix[$role->name][$module][$action] = $role->hasPermissionTo($permissionName);
                }
            }
        }
        
        $totalRoles = count($matrix);
        $totalModules = 12; // Matching the stat cards on the dashboard

        return view('admin.roles', compact('user', 'matrix', 'totalRoles', 'totalModules'));
    }

    public function store(Request $request)
    {
        // Add new role
        if ($request->has('new_role_name')) {
            $newRole = trim($request->input('new_role_name'));
            if ($newRole) {
                if (!Role::where('name', $newRole)->exists()) {
                    Role::create(['name' => $newRole]);
                    ActivityLogger::log('Membuat role baru: ' . $newRole, 'Hak Akses');
                    return redirect()->route('admin.roles.index')->with('success', 'Peran baru "' . $newRole . '" berhasil ditambahkan!');
                }
                return redirect()->route('admin.roles.index')->withErrors(['new_role_name' => 'Peran ini sudah ada.']);
            }
        }

        // Save matrix changes
        $inputMatrix = $request->input('matrix', []);
        $roles = Role::all();

        foreach ($roles as $role) {
            $permissionsToSync = [];
            foreach ($this->modules as $module) {
                foreach ($this->actions as $action) {
                    $permissionName = "{$action} {$module}";
                    if (isset($inputMatrix[$role->name][$module][$action])) {
                        $permissionsToSync[] = $permissionName;
                    }
                }
            }
            $role->syncPermissions($permissionsToSync);
        }

        ActivityLogger::log('Memperbarui matriks hak akses', 'Hak Akses');

        return redirect()->route('admin.roles.index')->with('success', 'Konfigurasi hak akses berhasil disimpan!');
    }
}
