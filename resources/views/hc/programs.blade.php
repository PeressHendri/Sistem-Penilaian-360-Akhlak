<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Program Penilaian – PerformancePro</title>
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
<x-sidebar :active="'programs'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
         search: '',
         statusFilter: '',
         showAddModal: false,
         showEditModal: false,
         
         editProgram: {
             id: null,
             nama_program: '',
             deskripsi: '',
             tanggal_mulai: '',
             tanggal_selesai: '',
             status: 'Draft'
         },
         
         programs: {{ json_encode($programs) }},
         
         get filteredPrograms() {
             return this.programs.filter(p => {
                 const matchesSearch = p.nama_program.toLowerCase().includes(this.search.toLowerCase()) || 
                                       (p.deskripsi && p.deskripsi.toLowerCase().includes(this.search.toLowerCase()));
                 const matchesStatus = this.statusFilter === '' || p.status === this.statusFilter;
                 return matchesSearch && matchesStatus;
             });
         },
         
         openEdit(prog) {
             this.editProgram = { ...prog };
             this.showEditModal = true;
         }
     }">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Program Penilaian</span>
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
    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6">

        {{-- Hero Header --}}
        <div class="flex items-start justify-between">
            <div class="space-y-1">
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Program Penilaian</h1>
                <p class="text-sm text-slate-400 max-w-2xl leading-relaxed">
                    Daftar siklus evaluasi kinerja karyawan. Atur periode aktif dan masa penginputan kuesioner.
                </p>
            </div>
            
            <button @click="showAddModal = true"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-xs font-semibold text-white rounded-xl shadow-sm transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span>Program Baru</span>
            </button>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm">
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Total Program</span>
                <span class="text-2xl font-extrabold text-slate-800 mt-1 block" x-text="programs.length">0</span>
            </div>
            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm">
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Program Aktif</span>
                <span class="text-2xl font-extrabold text-emerald-600 mt-1 block" x-text="programs.filter(p => p.status === 'Aktif').length">0</span>
            </div>
            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm">
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Siklus Selesai</span>
                <span class="text-2xl font-extrabold text-slate-500 mt-1 block" x-text="programs.filter(p => p.status === 'Selesai').length">0</span>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="p-4 bg-white border border-slate-100 rounded-2xl shadow-xs flex items-center justify-between gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </div>
                <input type="text" 
                       x-model="search"
                       placeholder="Cari nama program..." 
                       class="w-full pl-9 pr-4 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
            </div>
            
            <div class="flex items-center gap-2">
                <select x-model="statusFilter"
                        class="px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 transition-all font-semibold text-slate-600">
                    <option value="">Semua Status</option>
                    <option value="Draft">Draft</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Selesai">Selesai</option>
                </select>
                <button @click="search = ''; statusFilter = ''" 
                        class="p-2 border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-400 hover:text-slate-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Programs Grid --}}
        <div class="grid grid-cols-2 gap-6">
            <template x-for="prog in filteredPrograms" :key="prog.id">
                <div class="hover-card bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex flex-col justify-between space-y-4 relative">
                    
                    {{-- Status Badge --}}
                    <span class="absolute top-4 right-4 inline-block px-2 py-0.5 rounded-full text-[9px] font-bold" 
                          :class="prog.status === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : (prog.status === 'Selesai' ? 'bg-slate-50 text-slate-500 border border-slate-100' : 'bg-amber-50 text-amber-600 border border-amber-100')">
                        <span class="inline-block w-1 h-1 rounded-full mr-1" :class="prog.status === 'Aktif' ? 'bg-emerald-500' : (prog.status === 'Selesai' ? 'bg-slate-400' : 'bg-amber-500')"></span>
                        <span x-text="prog.status"></span>
                    </span>

                    <div class="space-y-2.5">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 truncate pr-16" x-text="prog.nama_program"></h4>
                            <p class="text-[10px] text-slate-400 font-medium mt-1">
                                Periode: <span class="font-bold text-slate-500" x-text="prog.tanggal_mulai"></span> s/d <span class="font-bold text-slate-500" x-text="prog.tanggal_selesai"></span>
                            </p>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed font-medium" x-text="prog.deskripsi || 'Tidak ada deskripsi.'"></p>
                    </div>

                    <div class="border-t border-slate-50 pt-3 flex items-center justify-end">
                        <button @click="openEdit(prog)"
                                class="inline-flex items-center gap-1 px-3 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 rounded-xl text-xs font-bold text-slate-600 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13"/>
                            </svg>
                            <span>Edit Status / Detail</span>
                        </button>
                    </div>

                </div>
            </template>
        </div>

    </main>

    {{-- ─── Modal Tambah Program ────────────────────────── --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showAddModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl max-w-sm w-full overflow-hidden flex flex-col"
             @click.outside="showAddModal = false">
            
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800">Tambah Program Baru</h3>
                <button @click="showAddModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('hc.programs.store') }}">
                @csrf
                <div class="p-5 space-y-4 text-xs">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Program</label>
                        <input type="text" name="nama_program" required placeholder="Contoh: Penilaian Akhir Tahun 2026" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Deskripsi Program</label>
                        <textarea name="deskripsi" placeholder="Deskripsi program evaluasi..." rows="3"
                                  class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" required 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none transition-all"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" required 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none transition-all"/>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Status</label>
                        <select name="status" required 
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all">
                            <option value="Draft">Draft (Persiapan)</option>
                            <option value="Aktif">Aktif (Berlangsung)</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-100 text-xs font-semibold rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                        Simpan Program
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── Modal Edit Program ──────────────────────────── --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showEditModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl max-w-sm w-full overflow-hidden flex flex-col"
             @click.outside="showEditModal = false">
            
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800">Edit Program</h3>
                <button @click="showEditModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" :action="'/hc/programs/' + editProgram.id">
                @csrf
                @method('PUT')
                <div class="p-5 space-y-4 text-xs">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Program</label>
                        <input type="text" name="nama_program" required x-model="editProgram.nama_program" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Deskripsi Program</label>
                        <textarea name="deskripsi" x-model="editProgram.deskripsi" rows="3"
                                  class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" required x-model="editProgram.tanggal_mulai" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none transition-all"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" required x-model="editProgram.tanggal_selesai" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none transition-all"/>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Status</label>
                        <select name="status" required x-model="editProgram.status" 
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all">
                            <option value="Draft">Draft (Persiapan)</option>
                            <option value="Aktif">Aktif (Berlangsung)</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-100 text-xs font-semibold rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
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
