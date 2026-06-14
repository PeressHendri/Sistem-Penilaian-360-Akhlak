<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── 1. Spatie Roles & Permissions ─────────────────────────
        $roles = ['Administrator', 'Human Capital', 'Penilai', 'Management'];
        foreach ($roles as $roleName) {
            Role::findOrCreate($roleName);
        }

        $modules = ['dashboard', 'karyawan', 'formulir', 'hasil'];
        $actions = ['lihat', 'buat', 'ubah', 'hapus', 'validasi'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::findOrCreate("{$action} {$module}");
            }
        }

        // Assign all permissions to Administrator
        $adminRole = Role::findByName('Administrator');
        $adminRole->syncPermissions(Permission::all());

        // Assign permissions to Human Capital
        $hcRole = Role::findByName('Human Capital');
        $hcRole->syncPermissions(Permission::all());

        // Assign basic permissions to Penilai
        $penilaiRole = Role::findByName('Penilai');
        $penilaiRole->syncPermissions([
            'lihat dashboard',
            'lihat formulir',
            'lihat hasil'
        ]);

        // Assign read-only results permissions to Management
        $managementRole = Role::findByName('Management');
        $managementRole->syncPermissions([
            'lihat dashboard',
            'lihat hasil'
        ]);

        // ─── 2. Employees Seeding (Dependencies first) ──────────────
        $employeesData = [
            [
                'id' => 1,
                'nik' => 'EMP-101',
                'nama' => 'Vincensius Ivanca Christian',
                'email' => 'vincensius@akhlak.com',
                'jabatan' => 'IT Specialist',
                'divisi' => 'IT Dept',
                'tanggal_masuk' => '2023-01-15',
                'status' => 'Aktif',
                'atasan_id' => null
            ],
            [
                'id' => 2,
                'nik' => 'EMP-102',
                'nama' => 'Moh. Kent Daffa A.',
                'email' => 'kent@akhlak.com',
                'jabatan' => 'HR Officer',
                'divisi' => 'HR Dept',
                'tanggal_masuk' => '2021-05-20',
                'status' => 'Aktif',
                'atasan_id' => null
            ],
            [
                'id' => 3,
                'nik' => 'EMP-103',
                'nama' => 'Charly Jhosua Sianipar',
                'email' => 'charly@akhlak.com',
                'jabatan' => 'Senior Developer',
                'divisi' => 'Engineering',
                'tanggal_masuk' => '2019-08-10',
                'status' => 'Aktif',
                'atasan_id' => 1
            ],
            [
                'id' => 4,
                'nik' => 'EMP-104',
                'nama' => 'Adekanz Maulana',
                'email' => 'adekanz@akhlak.com',
                'jabatan' => 'Director',
                'divisi' => 'Management',
                'tanggal_masuk' => '2024-02-01',
                'status' => 'Aktif',
                'atasan_id' => null
            ]
        ];

        foreach ($employeesData as $emp) {
            DB::table('employees')->updateOrInsert(['id' => $emp['id']], $emp + ['created_at' => now(), 'updated_at' => now()]);
        }

        // ─── 3. User Accounts with exact employee mappings ─────────
        $usersData = [
            [
                'name' => 'Vincensius Ivanca Christian',
                'email' => 'vincensius@akhlak.com',
                'password' => Hash::make('password'),
                'employee_id' => 1,
                'status' => 'aktif',
                'role' => 'Administrator'
            ],
            [
                'name' => 'Moh. Kent Daffa A.',
                'email' => 'kent@akhlak.com',
                'password' => Hash::make('password'),
                'employee_id' => 2,
                'status' => 'aktif',
                'role' => 'Human Capital'
            ],
            [
                'name' => 'Charly Jhosua Sianipar',
                'email' => 'charly@akhlak.com',
                'password' => Hash::make('password'),
                'employee_id' => 3,
                'status' => 'aktif',
                'role' => 'Penilai'
            ],
            [
                'name' => 'Adekanz Maulana',
                'email' => 'adekanz@akhlak.com',
                'password' => Hash::make('password'),
                'employee_id' => 4,
                'status' => 'aktif',
                'role' => 'Management'
            ]
        ];

        foreach ($usersData as $usr) {
            $user = User::updateOrCreate(
                ['email' => $usr['email']],
                [
                    'name' => $usr['name'],
                    'password' => $usr['password'],
                    'employee_id' => $usr['employee_id'],
                    'status' => $usr['status'] ?? 'aktif',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
            $user->syncRoles([$usr['role']]);
        }

        // ─── 4. Assessment Programs ─────────────────────────────────
        $programsData = [
            [
                'id' => 1,
                'nama_program' => 'Evaluasi Budaya AKHLAK Triwulan',
                'deskripsi' => 'Program evaluasi berkala implementasi budaya AKHLAK.',
                'tanggal_mulai' => '2026-07-01',
                'tanggal_selesai' => '2026-10-15',
                'status' => 'Aktif',
                'created_by' => 1
            ]
        ];

        foreach ($programsData as $prog) {
            DB::table('assessment_programs')->updateOrInsert(['id' => $prog['id']], $prog + ['created_at' => now(), 'updated_at' => now()]);
        }

        // ─── 5. Core Values ─────────────────────────────────────────
        $coreValues = ['Amanah', 'Kompeten', 'Harmonis', 'Loyal', 'Adaptif', 'Kolaboratif'];
        foreach ($coreValues as $id => $valName) {
            DB::table('core_values')->updateOrInsert(
                ['id' => $id + 1],
                ['nama' => $valName, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // ─── 6. Indicators & Bobot ──────────────────────────────────
        $indicatorsData = [
            ['id' => 1, 'program_id' => 1, 'core_value_id' => 1, 'nama_indikator' => 'Amanah', 'deskripsi' => 'Memegang teguh kepercayaan diberikan oleh perusahaan.', 'bobot' => 20],
            ['id' => 2, 'program_id' => 1, 'core_value_id' => 2, 'nama_indikator' => 'Kompeten', 'deskripsi' => 'Terus belajar dan mengembangkan kapabilitas diri.', 'bobot' => 20],
            ['id' => 3, 'program_id' => 1, 'core_value_id' => 3, 'nama_indikator' => 'Harmonis', 'deskripsi' => 'Saling peduli dan menghargai perbedaan lingkungan.', 'bobot' => 15],
            ['id' => 4, 'program_id' => 1, 'core_value_id' => 4, 'nama_indikator' => 'Loyal', 'deskripsi' => 'Berdedikasi dan mengutamakan kepentingan institusi.', 'bobot' => 15],
            ['id' => 5, 'program_id' => 1, 'core_value_id' => 5, 'nama_indikator' => 'Adaptif', 'deskripsi' => 'Terus berinovasi dan antusias menghadapi perubahan.', 'bobot' => 15],
            ['id' => 6, 'program_id' => 1, 'core_value_id' => 6, 'nama_indikator' => 'Kolaboratif', 'deskripsi' => 'Membangun kerja sama yang sinergis dan produktif.', 'bobot' => 15]
        ];

        foreach ($indicatorsData as $ind) {
            DB::table('indicators')->updateOrInsert(['id' => $ind['id']], $ind + ['created_at' => now(), 'updated_at' => now()]);
        }

        // ─── 7. Reviewers (Ratee Rater mapping) ──────────────────────
        // Charly (id 3) rates Vincensius (id 1) and Adekanz (id 4)
        $reviewersData = [
            ['id' => 1, 'program_id' => 1, 'employee_id' => 1, 'reviewer_id' => 3, 'tipe_penilai' => 'Rekan', 'status' => 'Belum'],
            ['id' => 2, 'program_id' => 1, 'employee_id' => 4, 'reviewer_id' => 3, 'tipe_penilai' => 'Bawahan', 'status' => 'Belum'],
        ];

        foreach ($reviewersData as $rev) {
            DB::table('reviewers')->updateOrInsert(['id' => $rev['id']], $rev + ['created_at' => now(), 'updated_at' => now()]);
        }

        // ─── 8. Assessment Final Results ────────────────────────────
        $resultsData = [
            ['id' => 1, 'program_id' => 1, 'employee_id' => 1, 'nilai_akhir' => 88.0, 'kategori' => 'Star'],
            ['id' => 2, 'program_id' => 1, 'employee_id' => 2, 'nilai_akhir' => 76.5, 'kategori' => 'Core'],
            ['id' => 3, 'program_id' => 1, 'employee_id' => 4, 'nilai_akhir' => 91.2, 'kategori' => 'Star']
        ];

        foreach ($resultsData as $res) {
            DB::table('results')->updateOrInsert(['id' => $res['id']], $res + ['created_at' => now(), 'updated_at' => now()]);
        }
    }
}
