@php
    $roleName = auth()->user()->roles->first()->name ?? 'Staff';
    $isAdmin = ($roleName === 'Administrator');
    
    $userEmployee = auth()->user()->employee;
    $userPhoto = ($userEmployee && $userEmployee->photo) ? asset('storage/' . $userEmployee->photo) : null;
    $initials = '';
    if (!$userPhoto) {
        $words = explode(' ', auth()->user()->name ?? 'Admin User');
        $initials = strtoupper(($words[0][0] ?? '') . (isset($words[1][0]) ? $words[1][0] : ''));
    }

    
    // Detect active prefix or determine by user's role
    if (request()->is('admin*')) {
        $prefix = 'admin';
    } elseif (request()->is('hc*')) {
        $prefix = 'hc';
    } elseif (request()->is('reviewer*')) {
        $prefix = 'reviewer';
    } elseif (request()->is('management*')) {
        $prefix = 'management';
    } else {
        // Fallback by Spatie Role
        if ($roleName === 'Administrator') {
            $prefix = 'admin';
        } elseif ($roleName === 'Human Capital') {
            $prefix = 'hc';
        } elseif ($roleName === 'Penilai') {
            $prefix = 'reviewer';
        } elseif ($roleName === 'Management') {
            $prefix = 'management';
        } else {
            $prefix = 'reviewer';
        }
    }
@endphp

<style>
    @media (max-width: 768px) {
        .ml-60 {
            margin-left: 0 !important;
        }
        header {
            padding-left: 3.5rem !important;
        }
        #sidebar-nav {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        #sidebar-nav.open {
            transform: translateX(0) !important;
        }
    }
</style>

<!-- Floating Hamburger Button for Mobile -->
<button onclick="document.getElementById('sidebar-nav').classList.toggle('open')" class="md:hidden fixed top-3.5 left-4 z-40 p-1.5 bg-[#006240] text-white rounded-lg shadow-sm hover:bg-[#004d32] transition-colors focus:outline-none">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
    </svg>
</button>

