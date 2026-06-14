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
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Talent Mapping</h1>
            <p class="text-sm text-slate-400 mt-0.5">Pemetaan kuadran talenta (Star, Core, Need Improvement, Underperformer) berdasarkan performa.</p>
        </div>

        <!-- Matrix Board -->
        <div class="grid grid-cols-2 gap-6">
            <!-- STAR (High Performance) -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col min-h-[220px] transition-all hover:shadow-md hover:border-emerald-200">
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
                        <span class="text-xs text-slate-400 italic">Tidak ada karyawan di kuadran ini.</span>
                    @endforelse
                </div>
            </div>

            <!-- CORE (Medium Performance) -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col min-h-[220px] transition-all hover:shadow-md hover:border-sky-200">
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
                        <span class="text-xs text-slate-400 italic">Tidak ada karyawan di kuadran ini.</span>
                    @endforelse
                </div>
            </div>

            <!-- NEED IMPROVEMENT -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col min-h-[220px] transition-all hover:shadow-md hover:border-amber-200">
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
                        <span class="text-xs text-slate-400 italic">Tidak ada karyawan di kuadran ini.</span>
                    @endforelse
                </div>
            </div>

            <!-- UNDERPERFORMER -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col min-h-[220px] transition-all hover:shadow-md hover:border-rose-200">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">Underperformer (Low)</span>
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
                        <span class="text-xs text-slate-400 italic">Tidak ada karyawan di kuadran ini.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Detail Klasifikasi Karyawan</h2>
            </div>
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-6">NIK</th>
                        <th class="py-3.5 px-6">Karyawan</th>
                        <th class="py-3.5 px-6">Jabatan &amp; Divisi</th>
                        <th class="py-3.5 px-6 text-center">Nilai Akhir</th>
                        <th class="py-3.5 px-6">Kuadran Talenta</th>
                        <th class="py-3.5 px-6">Potensial</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($talentData as $row)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="py-4 px-6 text-slate-400 font-mono">{{ $row['nik'] }}</td>
                        <td class="py-4 px-6 font-bold text-slate-900">{{ $row['nama'] }}</td>
                        <td class="py-4 px-6">
                            <p class="font-semibold text-slate-600">{{ $row['jabatan'] }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $row['divisi'] }}</p>
                        </td>
                        <td class="py-4 px-6 text-center font-extrabold">{{ number_format($row['nilai'], 1) }}</td>
                        <td class="py-4 px-6">
                            <span class="inline-block px-2.5 py-0.5 rounded-full font-bold text-[10px]
                                {{ $row['kategori'] === 'Star' ? 'bg-emerald-100 text-emerald-800' : ($row['kategori'] === 'Core' ? 'bg-sky-100 text-sky-800' : ($row['kategori'] === 'Need Improvement' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800')) }}">
                                {{ $row['kategori'] }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-block px-2.5 py-0.5 rounded-full font-semibold text-[10px]
                                {{ $row['potential'] === 'High' ? 'bg-purple-100 text-purple-800' : ($row['potential'] === 'Medium' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-600') }}">
                                {{ $row['potential'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400 italic">Belum ada data nilai akhir yang dapat dipetakan. Silakan isi form penilaian terlebih dahulu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2026 PerformancePro Inc.</p>
    </footer>
</div>
</body>
</html>
