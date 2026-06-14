<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Analisis – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }
        .hover-card { transition: box-shadow .2s, transform .2s; }
        .hover-card:hover { box-shadow: 0 10px 30px rgba(0,0,0,.04); transform: translateY(-2px); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

{{-- ─── Sidebar ────────────────────────────────────────── --}}
<x-sidebar :active="'analysis'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
         hoveredPoint: null,
         period: 'Q3 2023',
         showPeriodDropdown: false
     }">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Dashboard Analisis</span>
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

        {{-- Hero Header --}}
        <div class="flex items-start justify-between">
            <div class="space-y-1">
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Analisis Performa</h1>
                <p class="text-sm text-slate-400 max-w-2xl leading-relaxed">
                    Tinjauan komprehensif metrik kinerja seluruh departemen.
                </p>
            </div>
            
            {{-- Dropdowns --}}
            <div class="flex items-center gap-2 relative">
                <button @click="showPeriodDropdown = !showPeriodDropdown"
                        @click.outside="showPeriodDropdown = false"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-slate-200 rounded-xl bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 shadow-sm transition-all">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                    </svg>
                    <span x-text="period">Q3 2023</span>
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>
                
                {{-- Period Selector list --}}
                <div x-show="showPeriodDropdown" x-cloak
                     class="absolute top-10 right-20 w-32 bg-white border border-slate-100 rounded-xl shadow-lg z-30 py-1 text-xs">
                    <button @click="period = 'Q3 2023'; showPeriodDropdown = false" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 text-slate-700">Q3 2023</button>
                    <button @click="period = 'Q2 2023'; showPeriodDropdown = false" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 text-slate-700">Q2 2023</button>
                    <button @click="period = 'Q1 2023'; showPeriodDropdown = false" class="w-full text-left px-3.5 py-2 hover:bg-slate-50 text-slate-700">Q1 2023</button>
                </div>

                <button class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-slate-200 rounded-xl bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 shadow-sm transition-all">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </div>

        {{-- Top Grid Section (Overall Performance Trend & Score Distribution) --}}
        <div class="grid grid-cols-5 gap-6">

            {{-- 1. Tren Kinerja (Line Chart) --}}
            <div class="col-span-3 bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col justify-between space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Tren Kinerja Keseluruhan</h3>
                        <p class="text-[10.5px] text-slate-400 mt-0.5">Peningkatan skor rata-rata selama 6 bulan terakhir.</p>
                    </div>
                    <button class="p-1 rounded hover:bg-slate-50 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/>
                        </svg>
                    </button>
                </div>

                {{-- Chart Area: Interactive Custom SVG Line Chart --}}
                <div class="relative py-2 flex items-center justify-center">
                    <svg viewBox="0 0 500 170" class="w-full h-full max-h-[170px] overflow-visible">
                        <!-- Horizontal Grid Lines -->
                        <line x1="40" y1="20" x2="470" y2="20" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="40" y1="55" x2="470" y2="55" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="40" y1="90" x2="470" y2="90" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="40" y1="125" x2="470" y2="125" stroke="#f1f5f9" stroke-width="1.5" />
                        
                        <!-- Left Y Axis Labels -->
                        <text x="30" y="24" text-anchor="end" class="text-[9px] fill-slate-300 font-bold">100</text>
                        <text x="30" y="59" text-anchor="end" class="text-[9px] fill-slate-300 font-bold">75</text>
                        <text x="30" y="94" text-anchor="end" class="text-[9px] fill-slate-300 font-bold">50</text>
                        <text x="30" y="129" text-anchor="end" class="text-[9px] fill-slate-300 font-bold">25</text>

                        <!-- Smooth Gradient Line Path -->
                        <path d="M 50 110 C 90 102, 90 101, 130 100 C 170 99, 170 101, 210 103 C 250 105, 250 88, 290 85 C 330 82, 330 68, 370 65 C 410 62, 410 52, 450 50" 
                              fill="none" stroke="#006240" stroke-width="3.5" stroke-linecap="round" />

                        <!-- Dots on chart lines -->
                        <!-- Apr -->
                        <circle cx="50" cy="110" r="5" fill="#ffffff" stroke="#006240" stroke-width="2.5" 
                                @mouseenter="hoveredPoint = {x: 50, y: 110, month: 'Apr', val: 78.2}" @mouseleave="hoveredPoint = null" class="cursor-pointer" />
                        <!-- Mei -->
                        <circle cx="130" cy="100" r="5" fill="#ffffff" stroke="#006240" stroke-width="2.5"
                                @mouseenter="hoveredPoint = {x: 130, y: 100, month: 'Mei', val: 80.5}" @mouseleave="hoveredPoint = null" class="cursor-pointer" />
                        <!-- Jun -->
                        <circle cx="210" cy="103" r="5" fill="#ffffff" stroke="#006240" stroke-width="2.5"
                                @mouseenter="hoveredPoint = {x: 210, y: 103, month: 'Jun', val: 79.8}" @mouseleave="hoveredPoint = null" class="cursor-pointer" />
                        <!-- Jul -->
                        <circle cx="290" cy="85" r="5" fill="#ffffff" stroke="#006240" stroke-width="2.5"
                                @mouseenter="hoveredPoint = {x: 290, y: 85, month: 'Jul', val: 83.1}" @mouseleave="hoveredPoint = null" class="cursor-pointer" />
                        <!-- Agt -->
                        <circle cx="370" cy="65" r="5.5" fill="#006240" stroke="#ffffff" stroke-width="2"
                                @mouseenter="hoveredPoint = {x: 370, y: 65, month: 'Agt', val: 86.4}" @mouseleave="hoveredPoint = null" class="cursor-pointer" />
                        <!-- Sep -->
                        <circle cx="450" cy="50" r="5" fill="#ffffff" stroke="#006240" stroke-width="2.5"
                                @mouseenter="hoveredPoint = {x: 450, y: 50, month: 'Sep', val: 88.5}" @mouseleave="hoveredPoint = null" class="cursor-pointer" />

                        <!-- X Axis Labels -->
                        <text x="50" y="150" text-anchor="middle" class="text-[9px] fill-slate-400 font-semibold">Apr</text>
                        <text x="130" y="150" text-anchor="middle" class="text-[9px] fill-slate-400 font-semibold">Mei</text>
                        <text x="210" y="150" text-anchor="middle" class="text-[9px] fill-slate-400 font-semibold">Jun</text>
                        <text x="290" y="150" text-anchor="middle" class="text-[9px] fill-slate-400 font-semibold">Jul</text>
                        <!-- Agt highlighted green as in mockup -->
                        <text x="370" y="150" text-anchor="middle" class="text-[9px] fill-[#006240] font-bold">Agt</text>
                        <text x="450" y="150" text-anchor="middle" class="text-[9px] fill-slate-400 font-semibold">Sep</text>
                    </svg>

                    {{-- Dynamic Chart Tooltip using Alpine.js --}}
                    <div x-show="hoveredPoint" x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute bg-slate-800 text-white rounded-lg px-2.5 py-1 text-[10px] font-semibold shadow-md pointer-events-none"
                         :style="'left: ' + (hoveredPoint ? (hoveredPoint.x * 0.95) + 'px' : '0px') + '; top: ' + (hoveredPoint ? (hoveredPoint.y - 45) + 'px' : '0px')">
                        <span x-text="hoveredPoint ? hoveredPoint.month + ': ' + hoveredPoint.val : ''"></span>
                    </div>
                </div>
            </div>

            {{-- 2. Distribusi Skor Penilaian --}}
            <div class="col-span-2 bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col justify-between space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Distribusi Skor Penilaian</h3>
                        <p class="text-[10.5px] text-slate-400 mt-0.5">Sebaran rentang nilai karyawan pada kuartal berjalan.</p>
                    </div>
                    <button class="p-1 rounded hover:bg-slate-50 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/>
                        </svg>
                    </button>
                </div>

                {{-- Distribution list --}}
                <div class="space-y-3 flex-1 flex flex-col justify-center">
                    @foreach($distributionData as $dist)
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span class="text-slate-600">{{ $dist['range'] }}</span>
                            <span class="text-slate-800 font-bold">{{ $dist['percentage'] }}%</span>
                        </div>
                        <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden w-full">
                            <div class="h-full rounded-full {{ $dist['bg_class'] }}" style="width: {{ $dist['percentage'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Bottom Row: Perbandingan Unit Kerja --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
            
            {{-- Header Table --}}
            <div class="px-6 py-4.5 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Perbandingan Unit Kerja</h3>
                    <p class="text-[10.5px] text-slate-400 mt-0.5">Analisis komparatif kinerja antar departemen.</p>
                </div>
                <a href="#" class="inline-flex items-center gap-1 text-xs font-bold text-[#006240] hover:text-[#004d31] transition-colors">
                    <span>Lihat Detail</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

            {{-- Table --}}
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-6">Unit / Departemen</th>
                        <th class="py-3 px-5">Kepala Unit</th>
                        <th class="py-3 px-5 text-center">Rata-rata Skor</th>
                        <th class="py-3 px-5">Penyelesaian</th>
                        <th class="py-3 px-6 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($unitComparison as $unit)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        {{-- Unit Name --}}
                        <td class="py-4 px-6 text-xs font-bold text-slate-800">
                            {{ $unit['unit'] }}
                        </td>
                        
                        {{-- Kepala Unit --}}
                        <td class="py-4 px-5 text-xs text-slate-500 font-medium">
                            {{ $unit['leader'] }}
                        </td>
                        
                        {{-- Rata-rata Skor with trend --}}
                        <td class="py-4 px-5 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <span class="text-xs font-bold text-slate-800">{{ number_format($unit['avg_score'], 1) }}</span>
                                @if($unit['trend_type'] === 'up')
                                <span class="inline-flex items-center gap-0.5 text-[9px] font-bold text-emerald-600 bg-emerald-50 px-1 rounded-sm">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                    </svg>
                                    {{ $unit['trend'] }}
                                </span>
                                @elseif($unit['trend_type'] === 'down')
                                <span class="inline-flex items-center gap-0.5 text-[9px] font-bold text-rose-600 bg-rose-50 px-1 rounded-sm">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                    {{ $unit['trend'] }}
                                </span>
                                @else
                                <span class="inline-flex items-center gap-0.5 text-[9px] font-bold text-slate-400 bg-slate-50 px-1 rounded-sm">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                    </svg>
                                    {{ $unit['trend'] }}
                                </span>
                                @endif
                            </div>
                        </td>
                        
                        {{-- Penyelesaian progress bar --}}
                        <td class="py-4 px-5">
                            <div class="space-y-1.5 max-w-[120px]">
                                <div class="flex items-center justify-between text-[10px] font-bold text-slate-500">
                                    <span>{{ $unit['completion_text'] }}</span>
                                </div>
                                <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden w-full">
                                    <div class="h-full bg-[#006240] rounded-full" style="width: {{ $unit['completion_pct'] }}%"></div>
                                </div>
                            </div>
                        </td>
                        
                        {{-- Status Badge --}}
                        <td class="py-4 px-6 text-right">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $unit['status_class'] }}">
                                {{ $unit['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