<aside id="sidebar-nav" class="w-60 min-h-screen bg-white border-r border-gray-100 flex flex-col fixed top-0 left-0 z-30 shadow-sm transition-transform duration-300">

    {{-- ── Brand ────────────────────────────────────── --}}
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
        <div class="flex items-center gap-2.5 select-none">
            <div class="w-7 h-7 rounded-md bg-[#006847] flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>
            <span class="brand-font text-sm font-bold text-[#006847] truncate">PerformancePro</span>
        </div>
        <!-- Mobile Close Button -->
        <button onclick="document.getElementById('sidebar-nav').classList.remove('open')" class="md:hidden p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>


    {{-- ── User Profile ─────────────────────────────── --}}
    <div class="flex items-center gap-3 px-4 py-3.5 border-b border-gray-100">
        @if ($userPhoto)
            <img src="{{ $userPhoto }}" 
                 alt="{{ auth()->user()->name ?? 'Admin User' }}" 
                 class="w-10 h-10 rounded-full object-cover border border-gray-100 select-none flex-shrink-0"/>
        @else
            <div class="w-10 h-10 rounded-full bg-[#006847] text-white flex items-center justify-center font-bold text-xs select-none flex-shrink-0">
                {{ $initials }}
            </div>
        @endif
        <div class="min-w-0">
            <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name ?? 'Admin User' }}</p>
            <p class="text-[10px] text-gray-400 font-semibold leading-tight">HR Department</p>
            @if ($isAdmin)
                <span class="text-[8px] font-bold text-red-500 uppercase tracking-wider block mt-0.5">PREMIUM ACCESS</span>
            @else
                <span class="inline-block mt-0.5 px-1.5 py-px bg-green-100 text-[#006240] text-[9px] font-semibold rounded-full">
                    Active Role
                </span>
            @endif
        </div>
    </div>


    {{-- ── Navigation ───────────────────────────────── --}}
    <nav class="flex-1 px-3 py-3 space-y-0.5 overflow-y-auto">

        {{-- ── ROLE 1: ADMINISTRATOR ── --}}
        @if ($isAdmin)
            {{-- Dashboard Utama --}}
            <a href="/admin/dashboard" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'dashboard',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'dashboard',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-13.5 18v-2.25z"/>
                </svg>
                Dashboard Utama
            </a>

            {{-- Kelola Karyawan --}}
            <a href="/hc/employees" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'employees',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'employees',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
                Kelola Karyawan
            </a>

            {{-- Formulir Penilaian --}}
            <a href="/reviewer/assessments" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'assessments',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'assessments',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
                Formulir Penilaian
            </a>

            {{-- Indikator & Bobot --}}
            <a href="/hc/indicators" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'indicators',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'indicators',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
                Indikator &amp; Bobot
            </a>

            {{-- Daftar Penilai --}}
            <a href="/hc/reviewers" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'reviewers',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'reviewers',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
                Daftar Penilai
            </a>

            {{-- Dashboard Analisis --}}
            <a href="/management/analytics" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'analytics',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'analytics',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"/>
                </svg>
                Dashboard Analisis
            </a>

            {{-- Skor Detail --}}
            <a href="/scores" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'scores',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'scores',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                </svg>
                Skor Detail
            </a>

            {{-- Submit Penilaian --}}
            <a href="/submit" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'submit',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'submit',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Submit Penilaian
            </a>

            {{-- Hasil Penilaian --}}
            <a href="/hc/results" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'results',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'results',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Hasil Penilaian
            </a>

            <hr class="border-gray-100 my-2" />

            {{-- Kelola Akun --}}
            <a href="/admin/users" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'users',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'users',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
                Kelola Akun
            </a>

            {{-- Hak Akses --}}
            <a href="/admin/permissions" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'permissions',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'permissions',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                </svg>
                Hak Akses
            </a>

            {{-- Activity Log --}}
            <a href="/admin/logs" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-[#5da086] text-white font-semibold' => $active === 'logs',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'logs',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V12h3.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Activity Log
            </a>



        {{-- ── ROLE 2: HUMAN CAPITAL ── --}}
        @elseif ($prefix === 'hc')
            {{-- Dashboard HC --}}
            <a href="/hc/dashboard" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'dashboard',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'dashboard',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-13.5 18v-2.25z"/>
                </svg>
                Dashboard HC
            </a>

            {{-- Kelola Karyawan --}}
            <a href="/hc/employees" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'employees',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'employees',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
                Kelola Karyawan
            </a>

            {{-- Struktur Organisasi --}}
            <a href="/hc/organization-chart" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'org_chart',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'org_chart',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
                Struktur Organisasi
            </a>

            {{-- Program Penilaian --}}
            <a href="/hc/programs" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'programs',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'programs',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>
                </svg>
                Program Penilaian
            </a>

            {{-- Indikator AKHLAK --}}
            <a href="/hc/indicators" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'indicators',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'indicators',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
                Indikator AKHLAK
            </a>

            {{-- Bobot Penilaian --}}
            <a href="/hc/weights" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'weights',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'weights',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
                </svg>
                Bobot Penilaian
            </a>

            {{-- Daftar Penilai --}}
            <a href="/hc/reviewers" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'reviewers',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'reviewers',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
                Daftar Penilai
            </a>

            {{-- Hasil Penilaian --}}
            <a href="/hc/results" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'results',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'results',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Hasil Penilaian
            </a>

            {{-- Talent Mapping --}}
            <a href="/hc/talent-mapping" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'talent_mapping',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'talent_mapping',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25z"/>
                </svg>
                Talent Mapping
            </a>

            {{-- IDP --}}
            <a href="/hc/idp" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'idp',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'idp',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5-3h.008v.008H6V7.5zm0 3h.008v.008H6v-.008zm0 3h.008v.008H6v-.008zm0 3h.008v.008H6v-.008zm3-6h1.5M9 13.5h1.5m-1.5 3h1.5m3.75-3H18m-3.75 3H18M12 21a9.003 9.003 0 008.361-5.639L12 9.375V21zM2.25 12a9.75 9.75 0 0117.5-6H2.25v6z"/>
                </svg>
                IDP
            </a>

        {{-- ── ROLE 3: PENILAI / REVIEWER ── --}}
        @elseif ($prefix === 'reviewer')
            {{-- Dashboard Penilai --}}
            <a href="/reviewer/dashboard" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'dashboard',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'dashboard',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-13.5 18v-2.25z"/>
                </svg>
                Dashboard
            </a>

            {{-- Daftar Penilaian --}}
            <a href="/reviewer/assessments" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'assessments',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'assessments',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
                Daftar Penilaian
            </a>

        {{-- ── ROLE 4: MANAGEMENT ── --}}
        @elseif ($prefix === 'management')
            {{-- Dashboard Management --}}
            <a href="/management/dashboard" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'dashboard',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'dashboard',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-13.5 18v-2.25z"/>
                </svg>
                Dashboard
            </a>

            {{-- Dashboard Analitik --}}
            <a href="/management/analytics" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'analytics',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'analytics',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"/>
                </svg>
                Dashboard Analitik
            </a>

            {{-- Ranking --}}
            <a href="/management/ranking" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'ranking',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'ranking',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                </svg>
                Ranking
            </a>

            {{-- Talent Mapping --}}
            <a href="/management/talent-mapping" @class([
                'group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all',
                'bg-green-50 text-[#006240] font-semibold' => $active === 'talent_mapping',
                'text-gray-500 hover:bg-gray-50 hover:text-gray-800' => $active !== 'talent_mapping',
            ])>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25z"/>
                </svg>
                Talent Mapping
            </a>
        @endif



    </nav>

    {{-- ── Logout ───────────────────────────────────── --}}
    <div class="px-3 py-3 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-2.5 w-full px-3 py-2 rounded-lg text-xs font-medium text-red-500 hover:bg-red-50 transition-all">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                </svg>
                Logout
            </button>
        </form>
    </div>

</aside>

@php
    $latestLogs = \Illuminate\Support\Facades\DB::table('activity_logs')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get()
        ->map(function($log) {
            return [
                'activity' => $log->activity,
                'module' => $log->module ?? 'Sistem',
                'time' => \Carbon\Carbon::parse($log->created_at)->diffForHumans(),
            ];
        });
@endphp

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bellBtn = document.querySelector('header button.relative') || document.querySelector('button.relative:has(svg)');
        if (!bellBtn) return;

        // Create notification dropdown element
        const dropdown = document.createElement('div');
        dropdown.className = 'absolute right-0 top-12 w-80 bg-white border border-slate-200/80 rounded-xl shadow-lg z-50 py-2 hidden text-left text-xs text-slate-700';
        dropdown.id = 'notification-dropdown';

        // Fetch logs from Blade
        const logs = @json($latestLogs);

        let logsHtml = '';
        if (logs.length === 0) {
            logsHtml = `
                <div class="px-4 py-6 text-center text-slate-400 select-none">
                    <p class="font-semibold">Tidak ada notifikasi baru</p>
                </div>
            `;
        } else {
            logs.forEach(log => {
                logsHtml += `
                    <div class="px-4 py-2.5 hover:bg-slate-50 transition-colors border-b border-slate-100/60 last:border-b-0 flex gap-2.5 items-start">
                        <span class="w-2 h-2 rounded-full bg-[#006847] mt-1.5 flex-shrink-0"></span>
                        <div class="space-y-0.5 flex-1 min-w-0">
                            <p class="font-semibold text-slate-800 break-words">${log.activity}</p>
                            <div class="flex items-center gap-1.5 text-[10px] text-slate-400 font-medium">
                                <span>${log.module}</span>
                                <span>&bull;</span>
                                <span>${log.time}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        dropdown.innerHTML = `
            <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between font-bold select-none">
                <span class="text-slate-800">Notifikasi</span>
                <span class="text-[10px] text-[#006847] cursor-pointer hover:underline" id="mark-all-read">Tandai dibaca</span>
            </div>
            <div class="max-h-64 overflow-y-auto">
                ${logsHtml}
            </div>
            <div class="px-4 py-2 border-t border-slate-100 text-center select-none">
                <a href="/admin/logs" class="text-[10px] font-bold text-[#006847] hover:underline block">Lihat Semua Aktivitas</a>
            </div>
        `;

        // Append dropdown to the parent container of the bell button
        const parent = bellBtn.parentElement;
        if (parent) {
            parent.style.position = 'relative';
            parent.appendChild(dropdown);
        }

        // Click handler to toggle dropdown
        bellBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        // Click handler for mark all read
        const markRead = dropdown.querySelector('#mark-all-read');
        if (markRead) {
            markRead.addEventListener('click', (e) => {
                e.stopPropagation();
                // Remove red dot badge
                const redDot = bellBtn.querySelector('span.bg-red-500, span.bg-\\[\\#d93838\\]');
                if (redDot) {
                    redDot.remove();
                }
                dropdown.classList.add('hidden');
            });
        }

        // Close on click outside
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && e.target !== bellBtn && !bellBtn.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>

