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
        body { background: #f8fafc; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

<x-sidebar :active="'dashboard'"/>

<div class="ml-0 md:ml-60 flex-1 flex flex-col min-h-screen">
    <!-- Top Header Bar -->
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-bold text-[#006240]">Dashboard Utama</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6">
        <!-- Welcoming and Action Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Selamat Datang, Admin</h1>
                <p class="text-sm text-slate-400 mt-0.5">Berikut adalah ringkasan kinerja perusahaan saat ini.</p>
            </div>
            <a href="/hc/programs" class="inline-flex items-center px-4 py-2 bg-[#006240] hover:bg-[#004d32] text-white font-bold rounded-xl transition-all shadow-sm text-xs space-x-1.5 h-fit">
                <span>+</span>
                <span>Buat Evaluasi Baru</span>
            </a>
        </div>

        <!-- Metric Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Karyawan Card -->
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between min-h-[140px]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Karyawan</span>
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">↑ +5%</span>
                </div>
                <div class="mt-4">
                    <p class="text-4xl font-extrabold text-slate-900 leading-none">
                        {{ number_format($totalKaryawan) }}
                    </p>
                </div>
                <!-- Small decorative icon -->
                <div class="flex items-center text-slate-300 mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07"/>
                    </svg>
                </div>
            </div>

            <!-- Evaluasi Aktif Card -->
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between min-h-[140px]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Evaluasi Aktif</span>
                    <span class="text-[10px] font-bold text-slate-500 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-full">Siklus Q3</span>
                </div>
                <div class="mt-2">
                    <p class="text-4xl font-extrabold text-slate-900 leading-none">
                        {{ $activeProgramsCount }}
                    </p>
                </div>
                <!-- Progress bar -->
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden mt-3">
                    <div class="bg-[#006240] h-full rounded-full" style="width: 60%"></div>
                </div>
            </div>

            <!-- Rata-rata KPI Perusahaan Card -->
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between min-h-[140px]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rata-rata KPI Perusahaan</span>
                    <span class="text-[10px] font-bold text-slate-500 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-full">Bulan Ini</span>
                </div>
                <div class="mt-4 flex items-baseline">
                    <p class="text-4xl font-extrabold text-slate-900 leading-none">
                        {{ number_format($avgScore, 1) }}
                    </p>
                    <span class="text-xs font-bold text-slate-400 ml-1">/100</span>
                </div>
                <!-- Small decorative graph icon -->
                <div class="flex items-center text-slate-300 mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Details Grid Area -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column: Program Penilaian Terkini -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 space-y-4 md:col-span-2">
                <div class="flex items-center justify-between border-b border-slate-50 pb-3">
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Program Penilaian Terkini</h2>
                    <a href="/hc/programs" class="text-xs font-bold text-[#006240] hover:text-[#004d32] transition-colors">Lihat Semua</a>
                </div>
                <div class="divide-y divide-slate-50 space-y-4">
                    @forelse($recentPrograms as $row)
                    <div class="flex items-center justify-between pt-4 space-x-4">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            <!-- Program Icon -->
                            <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100 flex-shrink-0">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $row->nama_program }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">Batas Akhir: {{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-1.5">
                            <span class="inline-block px-2 py-0.5 rounded-full font-bold text-[9px] border {{ $row->status_color }}">
                                {{ $row->status_label }}
                            </span>
                            <div class="flex items-center space-x-2 w-24">
                                <div class="flex-1 bg-slate-100 h-1 rounded-full overflow-hidden">
                                    <div class="bg-[#006240] h-full rounded-full" style="width: {{ $row->progress }}%"></div>
                                </div>
                                <span class="text-[9px] font-bold text-slate-400">Progress: {{ $row->progress }}%</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic py-4">Belum ada program penilaian yang dibuat.</p>
                    @endforelse
                </div>
            </div>

            <!-- Right Column: Quick Actions & System Health -->
            <div class="space-y-6 md:col-span-1">
                <!-- Aksi Cepat Card -->
                <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-4">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Aksi Cepat</h2>
                    <div class="space-y-2.5">
                        <a href="/hc/employees" class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:bg-slate-50 transition-colors text-xs font-semibold text-slate-700">
                            <div class="flex items-center space-x-2">
                                <span class="text-lg">+</span>
                                <span>Tambah Karyawan</span>
                            </div>
                            <span class="text-slate-300">→</span>
                        </a>
                        <a href="/hc/programs" class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:bg-slate-50 transition-colors text-xs font-semibold text-slate-700">
                            <div class="flex items-center space-x-2">
                                <span class="text-lg">+</span>
                                <span>Buat Form Baru</span>
                            </div>
                            <span class="text-slate-300">→</span>
                        </a>
                    </div>
                </div>

                <!-- System Health Card -->
                <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">System Health</h2>
                        <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span>
                    </div>
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-semibold">
                                <span class="text-slate-500">Database Load</span>
                                <span class="text-slate-800 font-bold">24%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-[#006240] h-full rounded-full" style="width: 24%"></div>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-semibold">
                                <span class="text-slate-500">Storage Used</span>
                                <span class="text-slate-800 font-bold">68%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-rose-500 h-full rounded-full" style="width: 68%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 px-8 py-4 flex items-center justify-between mt-auto">
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
