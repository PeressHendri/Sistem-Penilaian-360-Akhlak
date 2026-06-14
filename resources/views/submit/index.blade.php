<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Submit Penilaian – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        h1, h2, h3, h4, .brand-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9px;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex min-h-screen text-slate-800">

{{-- Sidebar --}}
<x-sidebar :active="'submit'"/>

{{-- Main Content --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
         agreed: false,
         showDotsDropdown: false
     }">

    {{-- Header --}}
    <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="brand-font text-lg font-bold text-[#006847] tracking-tight">PerformancePro</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-[#d93838] rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Main Container --}}
    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6">

        {{-- Page Title Header --}}
        <div class="flex items-start justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Periode Penilaian: Q3 2023</span>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Submit Penilaian</h1>
            </div>
            
            {{-- Dropdown / Action section --}}
            <div class="flex items-center gap-2 relative">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 border border-slate-200/60 text-slate-500 rounded-lg text-xs font-semibold shadow-xs select-none">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                    <span>Draft Tersimpan</span>
                </span>
                
                <button @click="showDotsDropdown = !showDotsDropdown" 
                        @click.outside="showDotsDropdown = false"
                        class="p-2 border border-slate-200 hover:bg-slate-50 rounded-lg transition-all text-slate-400 hover:text-slate-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/>
                    </svg>
                </button>

                <div x-show="showDotsDropdown" x-cloak
                     class="absolute top-10 right-0 w-36 bg-white border border-slate-100 rounded-lg shadow-md z-30 py-1 text-xs">
                     <a href="/scores" class="flex items-center gap-2 px-3.5 py-2 hover:bg-slate-50 text-slate-600">
                        Edit Penilaian
                    </a>
                </div>
            </div>
        </div>

        {{-- Split grid layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            {{-- Left column (Main details) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Profile Card Budi Santoso --}}
                <div class="bg-white rounded-xl border border-slate-200/80 p-6 shadow-xs space-y-5">
                    <div class="flex items-center gap-4">
                        <img src="{{ $ratee->avatar_url ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=150' }}" 
                             alt="{{ $ratee->nama }}" 
                             class="w-16 h-16 rounded-full object-cover border-2 border-slate-100 select-none"/>
                        
                        <div class="space-y-1 flex-1">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-bold text-slate-800 leading-tight">{{ $ratee->nama }}</h2>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#006847] text-white">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                    <span>Siap Disubmit</span>
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 font-semibold">{{ $ratee->jabatan }} &bull; {{ $ratee->divisi }}</p>
                        </div>
                    </div>

                    {{-- Metadata info boxes --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 border-t border-slate-100 pt-4 text-xs select-none">
                        <div class="border border-slate-200/80 rounded-lg p-3 bg-[#f8fafc]">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">ID Karyawan</span>
                            <span class="font-bold text-slate-700 mt-1 block">{{ $ratee->nik }}</span>
                        </div>
                        <div class="border border-slate-200/80 rounded-lg p-3 bg-[#f8fafc]">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Masa Kerja</span>
                            <span class="font-bold text-slate-700 mt-1 block">{{ $ratee->masa_kerja }}</span>
                        </div>
                        <div class="border border-slate-200/80 rounded-lg p-3 bg-[#f8fafc]">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Penilai Utama</span>
                            <span class="font-bold text-slate-700 mt-1 block truncate" title="{{ $ratee->penilai_utama }}">
                                {{ $ratee->penilai_utama }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Row of Charts --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- 1. Skor Akhir --}}
                    <div class="bg-white rounded-xl border border-slate-200/80 p-6 shadow-xs flex flex-col justify-between items-center text-center space-y-4">
                        <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider self-start select-none">Skor Akhir Penilaian</span>
                        
                        <div class="relative flex items-center justify-center">
                            {{-- Circular Progress SVG --}}
                            <svg viewBox="0 0 100 100" class="w-32 h-32 transform -rotate-90">
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#f1f5f9" stroke-width="7"/>
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#006847" stroke-width="7"
                                        stroke-dasharray="251.3" stroke-dashoffset="37.7" stroke-linecap="round"/>
                            </svg>
                            <div class="absolute flex flex-col items-center justify-center">
                                <span class="text-3xl font-extrabold text-slate-800 leading-none">85</span>
                                <span class="text-[10px] font-bold text-slate-400 mt-1">/ 100</span>
                            </div>
                        </div>

                        <span class="inline-block px-3 py-1 bg-emerald-50 text-[#006847] text-[10px] font-bold rounded-lg border border-emerald-100 select-none">
                            Kategori: {{ $ratee->kategori }}
                        </span>
                    </div>

                    {{-- 2. Profil Kompetensi --}}
                    <div class="bg-white rounded-xl border border-slate-200/80 p-6 shadow-xs flex flex-col justify-between items-center text-center space-y-4">
                        <div class="flex items-center justify-between w-full select-none">
                            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Profil Kompetensi</span>
                            <button class="p-1 rounded hover:bg-slate-50 text-slate-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75v4.5m0-4.5h-4.5m4.5 0L15 9m5.25 11.25v-4.5m0 4.5h-4.5m4.5 0L15 15"/>
                                </svg>
                            </button>
                        </div>
                        
                        {{-- Dotted Placeholder Container --}}
                        <div class="w-full flex-1 flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-lg p-4 bg-[#f8fafc]/50 min-h-[140px]">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21V9.75M20.716 14.253a8.99 8.99 0 01-3.66 4.93m3.66-4.93a8.99 8.99 0 00-1.84-5.32m-13.876 10.25a8.99 8.99 0 003.66 4.93m-3.66-4.93a8.99 8.99 0 011.84-5.32M17.056 9.324a8.99 8.99 0 00-5.056-5.574m0 0a8.99 8.99 0 00-5.056 5.574M12 3.75v6M12 9.75h.008v.008H12V9.75z"/>
                                </svg>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-400">Grafik Radar Kompetensi akan dimuat di sini</span>
                        </div>
                    </div>

                </div>

                {{-- Qualitative reports card --}}
                <div class="bg-white rounded-xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider select-none">Catatan Evaluasi Kualitatif</h3>
                    
                    <div class="space-y-4">
                        {{-- Kekuatan --}}
                        <div class="p-4 bg-[#f0f8f5] border border-emerald-500/10 rounded-lg space-y-2">
                            <div class="flex items-center gap-2 text-xs font-bold text-[#006847]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.896 0 1.7-.393 2.285-1.024m0 0C9.8 8.414 10.5 7.5 10.5 6.5C10.5 5.25 9.5 4 8.5 4c-.878 0-1.472.585-2.072 1.348L5 7v11h2c1.233 0 2.223-.787 2.646-1.859l1.107-2.769A3 3 0 009.953 11.75H8.25m-.957-1.5H6.633m0 0h-.386M2 7h2v11H2V7z"/>
                                </svg>
                                <span>Kekuatan Utama</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $ratee->kekuatan }}</p>
                        </div>
                        
                        {{-- Pengembangan --}}
                        <div class="p-4 bg-[#fcf2f2] border border-rose-500/10 rounded-lg space-y-2">
                            <div class="flex items-center gap-2 text-xs font-bold text-rose-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.518l2.74-1.22m0 0l-5.94-2.281m5.94 2.28l-2.28 5.941"/>
                                </svg>
                                <span>Area Pengembangan</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $ratee->pengembangan }}</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right column (Checklist Box) --}}
            <div class="space-y-6">
                
                <form method="POST" action="{{ route('submit.store') }}">
                    @csrf
                    
                    <div class="bg-white rounded-xl border border-slate-200/80 p-6 shadow-xs space-y-6">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Checklist Kelengkapan</h3>
                            <p class="text-xs text-slate-400 mt-1">Pastikan semua bagian formulir telah diisi sebelum melakukan submission akhir.</p>
                        </div>

                        {{-- Checklist items list --}}
                        <div class="space-y-4">
                            
                            {{-- Item 1 --}}
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-md bg-[#006847] text-white flex items-center justify-center mt-0.5 flex-shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                </div>
                                <div class="select-none">
                                    <span class="text-xs font-bold text-slate-800 block">Penilaian KPI Target</span>
                                    <span class="text-[10px] text-slate-400 block mt-0.5">4 dari 4 target dinilai</span>
                                </div>
                            </div>
                            
                            {{-- Item 2 --}}
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-md bg-[#006847] text-white flex items-center justify-center mt-0.5 flex-shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                </div>
                                <div class="select-none">
                                    <span class="text-xs font-bold text-slate-800 block">Evaluasi Kompetensi Inti</span>
                                    <span class="text-[10px] text-slate-400 block mt-0.5">6 dari 6 kompetensi dinilai</span>
                                </div>
                            </div>
                            
                            {{-- Item 3 --}}
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-md bg-[#006847] text-white flex items-center justify-center mt-0.5 flex-shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                </div>
                                <div class="select-none">
                                    <span class="text-xs font-bold text-slate-800 block">Catatan Kualitatif</span>
                                    <span class="text-[10px] text-slate-400 block mt-0.5">Kekuatan & Area Pengembangan terisi</span>
                                </div>
                            </div>

                            <hr class="border-slate-100 my-2"/>
                            
                            {{-- Item 4 --}}
                            <div class="flex items-start gap-3 pt-1">
                                <input type="checkbox" 
                                       name="agree" 
                                       id="agreeCheckbox" 
                                       x-model="agreed"
                                       class="w-5 h-5 rounded border-slate-300 text-[#006847] focus:ring-[#006847]/20 mt-0.5 cursor-pointer"/>
                                <label for="agreeCheckbox" class="cursor-pointer select-none">
                                    <span class="text-xs font-bold text-slate-800 block">Persetujuan Penilai</span>
                                    <span class="text-[10px] text-slate-400 block mt-0.5 leading-tight">Saya menyatakan penilaian ini objektif.</span>
                                </label>
                            </div>
                        </div>

                        {{-- Action buttons --}}
                        <div class="space-y-3 pt-2">
                            <button type="submit" 
                                    :disabled="!agreed"
                                    :class="agreed ? 'bg-[#006847] hover:bg-[#005036] cursor-pointer' : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                                    class="w-full inline-flex items-center justify-center gap-2 py-3 text-white text-xs font-bold rounded-lg shadow-xs transition-all active:scale-98">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                                </svg>
                                <span>Submit Penilaian</span>
                            </button>
                            
                            <a href="/scores" 
                               class="w-full text-center inline-flex items-center justify-center gap-2 py-2.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg shadow-xs transition-all">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                </svg>
                                <span>Kembali Edit</span>
                            </a>
                        </div>

                        {{-- Alert box --}}
                        <div class="p-3.5 bg-rose-50 border border-rose-100 rounded-lg flex gap-2">
                            <svg class="w-4.5 h-4.5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                            <span class="text-[10px] font-semibold text-rose-700 leading-relaxed">
                                Setelah disubmit, penilaian tidak dapat diubah lagi tanpa persetujuan HR.
                            </span>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-100 px-8 py-3.5 flex items-center justify-between mt-auto">
        <p class="text-[11px] text-slate-400">© 2026 PerformancePro Inc.</p>
        <div class="flex gap-4">
            <a href="#" class="text-[11px] text-slate-400 hover:text-[#006847]">Privacy Policy</a>
            <a href="#" class="text-[11px] text-slate-400 hover:text-[#006847]">Terms of Service</a>
        </div>
    </footer>

</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
