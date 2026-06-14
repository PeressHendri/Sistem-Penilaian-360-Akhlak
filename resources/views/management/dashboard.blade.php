<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Management – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

<x-sidebar :active="'dashboard'"/>

<div class="ml-60 flex-1 flex flex-col min-h-screen">
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Dashboard Direksi &amp; Management</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6">
        <!-- Summary Cards -->
        <div class="grid grid-cols-4 gap-6">
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Karyawan</span>
                <p class="text-3xl font-extrabold text-slate-800">{{ $totalKaryawan }}</p>
            </div>
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rata-rata Nilai AKHLAK</span>
                <p class="text-3xl font-extrabold text-[#006240]">{{ $avgScoreFormatted }}</p>
            </div>
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Penyelesaian Rater</span>
                <p class="text-3xl font-extrabold text-amber-500">{{ $completionRate }}%</p>
            </div>
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Program Aktif</span>
                <p class="text-3xl font-extrabold text-indigo-500">1</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Top Performers -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Top 5 Performa Karyawan</h2>
                    <a href="{{ route('management.ranking') }}" class="text-[10px] font-bold text-[#006240]">Lihat Semua</a>
                </div>
                <div class="divide-y divide-slate-50 space-y-3">
                    @forelse($topPerformers as $index => $row)
                    <div class="flex items-center justify-between pt-3">
                        <div class="flex items-center space-x-3">
                            <span class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-800 text-[10px] font-extrabold flex items-center justify-center">#{{ $index+1 }}</span>
                            <div>
                                <p class="text-xs font-bold text-slate-900">{{ $row->nama }}</p>
                                <p class="text-[10px] text-slate-400">{{ $row->jabatan }} • {{ $row->divisi }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-black text-[#006240]">{{ number_format($row->nilai_akhir, 1) }}</span>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic py-4">Belum ada data nilai akhir.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Submissions -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Aktivitas Penilaian Terkini</h2>
                </div>
                <div class="divide-y divide-slate-50 space-y-3">
                    @forelse($recentAssessments as $row)
                    <div class="flex items-center justify-between pt-3">
                        <div class="space-y-0.5">
                            <p class="text-xs text-slate-800">
                                <span class="font-bold text-slate-900">{{ $row->rater_nama }}</span> menilai <span class="font-bold text-slate-900">{{ $row->ratee_nama }}</span>
                            </p>
                            <p class="text-[9px] text-slate-400">{{ \Carbon\Carbon::parse($row->submitted_at)->diffForHumans() }}</p>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Submitted</span>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic py-4">Belum ada aktivitas penilaian.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2026 PerformancePro Inc.</p>
    </footer>
</div>
</body>
</html>
