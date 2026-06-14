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
         showDetailModal: false,
         activeRatee: { nama: '', nik: '', penilai_list: [] },
         
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
         
         openDetail(ratee) {
             this.activeRatee = ratee;
             this.showDetailModal = true;
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
    <main class="flex-1 p-8 max-w-7xl w-full mx-auto space-y-6">

        {{-- Hero Header --}}
        <div class="flex items-start justify-between">
            <div class="space-y-1.5">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight font-serif">Daftar Penilai (Ratee - Rater)</h1>
                <p class="text-xs text-gray-500 max-w-2xl leading-relaxed">
                    Kelola daftar karyawan yang akan dinilai dan tetapkan penilai untuk masing-masing.
                </p>
            </div>
            
            <div class="flex gap-2.5">
                {{-- Export Button --}}
                <button type="button"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 border border-gray-200 bg-white hover:bg-gray-50 text-xs font-bold text-gray-700 rounded-xl shadow-xs transition-all active:scale-95 focus:outline-none">
                    <svg class="w-4.5 h-4.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                    </svg>
                    <span>Export</span>
                </button>
                
                {{-- Tambah Data Button --}}
                <button type="button"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-[#006240] hover:bg-[#004d31] text-xs font-bold text-white rounded-xl shadow-sm transition-all active:scale-95 focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span>Tambah Data</span>
                </button>
            </div>
        </div>

        {{-- 3-Column Layout Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            {{-- Left column (table list & warnings) - Spans 2 columns --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Incomplete Warning Alert Banner --}}
                <div class="bg-red-50 border border-red-100 rounded-2xl p-4 flex items-start gap-3.5" x-show="ratees.filter(r => r.status === 'Incomplete').length > 0" x-cloak>
                    <div class="p-2 bg-red-100/50 rounded-xl text-red-600 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div class="space-y-1 text-xs">
                        <h4 class="font-bold text-red-900">Perhatian Diperlukan</h4>
                        <p class="text-red-700 leading-relaxed font-medium">
                            Terdapat <span class="font-bold" x-text="ratees.filter(r => r.status === 'Incomplete').length"></span> karyawan (Ratee) yang belum memiliki daftar penilai lengkap. Segera lengkapi agar proses penilaian dapat dimulai.
                        </p>
                        <button type="button" @click="statusFilter = 'Incomplete'" class="inline-flex items-center gap-1 font-bold text-red-800 hover:text-red-900 transition-colors mt-1 hover:underline focus:outline-none">
                            Lihat Karyawan Incomplete &rarr;
                        </button>
                    </div>
                </div>

                {{-- Search bar & Table Card --}}
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden space-y-4 pt-4">
                    
                    {{-- Inner search --}}
                    <div class="px-6 flex items-center gap-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4.5 h-4.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                                </svg>
                            </div>
                            <input type="text" x-model="search" placeholder="Cari nama karyawan..."
                                   class="w-full pl-10 pr-12 py-2.5 text-xs border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/10 focus:border-[#006240] transition-all font-medium text-gray-800"/>
                            <button type="button" @click="statusFilter = (statusFilter === '' ? 'Incomplete' : '')"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-[#006240] transition-colors focus:outline-none"
                                    :class="statusFilter === 'Incomplete' ? 'text-[#006240]' : 'text-gray-400'">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.155 1.733 6.073 4.29M12 3v3.75h3.75M12 21c-2.755 0-5.155-1.733-6.073-4.29M12 21v-3.75H8.25" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Table list --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-150 text-[10px] font-bold text-gray-400 uppercase tracking-wider select-none">
                                    <th class="py-3.5 px-6">Ratee (Yang Dinilai)</th>
                                    <th class="py-3.5 px-6">Role / Dept</th>
                                    <th class="py-3.5 px-6 text-center">Jumlah Penilai</th>
                                    <th class="py-3.5 px-6 text-center">Status</th>
                                    <th class="py-3.5 px-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="r in filteredRatees" :key="r.id">
                                    <tr class="hover:bg-gray-50/20 transition-colors">
                                        <td class="py-4 px-6 font-semibold">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-[11px] font-bold"
                                                     :class="r.avatar_color" x-text="r.avatar"></div>
                                                <div>
                                                    <p class="font-bold text-gray-900" x-text="r.nama"></p>
                                                    <p class="text-[10px] text-gray-400 font-medium mt-0.5" x-text="'ID: ' + r.nik"></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <p class="font-bold text-gray-800" x-text="r.jabatan"></p>
                                            <p class="text-[10px] text-gray-400 font-medium mt-0.5" x-text="r.divisi"></p>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="inline-flex w-6 h-6 rounded-full items-center justify-center font-bold text-xs"
                                                 :class="r.status === 'Ready' ? 'bg-[#e6f4ea] text-[#137333]' : 'bg-[#fce8e6] text-[#c5221f]'"
                                                 x-text="r.jumlah_penilai"></div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold border"
                                                  :class="r.status === 'Ready' ? 'bg-[#e6f4ea]/50 text-[#137333] border-emerald-100' : 'bg-[#fce8e6]/50 text-[#c5221f] border-rose-100'">
                                                <span class="w-1.5 h-1.5 rounded-full" :class="r.status === 'Ready' ? 'bg-[#137333]' : 'bg-[#c5221f]'"></span>
                                                <span x-text="r.status"></span>
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <template x-if="r.status === 'Ready'">
                                                <button type="button" @click="openDetail(r)" class="p-2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </button>
                                            </template>
                                            <template x-if="r.status === 'Incomplete'">
                                                <button type="button" @click="openDetail(r)"
                                                        class="px-4 py-1.5 border border-emerald-600 hover:bg-[#e6f4ea] rounded-xl text-xs font-bold text-[#006240] transition-all focus:outline-none">
                                                    Lengkapi
                                                </button>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- Table footer / pagination --}}
                    <div class="px-6 py-3.5 bg-gray-50/50 border-t border-gray-150 flex items-center justify-between text-xs text-gray-400 font-medium select-none">
                        <span x-text="'Menampilkan 1-' + filteredRatees.length + ' dari ' + ratees.length + ' data'"></span>
                        <div class="flex items-center gap-2">
                            <button type="button" class="p-1 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none disabled:opacity-50" disabled>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </button>
                            <button type="button" class="p-1 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none disabled:opacity-50" disabled>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right column (widgets) - Spans 1 column --}}
            <div class="space-y-6">
                
                {{-- Status Penetapan Penilai widget --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-6 space-y-4">
                    <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Status Penetapan Penilai</h3>
                    
                    <div class="space-y-3.5">
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-4xl font-extrabold text-[#006240] tracking-tight" x-text="ratees.filter(r => r.status === 'Ready').length"></span>
                            <span class="text-xs font-bold text-gray-450" x-text="'/ ' + ratees.length + ' Ratee Ready'"></span>
                        </div>
                        
                        {{-- Progress bar --}}
                        <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-[#006240] h-full rounded-full transition-all duration-500"
                                 :style="'width: ' + (ratees.length > 0 ? Math.round((ratees.filter(r => r.status === 'Ready').length / ratees.length) * 100) : 0) + '%'"></div>
                        </div>
                        
                        <p class="text-[11px] text-gray-400 font-semibold"
                           x-text="(ratees.length > 0 ? Math.round((ratees.filter(r => r.status === 'Ready').length / ratees.length) * 100) : 0) + '% karyawan telah memiliki daftar penilai yang lengkap.'">
                        </p>
                    </div>
                </div>

                {{-- Pengaturan Notifikasi Penilaian widget --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-6 space-y-5">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-[#e6f4ea] text-[#006240] rounded-xl flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0m5.714 0a24.255 24.255 0 01-5.714 0m0 0a3 3 0 115.714 0"/>
                            </svg>
                        </div>
                        <div class="space-y-0.5">
                            <h3 class="text-sm font-bold text-gray-800">Pengaturan Notifikasi Penilaian</h3>
                            <p class="text-[10px] text-gray-400 font-medium leading-relaxed">
                                Konfigurasi kapan dan bagaimana penilai menerima pengingat untuk mengisi form penilaian.
                            </p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        {{-- Row 1: Kirim Undangan --}}
                        <div class="flex items-center justify-between text-xs">
                            <div class="space-y-0.5">
                                <p class="font-bold text-gray-800">Kirim Undangan Otomatis</p>
                                <p class="text-[10px] text-gray-400 font-medium">Saat periode dimulai</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#006240]"></div>
                            </label>
                        </div>
                        
                        {{-- Row 2: Pengingat Mingguan --}}
                        <div class="flex items-center justify-between text-xs">
                            <div class="space-y-0.5">
                                <p class="font-bold text-gray-800">Pengingat Mingguan</p>
                                <p class="text-[10px] text-gray-400 font-medium">Untuk form yang belum selesai</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#006240]"></div>
                            </label>
                        </div>
                        
                        {{-- Dropdown Jadwal Pengiriman --}}
                        <div class="space-y-1.5 text-xs">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Jadwal Pengiriman Pagi</label>
                            <div class="relative">
                                <select class="w-full px-3 py-2.5 border border-gray-200 rounded-xl bg-gray-50/30 focus:outline-none focus:ring-2 focus:ring-[#006240]/10 focus:border-[#006240] transition-all font-semibold text-gray-700 appearance-none">
                                    <option>08:00 AM WIB</option>
                                    <option>09:00 AM WIB</option>
                                    <option>10:00 AM WIB</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Dispatch action buttons --}}
                    <div class="pt-4 border-t border-gray-150 flex flex-col gap-3">
                        <form method="POST" action="{{ route('hc.reviewers.notify') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full py-2.5 bg-[#e6f4ea] hover:bg-[#ceead6] text-[#006240] hover:text-[#004d31] rounded-xl text-xs font-bold transition-all focus:outline-none text-center block focus:ring-2 focus:ring-[#006240]/10">
                                Kirim Notifikasi Manual Sekarang
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('hc.reviewers.generate') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full py-2 text-center text-[11px] font-bold text-emerald-600 hover:text-emerald-800 transition-colors focus:outline-none hover:underline">
                                Auto-Generate Relasi Penilai Karyawan
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </main>

    {{-- ─── Modal Detail Rater ────────────────────────────── --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showDetailModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl max-w-md w-full overflow-hidden flex flex-col"
             @click.outside="showDetailModal = false">
            
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-bold text-slate-800">Reviewer Penilai Karyawan</h3>
                    <p class="text-[10px] text-slate-400 mt-0.5" x-text="activeRatee.nama"></p>
                </div>
                <button @click="showDetailModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="p-5 space-y-4 max-h-[350px] overflow-y-auto">
                <template x-if="activeRatee.penilai_list.length === 0">
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada penilai (Rater) yang ditugaskan.</p>
                </template>

                <div class="space-y-3">
                    <template x-for="p in activeRatee.penilai_list">
                        <div class="flex items-center justify-between p-3 border border-slate-50 rounded-xl bg-slate-50/20">
                            <div>
                                <p class="text-xs font-bold text-slate-800" x-text="p.nama"></p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-1.5 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-bold" x-text="p.tipe_penilai"></span>
                                    <span class="inline-flex items-center gap-1 text-[9px] font-bold"
                                          :class="p.status === 'Selesai' ? 'text-emerald-600' : 'text-amber-500'">
                                        <span class="w-1 h-1 rounded-full" :class="p.status === 'Selesai' ? 'bg-emerald-500' : 'bg-amber-500'"></span>
                                        <span x-text="p.status === 'Selesai' ? 'Selesai Menilai' : 'Belum Menilai'"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end">
                <button type="button" @click="showDetailModal = false" class="px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                    Tutup
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
