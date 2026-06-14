<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Penilai – PerformancePro</title>
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

<div class="ml-60 flex-1 flex flex-col min-h-screen">
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Dashboard Penilai</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6">
        <!-- Welcoming Card -->
        <div class="bg-gradient-to-br from-[#006240] to-[#004d32] text-white p-8 rounded-3xl shadow-xl flex items-center justify-between relative overflow-hidden">
            <div class="space-y-2 relative z-10">
                <h1 class="text-xl md:text-2xl font-bold tracking-tight">Selamat Datang, {{ $user->name }}!</h1>
                <p class="text-xs md:text-sm text-emerald-100/90 font-medium">Anda ditugaskan sebagai Rater untuk menilai rekan kerja, atasan, atau bawahan.</p>
                <div class="pt-4 flex items-center space-x-6">
                    <div>
                        <p class="text-[10px] text-emerald-200/75 uppercase tracking-wider font-semibold">Tugas Penilaian</p>
                        <p class="text-xl font-black mt-0.5">{{ $totalTugas }} Karyawan</p>
                    </div>
                    <div class="w-px h-8 bg-emerald-700/50"></div>
                    <div>
                        <p class="text-[10px] text-emerald-200/75 uppercase tracking-wider font-semibold">Telah Selesai</p>
                        <p class="text-xl font-black mt-0.5 text-emerald-300">{{ $selesai }}</p>
                    </div>
                </div>
            </div>
            <!-- Progress Circle -->
            <div class="relative w-24 h-24 flex items-center justify-center bg-white/5 rounded-full backdrop-blur-sm border border-white/10 shrink-0">
                <div class="text-center">
                    <p class="text-xl font-black">{{ $progress }}%</p>
                    <p class="text-[9px] uppercase tracking-wider text-emerald-200/80 font-bold">Progress</p>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Belum Mulai</span>
                <p class="text-3xl font-extrabold text-slate-800">{{ $belum }}</p>
            </div>
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sedang Mengisi</span>
                <p class="text-3xl font-extrabold text-amber-500">{{ $sedang }}</p>
            </div>
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Selesai Submit</span>
                <p class="text-3xl font-extrabold text-emerald-500">{{ $selesai }}</p>
            </div>
        </div>

        <!-- Task List -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Tugas Penilaian Anda</h2>
                <a href="{{ route('reviewer.assessments.index') }}" class="text-xs font-bold text-[#006240] hover:text-[#004d32] transition-colors">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Karyawan</th>
                            <th class="py-3.5 px-6">Jabatan &amp; Divisi</th>
                            <th class="py-3.5 px-6">Hubungan Rater</th>
                            <th class="py-3.5 px-6">Program Penilaian</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentForms as $row)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900">{{ $row->ratee_nama }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-semibold text-slate-600">{{ $row->ratee_jabatan }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $row->ratee_divisi }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-block px-2.5 py-0.5 rounded-full font-bold text-[10px]
                                    {{ $row->tipe_penilai === 'Atasan' ? 'bg-purple-100 text-purple-800' : ($row->tipe_penilai === 'Rekan' ? 'bg-sky-100 text-sky-800' : 'bg-orange-100 text-orange-800') }}">
                                    {{ $row->tipe_penilai }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-500">{{ $row->nama_program }}</td>
                            <td class="py-4 px-6">
                                <span class="inline-block px-2 py-0.5 rounded-full font-bold text-[10px]
                                    {{ $row->status === 'Selesai' ? 'bg-emerald-100 text-emerald-800' : ($row->status === 'Sedang' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-500') }}">
                                    {{ $row->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($row->status === 'Selesai')
                                    <a href="{{ route('reviewer.assessments.summary', $row->form_id ?? 1) }}" 
                                       class="text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors">Lihat Ringkasan</a>
                                @else
                                    <a href="{{ route('reviewer.assessments.form', $row->id) }}" 
                                       class="px-3.5 py-1.5 bg-[#006240] hover:bg-[#004d32] text-white font-bold rounded-xl transition-all shadow-sm hover:shadow text-[10px]">
                                        {{ $row->status === 'Sedang' ? 'Lanjutkan' : 'Mulai Nilai' }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 italic">Anda tidak memiliki tugas penilaian aktif saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2026 PerformancePro Inc.</p>
    </footer>
</div>
</body>
</html>
