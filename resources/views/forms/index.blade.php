<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Formulir Penilaian – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }
        .hover-card { transition: box-shadow .2s, transform .2s; }
        .hover-card:hover { box-shadow: 0 10px 30px rgba(0,0,0,.04); transform: translateY(-2px); }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

{{-- ─── Sidebar ────────────────────────────────────────── --}}
<x-sidebar :active="'forms'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Formulir Penilaian</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Main Container --}}
    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs font-semibold text-[#006240]/80">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.625-12.184a22.95 22.95 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3 19.5h18M3 19.5c0-.828.672-1.5 1.5-1.5h15c.828 0 1.5.672 1.5 1.5m-18 0v-7.5A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v7.5"/>
            </svg>
            <span>Periode Q3 2024</span>
            <span class="text-slate-300 font-light">&bull;</span>
            <span class="text-slate-400">Divisi Teknologi</span>
        </div>

        {{-- Hero Header --}}
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Instruksi & Persiapan</h1>
            <p class="text-sm text-slate-400 max-w-2xl leading-relaxed">
                Harap baca panduan berikut sebelum memulai proses pengisian skor detail untuk memastikan penilaian yang objektif dan selaras dengan KPI perusahaan.
            </p>
        </div>

        {{-- Progress Row (Steps & Progress Card) --}}
        <div class="grid grid-cols-3 gap-6">

            {{-- 1. Steps Tracker --}}
            <div class="col-span-2 bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex items-center justify-between">
                
                {{-- Step 1 --}}
                <div class="flex flex-col items-center space-y-2 flex-1">
                    <div class="w-9 h-9 rounded-full bg-[#006240] text-white flex items-center justify-center font-bold text-sm shadow-sm ring-4 ring-green-100">
                        1
                    </div>
                    <span class="text-xs font-bold text-[#006240]">Persiapan</span>
                </div>

                {{-- Line 1-2 --}}
                <div class="h-1 bg-[#006240] flex-1 -mt-6 rounded"></div>

                {{-- Step 2 --}}
                <div class="flex flex-col items-center space-y-2 flex-1">
                    <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-semibold text-sm border border-slate-200">
                        2
                    </div>
                    <span class="text-xs font-medium text-slate-400">Input Skor</span>
                </div>

                {{-- Line 2-3 --}}
                <div class="h-1 bg-slate-100 flex-1 -mt-6 rounded"></div>

                {{-- Step 3 --}}
                <div class="flex flex-col items-center space-y-2 flex-1">
                    <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-semibold text-sm border border-slate-200">
                        3
                    </div>
                    <span class="text-xs font-medium text-slate-400">Review</span>
                </div>

                {{-- Line 3-4 --}}
                <div class="h-1 bg-slate-100 flex-1 -mt-6 rounded"></div>

                {{-- Step 4 --}}
                <div class="flex flex-col items-center space-y-2 flex-1">
                    <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-semibold text-sm border border-slate-200">
                        4
                    </div>
                    <span class="text-xs font-medium text-slate-400">Submit</span>
                </div>

            </div>

            {{-- 2. Total Progress Card --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 block mb-1">Total Progres</span>
                    <div class="flex items-baseline gap-1">
                        <span class="text-3xl font-extrabold text-slate-900 tracking-tight">25%</span>
                        <span class="text-xs font-semibold text-slate-500">Selesai</span>
                    </div>
                </div>

                <div class="space-y-1.5 mt-4">
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden w-full">
                        <div class="h-full bg-[#006240] rounded-full" style="width: 25%"></div>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-400 block text-right">Tahap 1 dari 4</span>
                </div>
            </div>

        </div>

        {{-- Objectivity Grid --}}
        <div class="grid grid-cols-3 gap-6">

            {{-- Card 1: Standar Objektivitas --}}
            <div class="hover-card bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5"/>
                    </svg>
                </div>
                <div class="space-y-1.5">
                    <h3 class="text-sm font-bold text-slate-800">Standar Objektivitas</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Penilaian harus didasarkan pada data pencapaian aktual (log aktivitas, laporan target), bukan opini subjektif atau impresi personal.
                    </p>
                </div>
            </div>

            {{-- Card 2: Distribusi Nilai --}}
            <div class="hover-card bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="space-y-1.5">
                    <h3 class="text-sm font-bold text-slate-800">Distribusi Nilai</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Gunakan skala 1-5 dengan bijak. Nilai 5 (Sangat Baik) hanya diberikan jika pencapaian secara konsisten melebihi ekspektasi utama (120%+).
                    </p>
                </div>
            </div>

            {{-- Card 3: Catatan Pendukung --}}
            <div class="hover-card bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                    </svg>
                </div>
                <div class="space-y-1.5">
                    <h3 class="text-sm font-bold text-slate-800">Catatan Pendukung</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Setiap skor ekstrim (1 atau 5) wajib disertai dengan catatan kualitatif yang menjelaskan insiden atau pencapaian spesifik yang mendasarinya.
                    </p>
                </div>
            </div>

        </div>

        {{-- Bottom CTA Alert Banner --}}
        <div class="bg-emerald-50/50 border border-emerald-600/20 rounded-2xl p-5 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-9 h-9 rounded-full bg-emerald-100 text-[#006240] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.086 1.086L10.5 13.5m0-4.5h.008v.008h-.008V9zm.008 9a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800">Siap Memulai Penilaian?</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Sistem akan secara otomatis menyimpan progres Anda setiap kali berpindah indikator.</p>
                </div>
            </div>

            <a href="/indicators" 
               class="inline-flex items-center gap-2 px-5 py-3 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition-all active:scale-95">
                <span>Lanjut ke Input Skor Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-slate-400">© 2026 PerformancePro Inc.</p>
        <div class="flex gap-4">
            <a href="#" class="text-xs text-slate-400 hover:text-[#006240]">Privacy</a>
            <a href="#" class="text-xs text-slate-400 hover:text-[#006240]">Terms</a>
            <a href="#" class="text-xs text-slate-400 hover:text-[#006240]">Support</a>
        </div>
    </footer>

</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
