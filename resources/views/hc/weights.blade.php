<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Bobot Penilaian – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

{{-- ─── Sidebar ────────────────────────────────────────── --}}
<x-sidebar :active="'weights'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Bobot Penilaian</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Toast Alert --}}
    @if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-emerald-600 text-white px-5 py-3.5 rounded-xl shadow-lg text-sm font-semibold">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="ml-2 hover:opacity-85 text-white/80 transition-opacity">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    {{-- Main Container --}}
    <main class="flex-1 p-8 max-w-2xl w-full mx-auto space-y-6"
         x-data="{
             inputs: {
                 @foreach($indicators as $ind)
                     '{{ $ind->id }}': {{ $ind->bobot ?? 0 }},
                 @endforeach
             },
             get totalSum() {
                 return Object.values(this.inputs).reduce((sum, val) => sum + (parseInt(val) || 0), 0);
             }
         }">

        {{-- Hero Header --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Atur Bobot Penilaian</h1>
            <p class="text-sm text-slate-400 mt-0.5">Tentukan persentase kontribusi masing-masing nilai AKHLAK terhadap skor final kualifikasi karyawan.</p>
        </div>

        {{-- Server Error Alert --}}
        @error('weights')
        <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl text-rose-800 text-xs font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span>{{ $message }}</span>
        </div>
        @enderror

        {{-- Weight Config Card --}}
        <form method="POST" action="{{ route('hc.weights.store') }}" class="space-y-6">
            @csrf
            
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Bobot Kriteria Evaluasi</h2>
                    
                    {{-- Total Sum Badge --}}
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400 font-semibold">Total Bobot:</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold"
                              :class="totalSum === 100 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'">
                            <span x-text="totalSum + '%'"></span>
                        </span>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    @foreach($indicators as $ind)
                    <div class="flex items-center justify-between border-b border-slate-50 pb-3 last:border-b-0 last:pb-0">
                        <div class="min-w-0 pr-6">
                            <p class="text-xs font-bold text-slate-800">{{ $ind->core_value_nama }}</p>
                            <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ $ind->deskripsi }}</p>
                        </div>
                        
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <input type="number" 
                                   name="weights[{{ $ind->id }}]" 
                                   x-model.number="inputs['{{ $ind->id }}']" 
                                   min="0" max="100" required 
                                   class="w-20 px-3 py-2 text-center text-xs font-extrabold border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                            <span class="text-xs text-slate-400 font-bold">%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Live warning check --}}
            <div x-show="totalSum !== 100" x-cloak
                 class="p-4 bg-amber-50 border border-amber-100 rounded-2xl text-amber-800 text-xs font-semibold flex items-center gap-2 transition-all">
                <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>Akumulasi bobot harus bernilai 100%. Saat ini total adalah <span class="font-extrabold" x-text="totalSum + '%'"></span>. Silakan koreksi nilai bobot.</span>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="/hc/dashboard"
                   class="px-5 py-2.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition-all shadow-sm active:scale-95">
                    Batal
                </a>
                <button type="submit" 
                        ::disabled="totalSum !== 100"
                        :class="totalSum === 100 ? 'bg-[#006240] hover:bg-[#004d31]' : 'bg-slate-300 cursor-not-allowed'"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-xs font-bold rounded-xl shadow-md transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Simpan Bobot</span>
                </button>
            </div>

        </form>

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
