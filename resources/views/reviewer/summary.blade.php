<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Ringkasan Penilaian – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

<x-sidebar :active="'assessments'"/>

<div class="ml-60 flex-1 flex flex-col min-h-screen">
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <div class="flex items-center space-x-2">
            <a href="{{ route('reviewer.assessments.index') }}" class="text-slate-400 hover:text-slate-655 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <span class="text-base font-bold text-[#006240]">PerformancePro</span>
        </div>
    </header>

    <main class="flex-1 p-8 max-w-3xl w-full mx-auto space-y-6">
        
        {{-- Stepper Progress Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Stepper box --}}
            <div class="md:col-span-2 bg-white border border-slate-150 rounded-2xl p-6 shadow-xs flex items-center justify-center">
                <div class="flex items-center w-full max-w-lg justify-between relative">
                    <!-- Background Connecting Line -->
                    <div class="absolute top-5 left-0 right-0 h-0.5 bg-slate-100 -z-0"></div>
                    <!-- Active Connecting Line (Full Green) -->
                    <div class="absolute top-5 left-0 w-full h-0.5 bg-[#006240] -z-0"></div>
                    
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold bg-[#e6f4ea] text-[#137333]">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-[10px] font-bold mt-2 text-slate-400">Persiapan</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold bg-[#e6f4ea] text-[#137333]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-[10px] font-bold mt-2 text-slate-400">Input Skor</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold bg-[#e6f4ea] text-[#137333]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-[10px] font-bold mt-2 text-slate-400">Review</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold bg-[#006240] text-white ring-4 ring-[#e6f4ea]">
                            <span>4</span>
                        </div>
                        <span class="text-[10px] font-bold mt-2 text-[#006240]">Submit</span>
                    </div>
                </div>
            </div>

            {{-- Progress box --}}
            <div class="bg-white border border-slate-150 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Progres</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tahap 4 dari 4</span>
                </div>
                <div class="my-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-slate-800 tracking-tight">100%</span>
                    <span class="text-xs font-bold text-slate-400">Selesai</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-[#006240] w-full h-full rounded-full"></div>
                </div>
            </div>
        </div>
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-800 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile card -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm space-y-4">
            <div class="flex justify-between items-start">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Laporan Hasil Evaluasi</span>
                    <h1 class="text-lg font-bold text-slate-900">{{ $form->ratee_nama }}</h1>
                    <p class="text-xs text-slate-500 font-semibold">{{ $form->ratee_jabatan }} • {{ $form->nama_program }}</p>
                </div>
                <div class="text-center bg-[#006240]/10 border border-[#006240]/20 px-4 py-2.5 rounded-2xl">
                    <p class="text-[10px] font-bold text-[#006240] uppercase tracking-wider">Nilai Rata-rata</p>
                    <p class="text-2xl font-black text-[#006240] mt-0.5">{{ $nilaiAkhir }}</p>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Detail Skor Per Indikator Budaya</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($details as $d)
                <div class="p-6 space-y-2.5">
                    <div class="flex justify-between items-start">
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <span class="text-[9px] font-bold text-[#006240] bg-[#006240]/5 px-1.5 py-0.5 rounded">{{ $d->cv_kode }}</span>
                                <h3 class="text-xs font-bold text-slate-800">{{ $d->nama_indikator }}</h3>
                            </div>
                            <p class="text-[10px] text-slate-400">Core value: {{ $d->cv_nama }} (Bobot: {{ $d->bobot }}%)</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center font-bold text-xs text-slate-700">
                            {{ $d->score }}
                        </div>
                    </div>
                    @if($d->comment)
                    <div class="bg-slate-50 border border-slate-100/50 p-3 rounded-xl">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Catatan Perilaku</p>
                        <p class="text-xs text-slate-600 mt-1 italic font-medium">"{{ $d->comment }}"</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end">
            <a href="{{ route('reviewer.assessments.index') }}" 
               class="px-5 py-2 bg-[#006240] hover:bg-[#004d32] text-white font-bold rounded-xl transition-all shadow-sm hover:shadow text-xs">
                Kembali ke Daftar Tugas
            </a>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2026 PerformancePro Inc.</p>
    </footer>
</div>
</body>
</html>
