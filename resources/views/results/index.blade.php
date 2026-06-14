<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Hasil Penilaian – PerformancePro</title>
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
<x-sidebar :active="'assessment-results'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
         trendMode: 'Q3',
         hoveredPoint: null
     }">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Hasil Penilaian</span>
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
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Hasil Penilaian</h1>
                <p class="text-sm text-slate-400 max-w-2xl leading-relaxed">
                    Final evaluation overview for Q3 2023.
                </p>
            </div>
            
            {{-- PDF Export Button --}}
            <button @click="alert('Mengekspor laporan penilaian sebagai PDF...')"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-xs font-semibold text-white rounded-xl shadow-sm transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                <span>Export PDF</span>
            </button>
        </div>

        {{-- Top cards grid (Overall score, Growth trend) --}}
        <div class="grid grid-cols-5 gap-6">

            {{-- 1. Overall Score Card --}}
            <div class="col-span-2 bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col justify-between h-48">
                <div>
                    <span class="text-xs font-bold text-slate-400 block mb-1 tracking-wide uppercase">Overall Score</span>
                    <div class="flex items-baseline gap-1 mt-2">
                        <span class="text-4xl font-extrabold text-slate-900 tracking-tight">88.4</span>
                        <span class="text-sm font-semibold text-slate-400">/ 100</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-50 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-semibold">Performance status</span>
                    <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#006240] text-white text-[10.5px] font-bold rounded-xl shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                        </svg>
                        <span>Exceeds Expectations</span>
                    </span>
                </div>
            </div>

            {{-- 2. Growth Trend Card --}}
            <div class="col-span-3 bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col justify-between h-48 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800">Growth Trend</h3>
                    
                    {{-- Toggle selectors --}}
                    <div class="flex items-center bg-slate-50 rounded-lg p-0.5 border border-slate-100">
                        <button @click="trendMode = 'YTD'" 
                                :class="trendMode === 'YTD' ? 'bg-white text-slate-800 shadow-xs' : 'text-slate-400 hover:text-slate-600'"
                                class="px-2.5 py-1 text-[9px] font-extrabold rounded-md transition-all">
                            YTD
                        </button>
                        <button @click="trendMode = 'Q3'" 
                                :class="trendMode === 'Q3' ? 'bg-white text-slate-800 shadow-xs' : 'text-slate-400 hover:text-slate-600'"
                                class="px-2.5 py-1 text-[9px] font-extrabold rounded-md transition-all">
                            Q3
                        </button>
                    </div>
                </div>

                {{-- Chart Area: SVG Line Chart --}}
                <div class="relative py-1 flex-1 flex items-center justify-center">
                    
                    {{-- YTD Chart view --}}
                    <svg x-show="trendMode === 'YTD'" x-cloak viewBox="0 0 400 90" class="w-full h-full overflow-visible">
                        <path d="M 30 70 C 100 65, 140 50, 200 45 C 260 40, 320 28, 370 20" 
                              fill="none" stroke="#006240" stroke-width="3" stroke-linecap="round" />
                        
                        <circle cx="30" cy="70" r="4.5" fill="#ffffff" stroke="#006240" stroke-width="2" />
                        <circle cx="200" cy="45" r="4.5" fill="#ffffff" stroke="#006240" stroke-width="2" />
                        <circle cx="370" cy="20" r="5" fill="#006240" stroke="#ffffff" stroke-width="1.8" />
                        
                        <text x="30" y="86" text-anchor="middle" class="text-[8px] fill-slate-400 font-semibold">Q1</text>
                        <text x="200" y="61" text-anchor="middle" class="text-[8px] fill-slate-400 font-semibold">Q2</text>
                        <text x="370" y="36" text-anchor="middle" class="text-[8px] fill-[#006240] font-bold">Q3</text>
                    </svg>

                    {{-- Q3 Chart view --}}
                    <svg x-show="trendMode === 'Q3'" x-cloak viewBox="0 0 400 90" class="w-full h-full overflow-visible">
                        <path d="M 30 75 C 90 70, 130 52, 190 48 C 250 44, 300 25, 370 20" 
                              fill="none" stroke="#006240" stroke-width="3" stroke-linecap="round" />
                        
                        <circle cx="30" cy="75" r="4.5" fill="#ffffff" stroke="#006240" stroke-width="2"
                                @mouseenter="hoveredPoint = {x: 30, y: 75, label: 'Q3-1', val: 72}" @mouseleave="hoveredPoint = null" class="cursor-pointer" />
                        <circle cx="190" cy="48" r="4.5" fill="#ffffff" stroke="#006240" stroke-width="2"
                                @mouseenter="hoveredPoint = {x: 190, y: 48, label: 'Q3-2', val: 81}" @mouseleave="hoveredPoint = null" class="cursor-pointer" />
                        <circle cx="290" cy="35" r="4.5" fill="#ffffff" stroke="#006240" stroke-width="2"
                                @mouseenter="hoveredPoint = {x: 290, y: 35, label: 'Mid-Q3', val: 84}" @mouseleave="hoveredPoint = null" class="cursor-pointer" />
                        <circle cx="370" cy="20" r="5.5" fill="#006240" stroke="#ffffff" stroke-width="1.8"
                                @mouseenter="hoveredPoint = {x: 370, y: 20, label: 'Q3 Final', val: 88.4}" @mouseleave="hoveredPoint = null" class="cursor-pointer" />
                        
                        <text x="30" y="88" text-anchor="middle" class="text-[8px] fill-slate-400 font-semibold">Q3-1</text>
                        <text x="190" y="62" text-anchor="middle" class="text-[8px] fill-slate-400 font-semibold">Q3-2</text>
                        <text x="290" y="49" text-anchor="middle" class="text-[8px] fill-slate-400 font-semibold">Mid</text>
                        <text x="370" y="34" text-anchor="middle" class="text-[8px] fill-[#006240] font-bold">Q3</text>
                    </svg>

                    {{-- Tooltip --}}
                    <div x-show="hoveredPoint" x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute bg-slate-800 text-white rounded-lg px-2 py-0.5 text-[9px] font-semibold shadow-md pointer-events-none"
                         :style="'left: ' + (hoveredPoint ? (hoveredPoint.x * 0.95) + 'px' : '0px') + '; top: ' + (hoveredPoint ? (hoveredPoint.y - 25) + 'px' : '0px')">
                        <span x-text="hoveredPoint ? hoveredPoint.label + ': ' + hoveredPoint.val : ''"></span>
                    </div>

                </div>
            </div>

        </div>

        {{-- Bottom Row: Score Distribution & Competency Variance --}}
        <div class="grid grid-cols-5 gap-6 items-start">
            
            {{-- Score Distribution --}}
            <div class="col-span-2 bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-800">Score Distribution</h3>
                
                <div class="space-y-4">
                    @foreach($scoreDistribution as $dist)
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span class="text-slate-600">{{ $dist['label'] }}</span>
                            <span class="text-slate-800 font-extrabold">{{ $dist['pct'] }}%</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden w-full">
                            <div class="h-full rounded-full {{ $dist['class'] }}" style="width: {{ $dist['pct'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Competency Breakdown Table --}}
            <div class="col-span-3 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
                <div class="px-6 py-4.5 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800">Competency Breakdown</h3>
                    <button class="p-1 rounded hover:bg-slate-50 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
                        </svg>
                    </button>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3 px-6">Metric Area</th>
                            <th class="py-3 px-4 text-center">Target</th>
                            <th class="py-3 px-4 text-center">Achieved</th>
                            <th class="py-3 px-6 text-right">Variance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($competencyBreakdown as $comp)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            {{-- Area --}}
                            <td class="py-4 px-6 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg {{ $comp['icon_class'] }} flex items-center justify-center flex-shrink-0">
                                    @if($comp['icon'] === 'lightbulb')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-3H9.75M12 18h3.75M12 18V9.75M17.056 14.253a8.99 8.99 0 01-3.66 4.93m3.66-4.93a8.99 8.99 0 00-1.84-5.32m-13.876 10.25a8.99 8.99 0 003.66 4.93m-3.66-4.93a8.99 8.99 0 011.84-5.32M17.056 9.324a8.99 8.99 0 00-5.056-5.574m0 0a8.99 8.99 0 00-5.056 5.574M12 3.75v6M12 9.75h.008v.008H12V9.75z"/>
                                    </svg>
                                    @elseif($comp['icon'] === 'chat')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                                    </svg>
                                    @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @endif
                                </div>
                                <span class="text-xs font-bold text-slate-800">{{ $comp['area'] }}</span>
                            </td>
                            
                            {{-- Target --}}
                            <td class="py-4 px-4 text-center text-xs text-slate-500 font-semibold">
                                {{ number_format($comp['target'], 1) }}
                            </td>
                            
                            {{-- Achieved --}}
                            <td class="py-4 px-4 text-center text-xs font-extrabold text-slate-800">
                                {{ number_format($comp['achieved'], 1) }}
                            </td>
                            
                            {{-- Variance badge --}}
                            <td class="py-4 px-6 text-right">
                                <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-lg text-[10px] font-bold {{ $comp['var_class'] }}">
                                    @if(strpos($comp['variance'], '+') !== false)
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                    </svg>
                                    @else
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                    @endif
                                    <span>{{ $comp['variance'] }}</span>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

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
