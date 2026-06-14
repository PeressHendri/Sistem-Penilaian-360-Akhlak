<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Ranking Evaluasi – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

<x-sidebar :active="'ranking'"/>

<div class="ml-60 flex-1 flex flex-col min-h-screen">
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Daftar Peringkat Nilai Evaluasi</span>
    </header>

    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Ranking Performa Karyawan</h1>
            <p class="text-sm text-slate-400 mt-0.5">Daftar lengkap seluruh ranking karyawan berdasarkan akumulasi nilai evaluasi AKHLAK dari seluruh reviewer.</p>
        </div>

        <!-- Filter Bar -->
        <form action="{{ route('management.ranking') }}" method="GET" class="bg-white border border-slate-100 p-4 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIK..." 
                       class="w-full pl-9 pr-4 py-2 text-xs border border-slate-100 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-[#006240] outline-none transition-all"/>
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.604 10.604z"/>
                </svg>
            </div>
            <select name="divisi" class="w-48 px-3.5 py-2 text-xs border border-slate-100 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-[#006240] outline-none transition-all">
                <option value="">Semua Divisi</option>
                @foreach($divisions as $div)
                    <option value="{{ $div }}" {{ $divisi === $div ? 'selected' : '' }}>{{ $div }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-[#006240] hover:bg-[#004d32] text-white font-bold rounded-xl transition-all shadow-sm hover:shadow text-xs">
                Filter
            </button>
        </form>

        <!-- Ranking Table -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-6">Rank</th>
                        <th class="py-3.5 px-6">NIK</th>
                        <th class="py-3.5 px-6">Karyawan</th>
                        <th class="py-3.5 px-6">Jabatan &amp; Divisi</th>
                        <th class="py-3.5 px-6 text-center">Nilai Akhir</th>
                        <th class="py-3.5 px-6 text-center">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rankedResults as $row)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="py-4 px-6">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center font-extrabold text-[11px]
                                {{ $row->rank === 1 ? 'bg-amber-400 text-white' : ($row->rank === 2 ? 'bg-slate-400 text-white' : ($row->rank === 3 ? 'bg-orange-400 text-white' : 'bg-slate-100 text-slate-500')) }}">
                                {{ $row->rank }}
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-400 font-mono">{{ $row->nik }}</td>
                        <td class="py-4 px-6 font-bold text-slate-900">{{ $row->nama }}</td>
                        <td class="py-4 px-6">
                            <p class="font-semibold text-slate-600">{{ $row->jabatan }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $row->divisi }}</p>
                        </td>
                        <td class="py-4 px-6 text-center font-extrabold text-slate-900">
                            <span class="inline-block px-2.5 py-1 rounded-full font-extrabold text-xs
                                {{ $row->nilai_akhir >= 90 ? 'bg-emerald-100 text-emerald-800' : ($row->nilai_akhir >= 75 ? 'bg-sky-100 text-sky-800' : ($row->nilai_akhir >= 60 ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800')) }}">
                                {{ number_format($row->nilai_akhir, 1) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('management.employees.detail', $row->employee_id) }}" 
                               class="text-xs font-bold text-[#006240] hover:text-[#004d32] transition-colors">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400 italic">Belum ada data nilai akhir yang memenuhi kriteria pencarian.</td>
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
