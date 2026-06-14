<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Hasil Penilaian – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        h1, h2, h3, h4, .brand-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9px;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex min-h-screen text-slate-800">

{{-- Sidebar --}}
<x-sidebar :active="'results'"/>

{{-- Main Content --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen">
    
    {{-- Header --}}
    <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="brand-font text-lg font-bold text-[#006847] tracking-tight">PerformancePro</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-[#d93838] rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Main Container --}}
    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-8">
        
        {{-- Page Header --}}
        <div class="flex items-start justify-between">
            <div class="space-y-1">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Hasil Penilaian</h1>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Final evaluation overview for Q3 2023.</p>
            </div>
            
            <button onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#006847] hover:bg-[#005036] text-xs font-semibold text-white rounded-lg shadow-xs transition-all active:scale-98 select-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                <span>Export PDF</span>
            </button>
        </div>

        {{-- 2x2 Dashboard Mockup Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Card 1: Overall Score --}}
            <div class="bg-white rounded-xl border border-slate-200/80 p-6 shadow-xs flex flex-col justify-between min-h-[200px]">
                <div class="flex justify-between items-start select-none">
                    <h3 class="text-sm font-bold text-slate-800">Overall Score</h3>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#006847] flex items-center justify-center border border-emerald-100">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.75a1.125 1.125 0 01-1.125-1.125V3.75c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125v7.875c0 .621-.504 1.125-1.125 1.125h-.75c-.621 0-1.125.504-1.125 1.125v3.375z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="my-4">
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold text-slate-800 tracking-tight">88.4</span>
                        <span class="text-xs font-bold text-slate-400">/ 100</span>
                    </div>
                </div>
                
                <div class="border-t border-slate-100 pt-3 flex items-center justify-between select-none">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Performance status</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#006847] hover:bg-[#005036] text-white text-[10px] font-bold rounded-full transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.518l2.74-1.22m0 0l-5.94-2.281m5.94 2.28l-2.28 5.941"/>
                        </svg>
                        <span>Exceeds Expectations</span>
                    </span>
                </div>
            </div>

            {{-- Card 2: Growth Trend --}}
            <div class="bg-white rounded-xl border border-slate-200/80 p-6 shadow-xs flex flex-col justify-between min-h-[200px]">
                <div class="flex justify-between items-start select-none">
                    <h3 class="text-sm font-bold text-slate-800">Growth Trend</h3>
                    <div class="flex border border-slate-200 rounded-lg overflow-hidden text-[9px] font-bold">
                        <button class="px-2.5 py-1 bg-slate-50 text-slate-400 hover:text-slate-600 border-r border-slate-200">YTD</button>
                        <button class="px-2.5 py-1 bg-[#006847] text-white">Q3</button>
                    </div>
                </div>
                
                <div class="w-full mt-4">
                    {{-- SVG Curve chart --}}
                    <svg viewBox="0 0 450 140" class="w-full h-32 overflow-visible">
                        <!-- Gradient definition -->
                        <defs>
                            <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#006847" stop-opacity="0.15" />
                                <stop offset="100%" stop-color="#006847" stop-opacity="0.0" />
                            </linearGradient>
                        </defs>

                        <!-- Area under the curve -->
                        <path d="M 30 110 C 130 100, 180 70, 280 50 C 330 40, 370 20, 420 15 L 420 120 L 30 120 Z" fill="url(#chartGradient)" />

                        <!-- Curve Line -->
                        <path d="M 30 110 C 130 100, 180 70, 280 50 C 330 40, 370 20, 420 15" fill="none" stroke="#006847" stroke-width="3" stroke-linecap="round" />

                        <!-- Dots & Ticks -->
                        <!-- Q1 -->
                        <circle cx="30" cy="110" r="4.5" fill="#ffffff" stroke="#006847" stroke-width="2" />
                        <text x="30" y="132" text-anchor="middle" class="text-[9px] fill-slate-400 font-semibold select-none">Q1</text>
                        
                        <!-- Q2 -->
                        <circle cx="160" cy="88" r="4.5" fill="#ffffff" stroke="#006847" stroke-width="2" />
                        <text x="160" y="132" text-anchor="middle" class="text-[9px] fill-slate-400 font-semibold select-none">Q2</text>
                        
                        <!-- Mid -->
                        <circle cx="295" cy="48" r="4.5" fill="#ffffff" stroke="#006847" stroke-width="2" />
                        <text x="295" y="132" text-anchor="middle" class="text-[9px] fill-slate-400 font-semibold select-none">Mid</text>
                        
                        <!-- Q3 -->
                        <circle cx="420" cy="15" r="5" fill="#006847" stroke="#ffffff" stroke-width="2" />
                        <circle cx="420" cy="15" r="10" fill="none" stroke="#006847" stroke-width="1.5" stroke-opacity="0.3" />
                        <text x="420" y="132" text-anchor="middle" class="text-[9px] fill-slate-800 font-bold select-none">Q3</text>
                    </svg>
                </div>
            </div>

            {{-- Card 3: Score Distribution --}}
            <div class="bg-white rounded-xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-800 select-none">Score Distribution</h3>
                
                <div class="space-y-4.5 select-none">
                    {{-- Core Competencies --}}
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700">
                            <span>Core Competencies</span>
                            <span class="text-[#006847]">92%</span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-100 rounded-full mt-1.5 overflow-hidden">
                            <div class="h-full bg-[#006847]" style="width: 92%"></div>
                        </div>
                    </div>

                    {{-- Leadership --}}
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700">
                            <span>Leadership</span>
                            <span class="text-[#006847]">85%</span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-100 rounded-full mt-1.5 overflow-hidden">
                            <div class="h-full bg-[#006847]" style="width: 85%"></div>
                        </div>
                    </div>

                    {{-- Project Delivery --}}
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700">
                            <span>Project Delivery</span>
                            <span class="text-[#006847]">78%</span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-100 rounded-full mt-1.5 overflow-hidden">
                            <div class="h-full bg-[#006847]" style="width: 78%"></div>
                        </div>
                    </div>

                    {{-- Culture Contribution --}}
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700">
                            <span>Culture Contribution</span>
                            <span class="text-[#006847]">95%</span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-100 rounded-full mt-1.5 overflow-hidden">
                            <div class="h-full bg-[#006847]" style="width: 95%"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 4: Competency Breakdown --}}
            <div class="bg-white rounded-xl border border-slate-200/80 p-6 shadow-xs flex flex-col justify-between">
                <div class="flex justify-between items-start select-none pb-2">
                    <h3 class="text-sm font-bold text-slate-800">Competency Breakdown</h3>
                    <button class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
                        </svg>
                    </button>
                </div>
                
                <div class="overflow-x-auto flex-1 mt-2">
                    <table class="w-full text-left text-xs border-collapse select-none">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200/60 text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                <th class="py-2.5 px-3">Metric Area</th>
                                <th class="py-2.5 px-3 text-center">Target</th>
                                <th class="py-2.5 px-3 text-center">Achieved</th>
                                <th class="py-2.5 px-3 text-center">Variance</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            {{-- Row 1 --}}
                            <tr>
                                <td class="py-3 px-3 flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-md bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21V9.75M20.716 14.253a8.99 8.99 0 01-3.66 4.93m3.66-4.93a8.99 8.99 0 00-1.84-5.32m-13.876 10.25a8.99 8.99 0 003.66 4.93m-3.66-4.93a8.99 8.99 0 011.84-5.32M17.056 9.324a8.99 8.99 0 00-5.056-5.574m0 0a8.99 8.99 0 00-5.056 5.574M12 3.75v6M12 9.75h.008v.008H12V9.75z"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold truncate">Strategic Thinking</span>
                                </td>
                                <td class="py-3 px-3 text-center font-bold text-slate-500">4.0</td>
                                <td class="py-3 px-3 text-center font-bold text-slate-800">4.5</td>
                                <td class="py-3 px-3 text-center">
                                    <span class="inline-flex items-center gap-0.5 px-2 py-0.5 bg-emerald-50 border border-emerald-100 text-[10px] font-bold text-[#006847] rounded-full">
                                        &uarr; +0.5
                                    </span>
                                </td>
                            </tr>
                            {{-- Row 2 --}}
                            <tr>
                                <td class="py-3 px-3 flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold truncate">Effective Communication</span>
                                </td>
                                <td class="py-3 px-3 text-center font-bold text-slate-500">4.0</td>
                                <td class="py-3 px-3 text-center font-bold text-slate-800">4.2</td>
                                <td class="py-3 px-3 text-center">
                                    <span class="inline-flex items-center gap-0.5 px-2 py-0.5 bg-emerald-50 border border-emerald-100 text-[10px] font-bold text-[#006847] rounded-full">
                                        &uarr; +0.2
                                    </span>
                                </td>
                            </tr>
                            {{-- Row 3 --}}
                            <tr>
                                <td class="py-3 px-3 flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-md bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold truncate">Time Management</span>
                                </td>
                                <td class="py-3 px-3 text-center font-bold text-slate-500">4.5</td>
                                <td class="py-3 px-3 text-center font-bold text-slate-800">3.8</td>
                                <td class="py-3 px-3 text-center">
                                    <span class="inline-flex items-center gap-0.5 px-2 py-0.5 bg-rose-50 border border-rose-100 text-[10px] font-bold text-rose-700 rounded-full">
                                        &darr; -0.7
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- Dynamic Database ranking table underneath --}}
        <div class="bg-white border border-slate-200/80 rounded-xl shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200/60 bg-[#f8fafc] flex items-center justify-between">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider select-none">Tabel Hasil Lengkap (Ranking Karyawan)</h2>
                <span class="text-xs text-slate-400 font-semibold select-none">{{ count($rankedResults) }} Karyawan</span>
            </div>
            
            @if(count($rankedResults) === 0)
            <div class="p-12 text-center select-none">
                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-600">Belum ada hasil penilaian</p>
                <p class="text-xs text-slate-400 mt-1">Hasil akan muncul setelah penilai menyelesaikan penilaian dan nilai dihitung.</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-[#f8fafc] border-b border-slate-200/60 text-[9px] font-bold text-slate-400 uppercase tracking-wider select-none">
                            <th class="py-3 px-6">Rank</th>
                            <th class="py-3 px-6">Karyawan</th>
                            <th class="py-3 px-6">Jabatan &amp; Divisi</th>
                            <th class="py-3 px-6 text-center">Nilai Akhir</th>
                            <th class="py-3 px-6">Komentar Reviewer</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($rankedResults as $r)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="py-4 px-6 select-none">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-extrabold text-xs
                                    {{ $r->rank === 1 ? 'bg-amber-400 text-white' : ($r->rank === 2 ? 'bg-slate-400 text-white' : ($r->rank === 3 ? 'bg-orange-400 text-white' : 'bg-slate-100 text-slate-500')) }}">
                                    {{ $r->rank }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-800">{{ $r->employee_nama }}</p>
                                <p class="text-[10px] text-slate-400 font-semibold mt-0.5 select-none">NIK: {{ $r->employee_nik }}</p>
                            </td>
                            <td class="py-4 px-6 select-none">
                                <p class="font-bold text-slate-600">{{ $r->employee_jabatan }}</p>
                                <p class="text-[10px] text-slate-400 font-semibold mt-0.5">{{ $r->employee_divisi }}</p>
                            </td>
                            <td class="py-4 px-6 text-center select-none">
                                <span class="inline-block px-3 py-1 rounded-full font-extrabold text-xs
                                    {{ $r->nilai_akhir >= 90 ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : ($r->nilai_akhir >= 75 ? 'bg-sky-100 text-sky-800 border border-sky-200' : ($r->nilai_akhir >= 60 ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-rose-100 text-rose-800 border border-rose-200')) }}">
                                    {{ number_format($r->nilai_akhir, 1) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-500 max-w-xs truncate">
                                {{ implode('; ', array_slice($r->comments, 0, 1)) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-100 px-8 py-3.5 flex items-center justify-between mt-auto select-none">
        <p class="text-[11px] text-slate-400">© 2026 PerformancePro Inc.</p>
        <div class="flex gap-4">
            <a href="#" class="text-[11px] text-slate-400 hover:text-[#006847]">Privacy Policy</a>
            <a href="#" class="text-[11px] text-slate-400 hover:text-[#006847]">Terms of Service</a>
        </div>
    </footer>

</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
