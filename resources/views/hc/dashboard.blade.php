<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard HC – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }
        .stat-card { transition: box-shadow .2s, transform .2s; }
        .stat-card:hover { box-shadow: 0 12px 30px rgba(0,0,0,.04); transform: translateY(-2px); }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

{{-- ─── Sidebar ────────────────────────────────────────── --}}
<x-sidebar :active="'dashboard'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Dashboard HC</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Main Container --}}
    <main class="flex-1 p-8 space-y-6">

        {{-- Welcome Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Selamat Datang, Human Capital</h1>
                <p class="text-sm text-slate-400 mt-0.5">Kelola karyawan, program penilaian, dan analisis talenta organisasi.</p>
            </div>
            
            <a href="/hc/programs"
               class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-[#006240] hover:bg-[#004d31] text-xs font-semibold text-white rounded-xl shadow-sm transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span>Buat Program Baru</span>
            </a>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-4 gap-5">
            {{-- Total Karyawan --}}
            <div class="stat-card bg-white border border-slate-100 p-5 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Karyawan</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center border border-emerald-100">
                        <svg class="w-4 h-4 text-[#006240]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900">{{ number_format($stats['total_karyawan']) }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Jumlah pegawai aktif</p>
            </div>

            {{-- Program Aktif --}}
            <div class="stat-card bg-white border border-slate-100 p-5 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Program Aktif</span>
                    <div class="w-8 h-8 rounded-lg bg-sky-50 flex items-center justify-center border border-sky-100">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900">{{ $stats['program_aktif'] }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Siklus penilaian berjalan</p>
            </div>

            {{-- Penilaian Berjalan --}}
            <div class="stat-card bg-white border border-slate-100 p-5 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Penilaian Berjalan</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center border border-amber-100">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V12h3.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900">{{ $stats['penilaian_berjalan'] }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Formulir sedang diisi</p>
            </div>

            {{-- Penilaian Selesai --}}
            <div class="stat-card bg-white border border-slate-100 p-5 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Penilaian Selesai</span>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center border border-indigo-100">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900">{{ $stats['penilaian_selesai'] }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Evaluasi terkirim &amp; rampung</p>
            </div>
        </div>

        {{-- Main Layout Split --}}
        <div class="grid grid-cols-3 gap-6">
            {{-- Program List (Span 2) --}}
            <div class="col-span-2 bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Program Penilaian Terbaru</h2>
                    <a href="/hc/programs" class="text-xs font-semibold text-[#006240] hover:underline">Kelola Program</a>
                </div>
                
                <div class="divide-y divide-slate-100">
                    @forelse($programs as $p)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50/30 transition-colors">
                        <div class="min-w-0">
                            <h3 class="text-xs font-bold text-slate-900 truncate">{{ $p->nama_program }}</h3>
                            <p class="text-[10px] text-slate-400 truncate mt-0.5">Periode: {{ $p->tanggal_mulai }} s/d {{ $p->tanggal_selesai }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span @class([
                                'px-2.5 py-0.5 rounded-full text-[9px] font-bold',
                                'bg-emerald-50 text-emerald-700 border border-emerald-100' => $p->status === 'Aktif',
                                'bg-slate-50 text-slate-600 border border-slate-100' => $p->status === 'Selesai',
                                'bg-amber-50 text-amber-600 border border-amber-100' => $p->status === 'Draft'
                            ])>
                                {{ $p->status }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="py-12 text-center text-slate-400 text-xs">
                        Belum ada program penilaian yang dibuat.
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Quick Links (Span 1) --}}
            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm space-y-4">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-50 pb-2">Aksi Cepat HC</h2>
                
                <div class="space-y-2.5 text-xs">
                    <a href="/hc/employees" class="flex items-center justify-between p-3 border border-slate-150 rounded-xl hover:bg-slate-50 transition-all font-semibold text-slate-700 group">
                        <span class="group-hover:text-[#006240]">Tambah Karyawan</span>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#006240]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                    </a>

                    <a href="/hc/organization-chart" class="flex items-center justify-between p-3 border border-slate-150 rounded-xl hover:bg-slate-50 transition-all font-semibold text-slate-700 group">
                        <span class="group-hover:text-[#006240]">Buka Bagan Organisasi</span>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#006240]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <a href="/hc/weights" class="flex items-center justify-between p-3 border border-slate-150 rounded-xl hover:bg-slate-50 transition-all font-semibold text-slate-700 group">
                        <span class="group-hover:text-[#006240]">Atur Bobot AKHLAK</span>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#006240]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0"/>
                        </svg>
                    </a>

                    <a href="/hc/talent-mapping" class="flex items-center justify-between p-3 border border-slate-150 rounded-xl hover:bg-slate-50 transition-all font-semibold text-slate-700 group">
                        <span class="group-hover:text-[#006240]">9 Box Talent Matrix</span>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#006240]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2026 PerformancePro Inc.</p>
        <div class="flex gap-4">
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Privacy</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Terms</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Support</a>
        </div>
    </footer>

</div>

</body>
</html>
