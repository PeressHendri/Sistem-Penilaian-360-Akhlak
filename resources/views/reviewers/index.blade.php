<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Daftar Penilai – PerformancePro</title>
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
<x-sidebar :active="'reviewers'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
         search: '',
         statusFilter: '',
         showModal: false,
         selectedRatee: null,
         notificationSettings: {
             autoSend: true,
             weeklyReminder: true,
             schedule: '08:00 AM WIB'
         },
         ratees: {{ json_encode($demoRatees) }},
         
         get filteredRatees() {
             return this.ratees.filter(r => {
                 const matchesSearch = r.nama.toLowerCase().includes(this.search.toLowerCase()) || 
                                       r.nik.toLowerCase().includes(this.search.toLowerCase()) ||
                                       r.jabatan.toLowerCase().includes(this.search.toLowerCase());
                 const matchesStatus = this.statusFilter === '' || r.status === this.statusFilter;
                 return matchesSearch && matchesStatus;
             });
         },
         
         openLengkapi(ratee) {
             this.selectedRatee = ratee;
             this.showModal = true;
         }
     }">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Daftar Penilai</span>
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
         x-init="setTimeout(() => show = false, 5000)"
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
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Penilai (Ratee - Rater)</h1>
                <p class="text-sm text-slate-400 max-w-2xl leading-relaxed">
                    Kelola daftar karyawan yang akan dinilai dan tetapkan penilai untuk masing-masing.
                </p>
            </div>
            
            {{-- Buttons --}}
            <div class="flex items-center gap-2.5">
                <button class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 rounded-xl bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 shadow-sm transition-all">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                    </svg>
                    <span>Export</span>
                </button>
                <button @click="openLengkapi({nama: 'Karyawan Baru', nik: 'EMP-New', jabatan: 'Staff', divisi: 'Operations', status: 'Incomplete', jumlah_penilai: 0})"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-xs font-semibold text-white rounded-xl shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span>Tambah Data</span>
                </button>
            </div>
        </div>

        {{-- Perhatian Diperlukan Danger Warning Banner --}}
        <div class="bg-rose-50 border border-rose-600/10 rounded-2xl p-5 flex items-start gap-4 shadow-sm">
            <div class="w-9 h-9 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </div>
            <div class="space-y-1.5 flex-1">
                <h4 class="text-sm font-bold text-rose-800">Perhatian Diperlukan</h4>
                <p class="text-xs text-rose-600 leading-relaxed">
                    Terdapat 3 karyawan (Ratee) yang belum memiliki daftar penilai lengkap. Segera lengkapi agar proses penilaian dapat dimulai.
                </p>
                <button @click="statusFilter = 'Incomplete'" 
                        class="text-xs font-semibold text-rose-700 hover:text-rose-900 underline flex items-center gap-1 transition-colors">
                    <span>Lihat Karyawan Incomplete</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Split Layout (Left: Ratee Table, Right: Stats and Notification settings) --}}
        <div class="grid grid-cols-3 gap-6 items-start">
            
            {{-- Left column - Ratee Table --}}
            <div class="col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
                
                {{-- Search & Filter Headers --}}
                <div class="p-4 border-b border-slate-50 flex items-center justify-between gap-4">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               x-model="search"
                               placeholder="Cari nama karyawan..." 
                               class="w-full pl-9 pr-4 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>
                    
                    {{-- Filter reset/status selector --}}
                    <div class="flex items-center gap-2">
                        <select x-model="statusFilter"
                                class="px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 transition-all text-slate-500">
                            <option value="">Semua Status</option>
                            <option value="Ready">Ready</option>
                            <option value="Incomplete">Incomplete</option>
                        </select>
                        <button @click="search = ''; statusFilter = ''" 
                                class="p-2 border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-400 hover:text-slate-600 transition-all"
                                title="Reset Filter">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Table content --}}
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3.5 px-5">Ratee (Yang Dinilai)</th>
                            <th class="py-3.5 px-4">Role / Dept</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Penilai</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-for="ratee in filteredRatees" :key="ratee.id">
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                {{-- Avatar & Name --}}
                                <td class="py-4 px-5 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0" 
                                         :class="ratee.avatar_color" 
                                         x-text="ratee.avatar">
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-slate-800" x-text="ratee.nama"></p>
                                        <p class="text-[10px] text-slate-400" x-text="'ID: ' + ratee.nik"></p>
                                    </div>
                                </td>
                                
                                {{-- Role & Dept --}}
                                <td class="py-4 px-4">
                                    <p class="text-xs font-semibold text-slate-800" x-text="ratee.jabatan"></p>
                                    <p class="text-[10px] text-slate-400" x-text="ratee.divisi"></p>
                                </td>
                                
                                {{-- Jumlah Penilai --}}
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold"
                                          :class="ratee.jumlah_penilai > 1 ? 'bg-emerald-50 text-emerald-700' : (ratee.jumlah_penilai === 1 ? 'bg-rose-50 text-rose-600' : 'bg-rose-50 text-rose-600')"
                                          x-text="ratee.jumlah_penilai">
                                    </span>
                                </td>
                                
                                {{-- Status badge --}}
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold"
                                          :class="ratee.status === 'Ready' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100'">
                                        <span class="w-1.5 h-1.5 rounded-full" :class="ratee.status === 'Ready' ? 'bg-emerald-600' : 'bg-rose-500'"></span>
                                        <span x-text="ratee.status"></span>
                                    </span>
                                </td>
                                
                                {{-- Action --}}
                                <td class="py-4 px-5 text-right">
                                    <template x-if="ratee.status === 'Ready'">
                                        <button @click="openLengkapi(ratee)" 
                                                class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-400 hover:text-slate-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                            </svg>
                                        </button>
                                    </template>
                                    <template x-if="ratee.status !== 'Ready'">
                                        <button @click="openLengkapi(ratee)" 
                                                class="px-2.5 py-1 text-[10px] font-bold border border-emerald-600/30 hover:border-emerald-600 text-[#006240] hover:bg-emerald-50 rounded-lg transition-all">
                                            Lengkapi
                                        </button>
                                    </template>
                                </td>
                            </tr>
                        </template>
                        
                        {{-- Empty State --}}
                        <tr x-show="filteredRatees.length === 0" x-cloak>
                            <td colspan="5" class="py-12 text-center text-slate-400 text-xs">
                                Karyawan tidak ditemukan. Coba gunakan pencarian lain.
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                {{-- Table Footer Pagination --}}
                <div class="px-5 py-3 border-t border-slate-50 flex items-center justify-between text-[11px] text-slate-400 bg-slate-50/40">
                    <span x-text="'Menampilkan 1-' + filteredRatees.length + ' dari ' + filteredRatees.length + ' data'"></span>
                    <div class="flex items-center gap-1">
                        <button class="p-1 rounded hover:bg-slate-100 text-slate-300 hover:text-slate-500 cursor-not-allowed" disabled>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                            </svg>
                        </button>
                        <button class="p-1 rounded hover:bg-slate-100 text-slate-300 hover:text-slate-500 cursor-not-allowed" disabled>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Right Column - Stats & Notify configs --}}
            <div class="space-y-6">
                
                {{-- Card 1: Status Penetapan Penilai --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm space-y-4">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Status Penetapan Penilai</span>
                    
                    <div class="space-y-1">
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold text-[#006240] tracking-tight" x-text="stats.ready_ratees">42</span>
                            <span class="text-sm font-semibold text-slate-400" x-text="'/ ' + stats.total_ratees + ' Ratee Ready'">/ 45 Ratee Ready</span>
                        </div>
                    </div>
                    
                    <div class="space-y-1.5">
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden w-full">
                            <div class="h-full bg-[#006240] rounded-full transition-all duration-300" :style="'width: ' + stats.percentage_ready + '%'"></div>
                        </div>
                        <span class="text-[10px] font-medium text-slate-400 block" x-text="stats.percentage_ready + '% karyawan telah memiliki daftar penilai yang lengkap.'"></span>
                    </div>
                </div>
                
                {{-- Card 2: Pengaturan Notifikasi --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm space-y-4">
                    <div class="space-y-1">
                        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[#006240]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                            </svg>
                            <span>Pengaturan Notifikasi Penilaian</span>
                        </h3>
                        <p class="text-[10.5px] text-slate-400 leading-normal">
                            Konfigurasi kapan dan bagaimana penilai menerima pengingat untuk mengisi form penilaian.
                        </p>
                    </div>
                    
                    {{-- Form elements --}}
                    <div class="space-y-4">
                        {{-- Toggle 1 --}}
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">Kirim Undangan Otomatis</span>
                                <span class="text-[10px] text-slate-400 block">Saat periode dimulai</span>
                            </div>
                            <button @click="notificationSettings.autoSend = !notificationSettings.autoSend"
                                    type="button"
                                    class="w-8 h-4.5 rounded-full p-0.5 transition-colors focus:outline-none"
                                    :class="notificationSettings.autoSend ? 'bg-[#006240]' : 'bg-slate-200'">
                                <div class="w-3.5 h-3.5 rounded-full bg-white transition-transform duration-200"
                                     :class="notificationSettings.autoSend ? 'translate-x-3.5' : 'translate-x-0'"></div>
                            </button>
                        </div>
                        
                        {{-- Toggle 2 --}}
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">Pengingat Mingguan</span>
                                <span class="text-[10px] text-slate-400 block">Untuk form yang belum selesai</span>
                            </div>
                            <button @click="notificationSettings.weeklyReminder = !notificationSettings.weeklyReminder"
                                    type="button"
                                    class="w-8 h-4.5 rounded-full p-0.5 transition-colors focus:outline-none"
                                    :class="notificationSettings.weeklyReminder ? 'bg-[#006240]' : 'bg-slate-200'">
                                <div class="w-3.5 h-3.5 rounded-full bg-white transition-transform duration-200"
                                     :class="notificationSettings.weeklyReminder ? 'translate-x-3.5' : 'translate-x-0'"></div>
                            </button>
                        </div>
                        
                        {{-- Dropdown --}}
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jadwal Pengiriman Pagi</label>
                            <select x-model="notificationSettings.schedule"
                                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 transition-all font-semibold text-slate-700">
                                <option value="08:00 AM WIB">08:00 AM WIB</option>
                                <option value="09:00 AM WIB">09:00 AM WIB</option>
                                <option value="10:00 AM WIB">10:00 AM WIB</option>
                            </select>
                        </div>
                    </div>
                    
                    {{-- Action trigger --}}
                    <div class="pt-2">
                        <form method="POST" action="{{ route('reviewers.notify') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-center py-2.5 bg-[#e6f0ec] hover:bg-[#d0e5dc] text-[#006240] text-xs font-bold rounded-xl transition-all shadow-sm active:scale-98">
                                Kirim Notifikasi Manual Sekarang
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </main>

    {{-- Interactive Rater Assignment Modal --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl max-w-md w-full overflow-hidden flex flex-col"
             @click.outside="showModal = false">
            
            {{-- Modal Header --}}
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Lengkapi Rater (Penilai)</h3>
                    <p class="text-[10px] text-slate-400" x-text="selectedRatee ? selectedRatee.nama + ' (' + selectedRatee.nik + ')' : ''"></p>
                </div>
                <button @click="showModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="p-5 space-y-4" x-data="{ raterName: '', raterType: 'Atasan' }">
                
                {{-- Info Current --}}
                <div class="bg-slate-50 rounded-xl p-3 text-xs flex items-center justify-between border border-slate-100">
                    <span class="text-slate-500 font-medium">Penilai Terdaftar</span>
                    <span class="font-bold text-[#006240]" x-text="selectedRatee ? selectedRatee.jumlah_penilai + ' Orang' : '0 Orang'"></span>
                </div>
                
                {{-- Form Add --}}
                <div class="space-y-3 pt-2">
                    <h4 class="text-xs font-bold text-slate-800">Tambah Penilai Baru</h4>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Penilai / NIK</label>
                        <input type="text" x-model="raterName" placeholder="Contoh: Hermawan / EMP-099" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 transition-all"/>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tipe Hubungan</label>
                        <select x-model="raterType" 
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 transition-all font-semibold">
                            <option value="Atasan">Atasan</option>
                            <option value="Rekan">Rekan Kerja</option>
                            <option value="Bawahan">Bawahan</option>
                        </select>
                    </div>
                    
                    <button type="button" 
                            @click="if(raterName) { 
                                selectedRatee.jumlah_penilai += 1;
                                if(selectedRatee.jumlah_penilai >= 2) selectedRatee.status = 'Ready';
                                raterName = ''; 
                            }"
                            class="w-full text-center py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                        + Tambah Penilai
                    </button>
                </div>
            </div>
            
            {{-- Modal Footer --}}
            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button @click="showModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-100 text-xs font-semibold rounded-xl transition-all">
                    Batal
                </button>
                <button @click="showModal = false; alert('Daftar penilai untuk ' + selectedRatee.nama + ' berhasil diperbarui!')" 
                        class="px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                    Simpan Perubahan
                </button>
            </div>
            
        </div>
        
    </div>

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
