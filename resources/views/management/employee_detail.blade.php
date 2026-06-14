<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Detail Performa Karyawan – PerformancePro</title>
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
        <div class="flex items-center space-x-2">
            <a href="{{ route('management.ranking') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <span class="text-sm font-semibold text-[#006240]">Laporan Detail Performa</span>
        </div>
    </header>

    <main class="flex-1 p-8 max-w-4xl w-full mx-auto space-y-6">
        <!-- Top Profile Card -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Profil Karyawan</span>
                <h1 class="text-xl font-bold text-slate-900">{{ $employee->nama }}</h1>
                <p class="text-xs text-slate-500 font-semibold">NIK: {{ $employee->nik }} • {{ $employee->jabatan }} • {{ $employee->divisi }}</p>
            </div>
            <div class="text-center bg-[#006240]/10 border border-[#006240]/20 px-5 py-3 rounded-2xl">
                <p class="text-[10px] font-bold text-[#006240] uppercase tracking-wider">Skor Akhir</p>
                <p class="text-3xl font-black text-[#006240] mt-0.5">
                    {{ $result ? number_format($result->nilai_akhir, 1) : '0.0' }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <!-- Reviewers List -->
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-4 col-span-1 h-fit">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Status Reviewer</h2>
                <div class="divide-y divide-slate-50 space-y-2">
                    @forelse($reviewers as $rev)
                    <div class="flex items-center justify-between pt-2">
                        <div>
                            <p class="text-xs font-bold text-slate-900">{{ $rev->nama }}</p>
                            <p class="text-[10px] text-slate-400">{{ $rev->tipe_penilai }}</p>
                        </div>
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full
                            {{ $rev->status === 'Selesai' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-50 text-slate-500' }}">
                            {{ $rev->status }}
                        </span>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic">Belum ada reviewer.</p>
                    @endforelse
                </div>
            </div>

            <!-- Score breakdown detail -->
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden col-span-2">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Skor Rata-Rata Per Indikator AKHLAK</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($details as $d)
                    <div class="p-6 flex items-center justify-between">
                        <div class="space-y-0.5 max-w-sm">
                            <div class="flex items-center space-x-2">
                                <span class="text-[9px] font-bold text-[#006240] bg-[#006240]/5 px-1.5 py-0.5 rounded">{{ $d->cv_kode }}</span>
                                <h3 class="text-xs font-bold text-slate-800">{{ $d->nama_indikator }}</h3>
                            </div>
                            <p class="text-[10px] text-slate-400">Core value: {{ $d->cv_nama }} (Bobot: {{ $d->bobot }}%)</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-extrabold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-lg">
                                {{ number_format($d->avg_score, 1) }} / 5.0
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-xs text-slate-400 italic">Tidak ada detail skor yang submitted.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Individual Development Plan Card -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-50 pb-2">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Rencana Aksi Pengembangan Diri (IDP)</h2>
                @if($idp)
                <span class="text-[9px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full">{{ $idp->status }}</span>
                @endif
            </div>
            @if($idp)
            <div class="grid grid-cols-2 gap-6 text-xs">
                <div class="space-y-1">
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Target Kompetensi</p>
                    <p class="font-bold text-slate-900">{{ $idp->target_kompetensi }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Timeline</p>
                    <p class="font-semibold text-slate-700">{{ $idp->timeline }}</p>
                </div>
                <div class="col-span-2 space-y-1">
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Rencana Aksi</p>
                    <p class="text-slate-600 leading-relaxed font-medium bg-slate-50 p-3 rounded-xl border border-slate-100">{{ $idp->rencana_aksi }}</p>
                </div>
            </div>
            @else
            <p class="text-xs text-slate-400 italic">Rencana pengembangan (IDP) belum disusun oleh Human Capital untuk karyawan ini.</p>
            @endif
        </div>
    </main>

    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2026 PerformancePro Inc.</p>
    </footer>
</div>
</body>
</html>
