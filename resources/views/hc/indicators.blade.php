<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Indikator AKHLAK – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }
        .hover-card { transition: box-shadow .2s, transform .2s; }
        .hover-card:hover { box-shadow: 0 10px 30px rgba(0,0,0,.04); transform: translateY(-2px); }
        .font-serif { font-family: 'Playfair Display', Georgia, serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

{{-- ─── Sidebar ────────────────────────────────────────── --}}
<x-sidebar :active="'indicators'"/>

<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
         showEditModal: false,
         indicators: {{ json_encode($indicators) }},
         activeIndicator: { id: null, nama_indikator: '', deskripsi: '' },
         
         get totalBobot() {
             return this.indicators.reduce((sum, ind) => sum + parseInt(ind.bobot || 0), 0);
         },
         
         openEdit(ind) {
             this.activeIndicator = this.indicators.find(i => i.id === ind.id);
             this.showEditModal = true;
         }
     }">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-lg font-semibold text-[#006240] font-serif">PerformancePro</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Toast Alert Success --}}
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

    {{-- Toast Alert Error --}}
    @if(session('error'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-rose-600 text-white px-5 py-3.5 rounded-xl shadow-lg text-sm font-semibold">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
        </svg>
        <span>{{ session('error') }}</span>
        <button @click="show = false" class="ml-2 hover:opacity-85 text-white/80 transition-opacity">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    {{-- Main Container --}}
    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6">

        {{-- Hero Header --}}
        <div class="space-y-2 mb-8 mt-4">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight font-serif">Kelola Indikator &amp; Bobot</h1>
            <p class="text-xs text-gray-500 max-w-3xl leading-relaxed">
                Tentukan persentase bobot untuk setiap nilai inti (Core Values) perusahaan. Total keseluruhan bobot harus mencapai tepat 100% sebelum dapat disimpan.
            </p>
        </div>

        <form method="POST" action="{{ route('hc.indicators.update') }}" class="space-y-6">
            @csrf
            
            {{-- Indicators Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <template x-for="(ind, index) in indicators" :key="ind.id">
                    <div class="hover-card bg-white border border-gray-200/80 p-6 rounded-2xl flex flex-col justify-between space-y-5">
                        <div class="space-y-3.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center border font-bold text-xs"
                                         :class="ind.nama_indikator === 'Amanah' || ind.nama_indikator === 'Loyal' ? 'bg-[#e6f4ea] text-[#006240] border-emerald-100' :
                                                 (ind.nama_indikator === 'Kompeten' || ind.nama_indikator === 'Adaptif' ? 'bg-[#e8f0fe] text-[#1a73e8] border-blue-100' :
                                                 'bg-[#e4f7fb] text-[#007b83] border-sky-100')">
                                         
                                         <template x-if="ind.nama_indikator === 'Amanah'">
                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M14.12 12.58a2 2 0 01-2.828 0L9.17 10.46a2 2 0 010-2.828l3-3a2 2 0 012.828 0l2.12 2.12a2 2 0 010 2.828l-3 3z" />
                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M10.46 9.17l-3-3a2 2 0 00-2.828 0L2.51 8.29a2 2 0 000 2.828l3.18 3.18a2 2 0 002.828 0l2-2" />
                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M15.54 14.83l3 3a2 2 0 002.828 0l2.12-2.12a2 2 0 000-2.828l-3.18-3.18a2 2 0 00-2.828 0l-2 2" />
                                             </svg>
                                         </template>
                                         <template x-if="ind.nama_indikator === 'Kompeten'">
                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.9c2.785 0 5.422-.474 7.875-1.339.117-.04.244-.07.365-.113v-3.3m-16 0A12.3 12.3 0 0012 16.5c2.785 0 5.412-.474 7.865-1.333M12 3v13.5m0-13.5L3.75 8.25 12 12l8.25-3.75L12 3z"/>
                                             </svg>
                                         </template>
                                         <template x-if="ind.nama_indikator === 'Harmonis'">
                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                             </svg>
                                         </template>
                                         <template x-if="ind.nama_indikator === 'Loyal'">
                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.195-.558 1.04-.558 1.235 0l2.613 7.48a.75.75 0 00.713.52h7.864c.59 0 .837.761.359 1.107l-6.36 4.619a.75.75 0 00-.272.836l2.613 7.48c.195.558-.466 1.037-.945.69l-6.36-4.618a.75.75 0 00-.895 0l-6.36 4.618c-.479.347-1.14-.132-.945-.69l2.613-7.48a.75.75 0 00-.272-.836l-6.36-4.619c-.478-.346-.231-1.107.359-1.107h7.864a.75.75 0 00.713-.52l2.613-7.48z" />
                                             </svg>
                                         </template>
                                         <template x-if="ind.nama_indikator === 'Adaptif'">
                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                             </svg>
                                         </template>
                                         <template x-if="ind.nama_indikator === 'Kolaboratif'">
                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 8a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm4.5 4.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-4.5 4.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                             </svg>
                                         </template>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-800 font-serif" x-text="ind.nama_indikator"></h3>
                                </div>
                                
                                <button type="button" @click="openEdit(ind)" class="text-slate-400 hover:text-[#006240] p-1.5 rounded-lg hover:bg-slate-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                </button>
                            </div>
                            
                            <p class="text-xs text-gray-550 leading-relaxed font-medium min-h-[48px]" x-text="ind.deskripsi"></p>
                        </div>
                        
                        {{-- Form fields inputs --}}
                        <input type="hidden" :name="'indicators[' + ind.id + '][deskripsi]'" :value="ind.deskripsi">
                        
                        <div class="flex items-center justify-between pt-3.5 border-t border-gray-100">
                            <span class="text-xs text-gray-500 font-medium">Bobot Nilai</span>
                            <div class="flex items-center border border-gray-200 rounded-lg bg-gray-50/20 px-3 py-1.5 gap-1.5 focus-within:ring-2 focus-within:ring-[#006240]/10 focus-within:border-[#006240] transition-all">
                                <input type="number" :name="'indicators[' + ind.id + '][bobot]'" x-model.number="ind.bobot" required min="0" max="100"
                                       class="w-8 text-center bg-transparent border-none p-0 focus:outline-none focus:ring-0 text-sm font-semibold text-gray-800 [-moz-appearance:_textfield] [&::-webkit-outer-spin-button]:margin-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:margin-0 [&::-webkit-inner-spin-button]:appearance-none"/>
                                <span class="text-xs text-gray-400 font-medium">%</span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Bottom Sum & Save Banner --}}
            <div class="relative overflow-hidden bg-white border border-gray-200 rounded-2xl p-6 shadow-xs flex flex-col justify-between min-h-[110px] pb-8">
                <div class="flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider block">Total Bobot Keseluruhan</span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-4xl font-extrabold tracking-tight" :class="totalBobot === 100 ? 'text-[#006240]' : 'text-rose-600'" x-text="totalBobot"></span>
                            <span class="text-base font-semibold text-gray-400">/ 100%</span>
                        </div>
                    </div>
                    
                    <button type="submit" :disabled="totalBobot !== 100"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-lg text-white text-xs font-bold transition-all shadow-xs"
                            :class="totalBobot === 100 ? 'bg-[#006240] hover:bg-[#004d31] active:scale-95 cursor-pointer' : 'bg-gray-300 cursor-not-allowed'">
                        <!-- Floppy disk icon -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V8l-4-4H8m4 16v-6a1 1 0 00-1-1H9a1 1 0 00-1 1v6m8-16v4h-6V4" />
                        </svg>
                        <span>Simpan Konfigurasi</span>
                    </button>
                </div>
                
                <!-- Alert Message (if not 100%) -->
                <div class="text-[11px] font-semibold text-rose-500 mt-2" x-show="totalBobot !== 100" x-cloak>
                    Peringatan: Total bobot harus bernilai tepat 100% agar dapat disimpan.
                </div>
                
                <!-- Full-Width Progress Bar at the very bottom -->
                <div class="absolute bottom-0 left-0 right-0 h-2 bg-gray-100">
                    <div class="h-full transition-all duration-300"
                         :class="totalBobot === 100 ? 'bg-[#006240]' : 'bg-rose-500'"
                         :style="'width: ' + Math.min(totalBobot, 100) + '%'"></div>
                </div>
            </div>
        </form>

    </main>

    {{-- ─── Modal Edit Deskripsi ────────────────────────── --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showEditModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-2xl border border-slate-150 shadow-xl max-w-sm w-full overflow-hidden flex flex-col"
             @click.outside="showEditModal = false">
            
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800">Edit Deskripsi Indikator</h3>
                <button @click="showEditModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="p-5 space-y-4 text-xs">
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Indikator</label>
                    <p class="text-sm font-extrabold text-slate-800" x-text="activeIndicator.nama_indikator"></p>
                </div>
                
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Deskripsi Perilaku</label>
                    <textarea x-model="activeIndicator.deskripsi" required rows="4"
                              class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all bg-slate-50/50 focus:bg-white"></textarea>
                </div>
            </div>
            
            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" @click="showEditModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-100 text-xs font-semibold rounded-xl transition-all">
                    Batal
                </button>
                <button type="button" @click="showEditModal = false"
                        class="px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                    Simpan Deskripsi
                </button>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-slate-400">© 2026 PerformancePro Inc.</p>
        <div class="flex gap-4">
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Privacy</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Terms</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Support</a>
        </div>
    </footer>

</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
