<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Kelola Indikator & Bobot – PerformancePro</title>
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
<x-sidebar :active="'indicators'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Indikator & Bobot</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Toast Notification --}}
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
    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6 flex flex-col justify-between">

        <div class="space-y-6">
            {{-- Hero Header --}}
            <div class="space-y-1">
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Indikator & Bobot</h1>
                <p class="text-sm text-slate-400 max-w-2xl leading-relaxed">
                    Tentukan persentase bobot untuk setiap nilai inti (Core Values) perusahaan. Total keseluruhan bobot harus mencapai tepat 100% sebelum dapat disimpan.
                </p>
            </div>

            {{-- Dynamic Form using Alpine.js --}}
            <form id="weightForm" method="POST" action="{{ route('indicators.update') }}"
                  x-data="{
                      weights: {
                          amanah: {{ $weights['amanah']['weight'] ?? 20 }},
                          kompeten: {{ $weights['kompeten']['weight'] ?? 20 }},
                          harmonis: {{ $weights['harmonis']['weight'] ?? 15 }},
                          loyal: {{ $weights['loyal']['weight'] ?? 15 }},
                          adaptif: {{ $weights['adaptif']['weight'] ?? 15 }},
                          kolaboratif: {{ $weights['kolaboratif']['weight'] ?? 15 }}
                      },
                      get total() {
                          return Object.values(this.weights).reduce((sum, val) => sum + (parseInt(val) || 0), 0);
                      },
                      get isValid() {
                          return this.total === 100;
                      }
                  }" class="space-y-6">
                @csrf

                {{-- Card Grid (3x2) --}}
                <div class="grid grid-cols-3 gap-6">

                    {{-- Amanah --}}
                    <div class="hover-card bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 border border-emerald-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-sm font-bold text-slate-800">Amanah</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    Memegang teguh kepercayaan diberikan oleh perusahaan.
                                </p>
                            </div>
                        </div>
                        <div class="border-t border-slate-50 pt-3 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500">Bobot Nilai</span>
                            <div class="flex items-center gap-1.5">
                                <input type="number" 
                                       name="weights[amanah]" 
                                       x-model.number="weights.amanah"
                                       min="0" max="100"
                                       class="w-14 text-center px-1.5 py-1 text-xs font-bold border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                                <span class="text-xs font-semibold text-slate-400">%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Kompeten --}}
                    <div class="hover-card bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center flex-shrink-0 border border-teal-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.263 8.545a.75.75 0 000 1.41l8 3.556a.75.75 0 00.674 0l8-3.556a.75.75 0 000-1.41l-8-3.556a.75.75 0 00-.674 0l-8 3.556zM4.263 8.545L12 12.5M12 12.5v6.5m0-6.5L19.737 8.545M12 19v-6.5m0 6.5a4.5 4.5 0 004.5-4.5V9m-9 5.5A4.5 4.5 0 0012 19"/>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-sm font-bold text-slate-800">Kompeten</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    Terus belajar dan mengembangkan kapabilitas diri.
                                </p>
                            </div>
                        </div>
                        <div class="border-t border-slate-50 pt-3 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500">Bobot Nilai</span>
                            <div class="flex items-center gap-1.5">
                                <input type="number" 
                                       name="weights[kompeten]" 
                                       x-model.number="weights.kompeten"
                                       min="0" max="100"
                                       class="w-14 text-center px-1.5 py-1 text-xs font-bold border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                                <span class="text-xs font-semibold text-slate-400">%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Harmonis --}}
                    <div class="hover-card bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0 border border-sky-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-sm font-bold text-slate-800">Harmonis</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    Saling peduli dan menghargai perbedaan lingkungan.
                                </p>
                            </div>
                        </div>
                        <div class="border-t border-slate-50 pt-3 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500">Bobot Nilai</span>
                            <div class="flex items-center gap-1.5">
                                <input type="number" 
                                       name="weights[harmonis]" 
                                       x-model.number="weights.harmonis"
                                       min="0" max="100"
                                       class="w-14 text-center px-1.5 py-1 text-xs font-bold border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                                <span class="text-xs font-semibold text-slate-400">%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Loyal --}}
                    <div class="hover-card bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 border border-blue-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12z"/>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-sm font-bold text-slate-800">Loyal</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    Berdedikasi dan mengutamakan kepentingan institusi.
                                </p>
                            </div>
                        </div>
                        <div class="border-t border-slate-50 pt-3 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500">Bobot Nilai</span>
                            <div class="flex items-center gap-1.5">
                                <input type="number" 
                                       name="weights[loyal]" 
                                       x-model.number="weights.loyal"
                                       min="0" max="100"
                                       class="w-14 text-center px-1.5 py-1 text-xs font-bold border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                                <span class="text-xs font-semibold text-slate-400">%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Adaptif --}}
                    <div class="hover-card bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0 border border-indigo-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-sm font-bold text-slate-800">Adaptif</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    Terus berinovasi dan antusias menghadapi perubahan.
                                </p>
                            </div>
                        </div>
                        <div class="border-t border-slate-50 pt-3 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500">Bobot Nilai</span>
                            <div class="flex items-center gap-1.5">
                                <input type="number" 
                                       name="weights[adaptif]" 
                                       x-model.number="weights.adaptif"
                                       min="0" max="100"
                                       class="w-14 text-center px-1.5 py-1 text-xs font-bold border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                                <span class="text-xs font-semibold text-slate-400">%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Kolaboratif --}}
                    <div class="hover-card bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center flex-shrink-0 border border-violet-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75m0-9.75a3 3 0 110 6 3 3 0 010-6z"/>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-sm font-bold text-slate-800">Kolaboratif</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    Membangun kerja sama yang sinergis dan produktif.
                                </p>
                            </div>
                        </div>
                        <div class="border-t border-slate-50 pt-3 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500">Bobot Nilai</span>
                            <div class="flex items-center gap-1.5">
                                <input type="number" 
                                       name="weights[kolaboratif]" 
                                       x-model.number="weights.kolaboratif"
                                       min="0" max="100"
                                       class="w-14 text-center px-1.5 py-1 text-xs font-bold border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                                <span class="text-xs font-semibold text-slate-400">%</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Bottom Summary Bar (Dynamic calculated) --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex items-center justify-between mt-6">
                    <div class="space-y-2 flex-1 max-w-lg">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Bobot Keseluruhan</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold tracking-tight transition-colors duration-200" 
                                  :class="isValid ? 'text-[#006240]' : 'text-rose-500'" 
                                  x-text="total">100</span>
                            <span class="text-sm font-bold text-slate-400">/ 100%</span>
                        </div>
                        
                        {{-- Live Progress Bar --}}
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden w-full">
                            <div class="h-full rounded-full transition-all duration-300"
                                 :class="isValid ? 'bg-[#006240]' : 'bg-rose-500'"
                                 :style="'width: ' + Math.min(total, 100) + '%'"></div>
                        </div>
                        
                        {{-- Warning Text when total != 100% --}}
                        <span x-show="total !== 100" x-cloak
                              class="text-[11px] font-medium text-rose-500 block">
                            * Total bobot nilai saat ini adalah <strong x-text="total + '%'"></strong>. Total bobot harus tepat 100% sebelum dapat disimpan.
                        </span>
                    </div>

                    {{-- Save Button --}}
                    <button type="submit" 
                            :disabled="!isValid"
                            :class="isValid ? 'bg-[#006240] hover:bg-[#004d31] cursor-pointer' : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                            class="flex items-center gap-2 px-6 py-3.5 text-white text-xs font-bold rounded-xl shadow-md transition-all active:scale-95 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        <span>Simpan Konfigurasi</span>
                    </button>
                </div>

            </form>
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
