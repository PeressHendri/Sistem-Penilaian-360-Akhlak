<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tugas Penilaian – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

<x-sidebar :active="'assessments'"/>

<div class="ml-60 flex-1 flex flex-col min-h-screen" x-data="{ step: 1 }">
    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-base font-bold text-[#006240]">PerformancePro</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6">
        
        {{-- STEP 1 header --}}
        <div x-show="step === 1" x-transition class="space-y-2">
            <div class="flex items-center gap-1.5 text-[10px] font-bold text-[#006240] uppercase tracking-wider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>
                </svg>
                <span>Periode {{ $forms[0]->nama_program ?? 'Q3 2024' }} • {{ $employee->divisi ?? 'HR Department' }}</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Instruksi & Persiapan</h1>
            <p class="text-xs text-slate-500 max-w-2xl leading-relaxed">
                Harap baca panduan berikut sebelum memulai proses pengisian skor detail untuk memastikan penilaian yang objektif dan selaras dengan KPI perusahaan.
            </p>
        </div>

        {{-- STEP 2 header --}}
        <div x-show="step === 2" x-transition class="flex items-center justify-between border-b border-slate-100 pb-3" x-cloak>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Karyawan untuk Dinilai</h1>
                <p class="text-xs text-slate-500">Silakan pilih karyawan di bawah ini untuk memulai pengisian skor indikator.</p>
            </div>
            <button @click="step = 1" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-slate-650 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
                <span>Kembali ke Panduan</span>
            </button>
        </div>

        @if(session('info'))
            <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl text-amber-800 text-xs font-semibold">
                {{ session('info') }}
            </div>
        @endif

        {{-- Stepper Progress Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Stepper box --}}
            <div class="md:col-span-2 bg-white border border-slate-150 rounded-2xl p-6 shadow-xs flex items-center justify-center">
                <div class="flex items-center w-full max-w-lg justify-between relative">
                    <!-- Background Connecting Line -->
                    <div class="absolute top-5 left-0 right-0 h-0.5 bg-slate-100 -z-0"></div>
                    <!-- Active Connecting Line (1 to 2) -->
                    <div class="absolute top-5 left-0 h-0.5 bg-[#006240] -z-0 transition-all duration-300" 
                         :class="step === 2 ? 'w-1/3' : 'w-0'"></div>
                    
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-350"
                             :class="step === 1 ? 'bg-[#006240] text-white ring-4 ring-[#e6f4ea]' : 'bg-[#e6f4ea] text-[#137333]'">
                             <span x-show="step === 1">1</span>
                             <svg x-show="step > 1" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-[10px] font-bold mt-2 transition-colors duration-300" :class="step === 1 ? 'text-[#006240] font-bold' : 'text-slate-400'">Persiapan</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-350 border"
                             :class="step === 2 ? 'bg-[#006240] text-white border-transparent ring-4 ring-[#e6f4ea]' : 'bg-white text-slate-400 border-slate-200'">
                            <span>2</span>
                        </div>
                        <span class="text-[10px] font-bold mt-2 transition-colors duration-300" :class="step === 2 ? 'text-[#006240]' : 'text-slate-400'">Input Skor</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold border bg-white text-slate-400 border-slate-200">
                            <span>3</span>
                        </div>
                        <span class="text-[10px] font-bold mt-2 text-slate-400">Review</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold border bg-white text-slate-400 border-slate-200">
                            <span>4</span>
                        </div>
                        <span class="text-[10px] font-bold mt-2 text-slate-400">Submit</span>
                    </div>
                </div>
            </div>

            {{-- Progress box --}}
            <div class="bg-white border border-slate-150 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Progres</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-text="step === 1 ? 'Tahap 1 dari 4' : 'Tahap 2 dari 4'"></span>
                </div>
                <div class="my-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-slate-800 tracking-tight" x-text="step === 1 ? '25%' : '50%'"></span>
                    <span class="text-xs font-bold text-slate-400">Selesai</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-[#006240] h-full rounded-full transition-all duration-500" :style="step === 1 ? 'width: 25%' : 'width: 50%'"></div>
                </div>
            </div>
        </div>

        {{-- STEP 1: Guideline Cards & Banner --}}
        <div x-show="step === 1" x-transition class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white border border-slate-150 rounded-2xl p-6 shadow-xs flex flex-col space-y-4 hover:shadow-sm transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 8.25h16.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-sm font-bold text-slate-800 tracking-tight">Standar Objektivitas</h3>
                        <p class="text-[11px] text-slate-450 leading-relaxed">
                            Penilaian harus didasarkan pada data pencapaian aktual (log aktivitas, laporan target), bukan opini subjektif atau impresi personal.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white border border-slate-150 rounded-2xl p-6 shadow-xs flex flex-col space-y-4 hover:shadow-sm transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-[#e6f4ea] text-[#006240] flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-sm font-bold text-slate-800 tracking-tight">Distribusi Nilai</h3>
                        <p class="text-[11px] text-slate-450 leading-relaxed">
                            Gunakan skala 1-5 dengan bijak. Nilai 5 (Sangat Baik) hanya diberikan jika pencapaian secara konsisten melebihi ekspektasi utama (120%+).
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white border border-slate-150 rounded-2xl p-6 shadow-xs flex flex-col space-y-4 hover:shadow-sm transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-sm font-bold text-slate-800 tracking-tight">Catatan Pendukung</h3>
                        <p class="text-[11px] text-slate-450 leading-relaxed">
                            Setiap skor ekstrim (1 atau 5) wajib disertai dengan catatan kualitatif yang menjelaskan insiden atau pencapaian spesifik yang mendasarinya.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Warning Banner -->
            <div class="bg-[#f0f9eb] border border-[#e1f3d8] rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#e1f3d8] flex items-center justify-center text-[#67c23a] flex-shrink-0">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.083.92l-.083.082l-.041.02a.75.75 0 01-1.083-.92l.083-.082zm0-3h.018v.018h-.018V8.25zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-xs">
                        <h4 class="font-bold text-[#67c23a]">Siap Memulai Penilaian?</h4>
                        <p class="text-slate-500 font-medium mt-0.5">Sistem akan secara otomatis menyimpan progres Anda setiap kali berpindah indikator.</p>
                    </div>
                </div>
                <button @click="step = 2" 
                        class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-[#006240] hover:bg-[#004d32] text-white text-xs font-bold rounded-xl transition-all shadow-sm active:scale-95 flex-shrink-0">
                    <span>Lanjut ke Input Skor Detail</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- STEP 2: Table List --}}
        <div x-show="step === 2" x-transition class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden" x-cloak>
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Seluruh Karyawan untuk Dinilai</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Karyawan</th>
                            <th class="py-3.5 px-6">Jabatan &amp; Divisi</th>
                            <th class="py-3.5 px-6">Tipe Hubungan</th>
                            <th class="py-3.5 px-6">Program</th>
                            <th class="py-3.5 px-6">Batas Waktu</th>
                            <th class="py-3.5 px-6">Keterisian Indikator</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($forms as $row)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900">{{ $row->ratee_nama }}</td>
                            <td class="py-4 px-6">
                                <p class="font-semibold text-slate-600">{{ $row->ratee_jabatan }}</p>
                                <p class="text-[10px] text-slate-450 mt-0.5">{{ $row->ratee_divisi }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-block px-2.5 py-0.5 rounded-full font-bold text-[9px]
                                    {{ $row->tipe_penilai === 'Atasan' ? 'bg-purple-50 text-purple-700 border border-purple-100' : ($row->tipe_penilai === 'Rekan' ? 'bg-sky-50 text-sky-700 border border-sky-100' : 'bg-orange-50 text-orange-700 border border-orange-100') }}">
                                    {{ $row->tipe_penilai }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-500">{{ $row->nama_program }}</td>
                            <td class="py-4 px-6 font-semibold text-slate-400">
                                {{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-600">
                                @if($row->total_count > 0)
                                    <div class="flex items-center space-x-2">
                                        <div class="w-16 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-[#006240] h-full rounded-full" style="width: {{ ($row->filled_count / $row->total_count) * 100 }}%"></div>
                                        </div>
                                        <span class="text-[10px] text-slate-400 font-bold">{{ $row->filled_count }}/{{ $row->total_count }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-350">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-block px-2 py-0.5 rounded-full font-bold text-[9px]
                                    {{ $row->status === 'Selesai' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($row->status === 'Sedang' ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'bg-slate-50 text-slate-500 border border-slate-100') }}">
                                    {{ $row->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($row->status === 'Selesai')
                                    <a href="{{ route('reviewer.assessments.summary', $row->form_id ?? 1) }}" 
                                       class="text-xs font-bold text-[#006240] hover:underline">Lihat Ringkasan</a>
                                @else
                                    <a href="{{ route('reviewer.assessments.form', $row->id) }}" 
                                       class="px-3.5 py-1.5 bg-[#006240] hover:bg-[#004d32] text-white font-bold rounded-xl transition-all shadow-xs hover:shadow-md text-[10px]">
                                        {{ $row->status === 'Sedang' ? 'Lanjutkan' : 'Mulai Nilai' }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400 italic">Tidak ada tugas penilaian yang tersedia.</td>
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
