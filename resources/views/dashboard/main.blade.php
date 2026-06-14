<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Utama – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f3f4f6; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 9px; }
        .stat-card { transition: box-shadow .18s, transform .18s; }
        .stat-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.09); transform: translateY(-2px); }
    </style>
</head>
<body class="flex min-h-screen">

{{-- ─── Sidebar ─────────────────────────────────────────── --}}
<x-sidebar :active="'dashboard'"/>

{{-- ─── Main ────────────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Dashboard Utama</span>
        <button class="relative p-2 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Content --}}
    <main class="flex-1 p-8 space-y-6">

        {{-- ── Welcome Row ──────────────────────────── --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 leading-tight">
                    Selamat Datang, {{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}
                </h1>
                <p class="text-sm text-gray-400 mt-0.5">Berikut adalah ringkasan kinerja perusahaan saat ini.</p>
            </div>
            <a href="#"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#006240] hover:bg-[#004d31] text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Buat Evaluasi Baru
            </a>
        </div>

        {{-- ── Stat Cards ───────────────────────────── --}}
        <div class="grid grid-cols-3 gap-5">

            {{-- Card 1: Total Karyawan --}}
            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#006240]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </div>
                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-green-700 bg-green-50 px-2 py-0.5 rounded-full">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                    </span>
                </div>
                <p class="text-xs text-gray-400 mb-1">Total Karyawan</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_karyawan']) }}</p>
            </div>

            {{-- Card 2: Evaluasi Aktif (highlighted) --}}
            <div class="stat-card bg-white rounded-2xl border-2 border-[#006240] p-5 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#006240]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mb-1">Evaluasi Aktif</p>
                <p class="text-3xl font-bold text-gray-900">
                    {{ $stats['evaluasi_aktif'] }}
                    <span class="text-sm font-normal text-gray-400 ml-1">Siklus Q3</span>
                </p>
                <div class="mt-3 h-1 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-[#006240] rounded-full" style="width:60%"></div>
                </div>
            </div>

            {{-- Card 3: KPI --}}
            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-semibold text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full">Bulan Ini</span>
                </div>
                <p class="text-xs text-gray-400 mb-1">Rata-rata KPI Perusahaan</p>
                <p class="text-3xl font-bold text-gray-900">
                    {{ $stats['rata_kpi'] }}
                    <span class="text-sm font-normal text-gray-400">/100</span>
                </p>
            </div>
        </div>

        {{-- ── Bottom Section ───────────────────────── --}}
        <div class="grid grid-cols-3 gap-5">

            {{-- Program Terkini (span 2) --}}
            <div class="col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                    <h2 class="text-sm font-semibold text-gray-800">Program Penilaian Terkini</h2>
                    <a href="#" class="text-xs font-medium text-[#006240] hover:underline">Lihat Semua</a>
                </div>

                <div class="divide-y divide-gray-50">
                    @foreach ($programs as $i => $program)
                    @php
                        $bgList   = ['bg-[#006240]','bg-blue-400','bg-rose-400'];
                        $stMap    = [
                            'Aktif'   => ['txt' => 'Berlangsung', 'cls' => 'text-green-600 bg-green-50'],
                            'Draft'   => ['txt' => 'Persiapan',   'cls' => 'text-amber-600 bg-amber-50'],
                            'Selesai' => ['txt' => 'Selesai',     'cls' => 'text-gray-500  bg-gray-50'],
                        ];
                        $st       = $stMap[$program->status] ?? ['txt' => $program->status, 'cls' => 'text-gray-500 bg-gray-50'];
                        $progress = $program->progress ?? ($program->status === 'Selesai' ? 100 : ($program->status === 'Aktif' ? 45 : 0));
                        $deadline = isset($program->tanggal_selesai)
                            ? (is_string($program->tanggal_selesai) && strlen($program->tanggal_selesai) < 12
                                ? $program->tanggal_selesai
                                : \Carbon\Carbon::parse($program->tanggal_selesai)->format('d M Y'))
                            : '-';
                    @endphp
                    <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-gray-50 transition-colors">
                        {{-- Colored icon --}}
                        <div class="w-9 h-9 rounded-xl {{ $bgList[$i % 3] }} flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $program->nama_program }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">Batas Akhir: {{ $deadline }}</p>
                        </div>
                        {{-- Status + Progress --}}
                        <div class="text-right flex-shrink-0">
                            <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full {{ $st['cls'] }}">
                                {{ $st['txt'] }}
                            </span>
                            <p class="text-xs text-gray-400 mt-1">Progress: {{ $progress }}%</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right Column --}}
            <div class="flex flex-col gap-4">

                {{-- Aksi Cepat --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h2 class="text-sm font-semibold text-gray-800 mb-3">Aksi Cepat</h2>
                    <div class="space-y-2">

                        <a href="/employees/create"
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl border border-gray-100 hover:border-green-200 hover:bg-green-50 transition-all group">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-green-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-[#006240]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700">Tambah Karyawan</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-[#006240] transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                            </svg>
                        </a>

                        <a href="#"
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition-all group">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700">Buat Form Baru</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                            </svg>
                        </a>

                    </div>
                </div>

                {{-- System Health --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <h2 class="text-sm font-semibold text-gray-800">System Health</h2>
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    </div>
                    <div class="space-y-3.5">
                        <div>
                            <div class="flex justify-between mb-1.5">
                                <span class="text-xs text-gray-400">Database Load</span>
                                <span class="text-xs font-semibold text-gray-700">24%</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-[#006240] rounded-full" style="width:24%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1.5">
                                <span class="text-xs text-gray-400">Storage Used</span>
                                <span class="text-xs font-semibold text-gray-700">68%</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-red-400 rounded-full" style="width:68%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /Right --}}
        </div>{{-- /Bottom --}}

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2025 PerformancePro Inc.</p>
        <div class="flex gap-4">
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Privacy</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Terms</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Support</a>
        </div>
    </footer>

</div>{{-- /Main --}}
</body>
</html>
