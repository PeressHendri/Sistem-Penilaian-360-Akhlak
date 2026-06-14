<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Talent Mapping – PerformancePro</title>
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

<x-sidebar :active="'talent-mapping'"/>

<div class="ml-60 flex-1 flex flex-col min-h-screen">
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Talent Mapping</span>
    </header>

    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Talent Mapping</h1>
            <p class="text-sm text-slate-400 mt-0.5">Pemetaan matriks talenta 9-box berdasarkan total akumulasi kinerja budaya AKHLAK.</p>
        </div>

        <!-- 9-Box Matrix Grid representation -->
        <div class="grid grid-cols-2 gap-6">
            <!-- STAR -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col min-h-[220px]">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Star (High)</span>
                    <span class="text-xs font-extrabold text-slate-400">{{ $quadrantStats['Star'] ?? 0 }} Orang</span>
                </div>
                <div class="flex-1 flex flex-wrap gap-2 content-start overflow-y-auto max-h-32">
                    @forelse(collect($talentData)->where('kategori', 'Star') as $t)
                        <div class="bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-xl text-xs flex items-center space-x-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            <span class="font-semibold text-slate-700">{{ $t['nama'] }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">({{ number_format($t['nilai'], 1) }})</span>
                        </div>
                    @empty
                        <span class="text-xs text-slate-400 italic">Tidak ada karyawan.</span>
                    @endforelse
                </div>
            </div>

            <!-- CORE -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col min-h-[220px]">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-50 px-2.5 py-1 rounded-full">Core (Medium)</span>
                    <span class="text-xs font-extrabold text-slate-400">{{ $quadrantStats['Core'] ?? 0 }} Orang</span>
                </div>
                <div class="flex-1 flex flex-wrap gap-2 content-start overflow-y-auto max-h-32">
                    @forelse(collect($talentData)->where('kategori', 'Core') as $t)
                        <div class="bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-xl text-xs flex items-center space-x-2">
                            <span class="w-2 h-2 bg-sky-500 rounded-full"></span>
                            <span class="font-semibold text-slate-700">{{ $t['nama'] }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">({{ number_format($t['nilai'], 1) }})</span>
                        </div>
                    @empty
                        <span class="text-xs text-slate-400 italic">Tidak ada karyawan.</span>
                    @endforelse
                </div>
            </div>

            <!-- NEED IMPROVEMENT -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col min-h-[220px]">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Need Improvement</span>
                    <span class="text-xs font-extrabold text-slate-400">{{ $quadrantStats['Need Improvement'] ?? 0 }} Orang</span>
                </div>
                <div class="flex-1 flex flex-wrap gap-2 content-start overflow-y-auto max-h-32">
                    @forelse(collect($talentData)->where('kategori', 'Need Improvement') as $t)
                        <div class="bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-xl text-xs flex items-center space-x-2">
                            <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                            <span class="font-semibold text-slate-700">{{ $t['nama'] }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">({{ number_format($t['nilai'], 1) }})</span>
                        </div>
                    @empty
                        <span class="text-xs text-slate-400 italic">Tidak ada karyawan.</span>
                    @endforelse
                </div>
            </div>

            <!-- UNDERPERFORMER -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col min-h-[220px]">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">Underperformer</span>
                    <span class="text-xs font-extrabold text-slate-400">{{ $quadrantStats['Underperformer'] ?? 0 }} Orang</span>
                </div>
                <div class="flex-1 flex flex-wrap gap-2 content-start overflow-y-auto max-h-32">
                    @forelse(collect($talentData)->where('kategori', 'Underperformer') as $t)
                        <div class="bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-xl text-xs flex items-center space-x-2">
                            <span class="w-2 h-2 bg-rose-500 rounded-full"></span>
                            <span class="font-semibold text-slate-700">{{ $t['nama'] }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">({{ number_format($t['nilai'], 1) }})</span>
                        </div>
                    @empty
                        <span class="text-xs text-slate-400 italic">Tidak ada karyawan.</span>
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
