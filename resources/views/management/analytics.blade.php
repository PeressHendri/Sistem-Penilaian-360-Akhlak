<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Analisis Performa – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
        .font-serif { font-family: 'Playfair Display', Georgia, serif; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

<x-sidebar :active="'analytics'"/>

<div class="ml-60 flex-1 flex flex-col min-h-screen">
    
    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-lg font-semibold text-[#006240] font-serif">PerformancePro</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Main Container --}}
    <main class="flex-1 p-8 max-w-7xl w-full mx-auto space-y-8">
        
        {{-- Hero Header --}}
        <div class="flex items-start justify-between">
            <div class="space-y-1.5">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight font-serif">Analisis Performa</h1>
                <p class="text-xs text-gray-500 max-w-2xl leading-relaxed">
                    Tinjauan komprehensif metrik kinerja seluruh departemen.
                </p>
            </div>
            
            <div class="flex gap-2.5">
                {{-- Date filter button --}}
                <button type="button"
                        class="inline-flex items-center gap-2 px-3.5 py-2 border border-gray-200 bg-white hover:bg-gray-50 text-xs font-bold text-gray-700 rounded-xl shadow-xs transition-all active:scale-95 focus:outline-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008z" />
                    </svg>
                    <span>Q3 2023</span>
                </button>
                
                {{-- General filter button --}}
                <button type="button"
                        class="inline-flex items-center gap-2 px-3.5 py-2 border border-gray-200 bg-white hover:bg-gray-50 text-xs font-bold text-gray-700 rounded-xl shadow-xs transition-all active:scale-95 focus:outline-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.155 1.733 6.073 4.29M12 3v3.75h3.75M12 21c-2.755 0-5.155-1.733-6.073-4.29M12 21v-3.75H8.25" />
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </div>

        {{-- Top widgets row --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Tren Kinerja Card --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 space-y-4 lg:col-span-2 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-gray-800">Tren Kinerja Keseluruhan</h2>
                        <p class="text-[10px] text-gray-400 font-medium mt-0.5">Peningkatan skor rata-rata selama 6 bulan terakhir.</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                        </svg>
                    </button>
                </div>
                
                {{-- Custom SVG curve line chart --}}
                <div class="w-full pt-2">
                    <svg class="w-full h-[200px]" viewBox="0 0 500 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="chart-grad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#006240" stop-opacity="0.12" />
                                <stop offset="100%" stop-color="#006240" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        
                        <!-- Grid Lines -->
                        <line x1="45" y1="20" x2="480" y2="20" stroke="#f1f5f9" stroke-width="1.5" stroke-dasharray="4 4" />
                        <line x1="45" y1="60" x2="480" y2="60" stroke="#f1f5f9" stroke-width="1.5" stroke-dasharray="4 4" />
                        <line x1="45" y1="100" x2="480" y2="100" stroke="#f1f5f9" stroke-width="1.5" stroke-dasharray="4 4" />
                        <line x1="45" y1="140" x2="480" y2="140" stroke="#f1f5f9" stroke-width="1.5" stroke-dasharray="4 4" />
                        <line x1="45" y1="180" x2="480" y2="180" stroke="#cbd5e1" stroke-width="1.5" />

                        <!-- Y-Axis Labels -->
                        <text x="15" y="24" fill="#94a3b8" font-size="10" font-weight="600">100</text>
                        <text x="18" y="64" fill="#94a3b8" font-size="10" font-weight="600">75</text>
                        <text x="18" y="104" fill="#94a3b8" font-size="10" font-weight="600">50</text>
                        <text x="18" y="144" fill="#94a3b8" font-size="10" font-weight="600">25</text>
                        <text x="24" y="184" fill="#94a3b8" font-size="10" font-weight="600">0</text>

                        <!-- X-Axis Labels -->
                        <text x="60" y="196" fill="#94a3b8" font-size="10" font-weight="600" text-anchor="middle">Apr</text>
                        <text x="140" y="196" fill="#94a3b8" font-size="10" font-weight="600" text-anchor="middle">Mei</text>
                        <text x="220" y="196" fill="#94a3b8" font-size="10" font-weight="600" text-anchor="middle">Jun</text>
                        <text x="300" y="196" fill="#94a3b8" font-size="10" font-weight="600" text-anchor="middle">Jul</text>
                        <text x="380" y="196" fill="#006240" font-size="10" font-weight="700" text-anchor="middle">Agt</text>
                        <text x="460" y="196" fill="#94a3b8" font-size="10" font-weight="600" text-anchor="middle">Sep</text>

                        <!-- Gradient fill area under curve -->
                        <path d="M 60 180 L 60 140 C 100 135, 120 130, 140 130 C 180 130, 200 135, 220 135 C 260 135, 280 105, 300 105 C 340 105, 360 80, 380 80 C 420 80, 440 70, 460 70 L 460 180 Z" fill="url(#chart-grad)" />

                        <!-- Curve path line -->
                        <path d="M 60 140 C 100 135, 120 130, 140 130 C 180 130, 200 135, 220 135 C 260 135, 280 105, 300 105 C 340 105, 360 80, 380 80 C 420 80, 440 70, 460 70" stroke="#006240" stroke-width="3" stroke-linecap="round" />

                        <!-- Highlighting vertical line indicator for August -->
                        <line x1="380" y1="20" x2="380" y2="180" stroke="#ceead6" stroke-width="1.5" stroke-dasharray="2 2" />

                        <!-- Chart Dots -->
                        <circle cx="60" cy="140" r="4" fill="#ffffff" stroke="#006240" stroke-width="2" />
                        <circle cx="140" cy="130" r="4" fill="#ffffff" stroke="#006240" stroke-width="2" />
                        <circle cx="220" cy="135" r="4" fill="#ffffff" stroke="#006240" stroke-width="2" />
                        <circle cx="300" cy="105" r="4" fill="#ffffff" stroke="#006240" stroke-width="2" />
                        <circle cx="380" cy="80" r="6" fill="#006240" stroke="#ffffff" stroke-width="2" />
                        <circle cx="460" cy="70" r="4" fill="#ffffff" stroke="#006240" stroke-width="2" />
                    </svg>
                </div>
            </div>
            
            {{-- Distribusi Skor Card --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 space-y-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-gray-800">Distribusi Skor Penilaian</h2>
                        <p class="text-[10px] text-gray-400 font-medium mt-0.5">Sebaran rentang nilai karyawan pada kuartal berjalan.</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4 pt-1">
                    <!-- Row 1: 90 - 100 -->
                    <div class="flex items-center justify-between text-xs gap-3">
                        <span class="w-14 text-gray-500 font-bold">90 - 100</span>
                        <div class="flex-1 bg-gray-100 h-3 rounded-lg overflow-hidden">
                            <div class="bg-[#006240] h-full rounded-lg" style="width: 15%"></div>
                        </div>
                        <span class="w-8 text-right font-extrabold text-gray-800">15%</span>
                    </div>
                    <!-- Row 2: 75 - 89 -->
                    <div class="flex items-center justify-between text-xs gap-3">
                        <span class="w-14 text-gray-500 font-bold">75 - 89</span>
                        <div class="flex-1 bg-gray-100 h-3 rounded-lg overflow-hidden">
                            <div class="bg-[#006240] h-full rounded-lg" style="width: 45%"></div>
                        </div>
                        <span class="w-8 text-right font-extrabold text-gray-800">45%</span>
                    </div>
                    <!-- Row 3: 60 - 74 -->
                    <div class="flex items-center justify-between text-xs gap-3">
                        <span class="w-14 text-gray-500 font-bold">60 - 74</span>
                        <div class="flex-1 bg-gray-100 h-3 rounded-lg overflow-hidden">
                            <div class="bg-[#475569] h-full rounded-lg" style="width: 30%"></div>
                        </div>
                        <span class="w-8 text-right font-extrabold text-gray-800">30%</span>
                    </div>
                    <!-- Row 4: < 60 -->
                    <div class="flex items-center justify-between text-xs gap-3">
                        <span class="w-14 text-gray-500 font-bold">&lt; 60</span>
                        <div class="flex-1 bg-gray-100 h-3 rounded-lg overflow-hidden">
                            <div class="bg-gray-300 h-full rounded-lg" style="width: 10%"></div>
                        </div>
                        <span class="w-8 text-right font-extrabold text-gray-800">10%</span>
                    </div>
                </div>
            </div>
            
        </div>

        {{-- Bottom table card: Perbandingan Unit Kerja --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-800 font-serif">Perbandingan Unit Kerja</h2>
                    <p class="text-[10px] text-gray-400 font-medium mt-0.5">Analisis komparatif kinerja antar departemen.</p>
                </div>
                
                <a href="#" class="text-xs font-bold text-[#006240] hover:text-[#004d31] transition-colors flex items-center gap-1 hover:underline">
                    <span>Lihat Detail</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-150 text-[10px] font-bold text-gray-400 uppercase tracking-wider select-none">
                            <th class="py-3.5 px-6">Unit / Departemen</th>
                            <th class="py-3.5 px-6">Kepala Unit</th>
                            <th class="py-3.5 px-6">Rata-rata Skor</th>
                            <th class="py-3.5 px-6">Penyelesaian</th>
                            <th class="py-3.5 px-6">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        {{-- Row 1: IT --}}
                        <tr class="hover:bg-gray-50/20 transition-colors">
                            <td class="py-4.5 px-6 font-bold text-gray-900">Teknologi Informasi (IT)</td>
                            <td class="py-4.5 px-6 font-medium text-gray-500">Budi Santoso</td>
                            <td class="py-4.5 px-6">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-extrabold text-gray-800 text-sm">88.5</span>
                                    <span class="inline-flex items-center gap-0.5 px-1 py-0.5 rounded bg-emerald-50 text-emerald-700 text-[10px] font-bold">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                                        <span>+2.1</span>
                                    </span>
                                </div>
                            </td>
                            <td class="py-4.5 px-6">
                                <div class="space-y-1.5">
                                    <div class="w-32 bg-gray-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-[#006240] h-full rounded-full" style="width: 100%"></div>
                                    </div>
                                    <span class="text-[10px] text-gray-400 font-semibold block">100% (45/45)</span>
                                </div>
                            </td>
                            <td class="py-4.5 px-6">
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Optimal
                                </span>
                            </td>
                        </tr>
                        {{-- Row 2: HR --}}
                        <tr class="hover:bg-gray-50/20 transition-colors">
                            <td class="py-4.5 px-6 font-bold text-gray-900">Sumber Daya Manusia (HR)</td>
                            <td class="py-4.5 px-6 font-medium text-gray-500">Siti Aminah</td>
                            <td class="py-4.5 px-6">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-extrabold text-gray-800 text-sm">82.0</span>
                                    <span class="text-gray-400 text-[10px] font-semibold">0.0</span>
                                </div>
                            </td>
                            <td class="py-4.5 px-6">
                                <div class="space-y-1.5">
                                    <div class="w-32 bg-gray-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-[#1a73e8] h-full rounded-full" style="width: 90%"></div>
                                    </div>
                                    <span class="text-[10px] text-gray-400 font-semibold block">90% (18/20)</span>
                                </div>
                            </td>
                            <td class="py-4.5 px-6">
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-[9px] font-extrabold bg-blue-50 text-blue-700 border border-blue-100">
                                    Stabil
                                </span>
                            </td>
                        </tr>
                        {{-- Row 3: Marketing --}}
                        <tr class="hover:bg-gray-50/20 transition-colors">
                            <td class="py-4.5 px-6 font-bold text-gray-900">Pemasaran &amp; Penjualan</td>
                            <td class="py-4.5 px-6 font-medium text-gray-500">Andi Wijaya</td>
                            <td class="py-4.5 px-6">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-extrabold text-gray-800 text-sm">74.5</span>
                                    <span class="inline-flex items-center gap-0.5 px-1 py-0.5 rounded bg-rose-50 text-rose-700 text-[10px] font-bold">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 13a1 1 0 110 2H7a1 1 0 01-1-1V9a1 1 0 112 0v2.586l4.293-4.293a1 1 0 011.414 0L12 9.586l4.293-4.293a1 1 0 111.414 1.414l-5 5a1 1 0 01-1.414 0L11 9.414 7.414 13H12z" clip-rule="evenodd"/></svg>
                                        <span>-1.5</span>
                                    </span>
                                </div>
                            </td>
                            <td class="py-4.5 px-6">
                                <div class="space-y-1.5">
                                    <div class="w-32 bg-gray-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-rose-500 h-full rounded-full" style="width: 65%"></div>
                                    </div>
                                    <span class="text-[10px] text-gray-400 font-semibold block">65% (52/80)</span>
                                </div>
                            </td>
                            <td class="py-4.5 px-6">
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-[9px] font-extrabold bg-rose-50 text-rose-700 border border-rose-100">
                                    Perhatian
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-slate-400">© 2026 PerformancePro Inc.</p>
        <div class="flex gap-4">
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Privacy</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Terms</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Support</a>
        </div>
    </footer>
</div>
</body>
</html>
