<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Kelola Karyawan – PerformancePro</title>
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
<x-sidebar :active="'employees'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
         search: '',
         divisiFilter: '',
         showAddModal: false,
         showEditModal: false,
         showImportModal: false,
         
         editEmployee: {
             id: null,
             nik: '',
             nama: '',
             email: '',
             phone: '',
             jabatan: '',
             divisi: '',
             tanggal_masuk: '',
             status: 'Aktif',
             atasan_id: ''
         },
         
         employees: {{ json_encode($employees) }},
         
         get filteredEmployees() {
             return this.employees.filter(e => {
                 const matchesSearch = e.nama.toLowerCase().includes(this.search.toLowerCase()) || 
                                       e.nik.toLowerCase().includes(this.search.toLowerCase()) ||
                                       e.jabatan.toLowerCase().includes(this.search.toLowerCase());
                 const matchesDivisi = this.divisiFilter === '' || e.divisi === this.divisiFilter;
                 return matchesSearch && matchesDivisi;
             });
         },
         
         openEdit(emp) {
             this.editEmployee = { ...emp };
             this.showEditModal = true;
         }
     }">
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

        {{-- Hero Header & Search + Filters --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="space-y-1">
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Kelola Karyawan</h1>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Manage and view all employee records within the organization.
                </p>
            </div>
            
            <div class="flex items-center gap-2">
                {{-- Search Input --}}
                <div class="relative w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           x-model="search"
                           placeholder="Search by name or NIK..." 
                           class="w-full pl-9 pr-4 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006240]/20 focus:border-[#006240] bg-white transition-all shadow-xs"/>
                </div>

                {{-- Filters Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors shadow-xs">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.82c0-.54.384-1.006.917-1.096A50.065 50.065 0 0112 3z"/>
                        </svg>
                        <span>Filters</span>
                    </button>
                    
                    <div x-show="open" 
                         @click.outside="open = false" 
                         x-cloak
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white border border-slate-150 rounded-xl shadow-lg z-30 p-3 space-y-3 text-xs">
                        <div>
                           <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Filter Divisi</label>
                           <select x-model="divisiFilter" class="w-full px-2 py-1.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#006240] text-xs">
                               <option value="">Semua Divisi</option>
                               @foreach($employees->pluck('divisi')->unique() as $div)
                                   <option value="{{ $div }}">{{ $div }}</option>
                               @endforeach
                           </select>
                        </div>
                        <div class="border-t border-slate-100 pt-2 flex flex-col gap-1.5">
                            <button @click="showImportModal = true; open = false" class="w-full text-left py-1 text-slate-600 hover:text-[#006240] font-semibold flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>
                                <span>Import CSV</span>
                            </button>
                            <button @click="search = ''; divisiFilter = ''; open = false" class="w-full text-left py-1 text-rose-600 hover:text-rose-700 font-semibold flex items-center gap-1.5 border-t border-slate-50 pt-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                </svg>
                                <span>Reset Filters</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <template x-for="emp in filteredEmployees" :key="emp.id">
                <div class="hover-card bg-white border border-slate-150 rounded-2xl p-5 shadow-xs flex flex-col justify-between relative">
                    
                    {{-- Card Header: Avatar & Right Action/Status Column --}}
                    <div class="flex items-start justify-between">
                        <!-- Employee Avatar -->
                        <img class="w-14 h-14 rounded-full object-cover border border-slate-100 shadow-xs flex-shrink-0" 
                             :src="emp.photo ? '/storage/' + emp.photo : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(emp.nama) + '&background=random&color=fff&size=128'" 
                             alt="Foto Karyawan">

                        <!-- Dropdown & Status Badge -->
                        <div class="flex flex-col items-end gap-3.5">
                            <!-- Three vertical dots Action Menu -->
                            <div class="relative" x-data="{ menuOpen: false }">
                                <button @click="menuOpen = !menuOpen" class="text-slate-400 hover:text-slate-600 p-1 rounded-full hover:bg-slate-50 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                    </svg>
                                </button>
                                
                                <div x-show="menuOpen" 
                                     @click.outside="menuOpen = false" 
                                     x-cloak
                                     class="absolute right-0 mt-1 w-28 bg-white border border-slate-150 rounded-xl shadow-lg z-20 py-1 text-[11px]">
                                    <button @click="openEdit(emp); menuOpen = false" 
                                            class="w-full text-left px-3 py-1.5 hover:bg-slate-50 text-slate-700 font-semibold flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                        <span>Edit</span>
                                    </button>
                                    
                                    <form :action="'/hc/employees/' + emp.id" method="POST" @submit.prevent="if(confirm('Apakah Anda yakin ingin menghapus data karyawan ini?')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full text-left px-3 py-1.5 hover:bg-rose-50 text-rose-600 font-semibold flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166"/>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Status Capsule Badge -->
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold tracking-wide" 
                                  :class="emp.status === 'Aktif' ? 'bg-[#e6f4ea] text-[#137333]' : 'bg-[#f1f3f4] text-[#5f6368]'">
                                <span class="w-1 h-1 rounded-full mr-1" :class="emp.status === 'Aktif' ? 'bg-[#137333]' : 'bg-[#5f6368]'"></span>
                                <span x-text="emp.status"></span>
                            </span>
                        </div>
                    </div>

                    {{-- Employee Core Info --}}
                    <div class="mt-4 space-y-1">
                        <h4 class="text-sm font-bold text-slate-800 tracking-tight truncate" x-text="emp.nama"></h4>
                        <p class="text-[10px] text-slate-400 font-semibold tracking-wide" x-text="'NIK: ' + emp.nik"></p>
                    </div>

                    {{-- Divider --}}
                    <hr class="border-slate-100 my-3.5">

                    {{-- Job Details --}}
                    <div class="space-y-2 text-[11px] text-slate-500 font-medium">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-350 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.898m7.5 0a48.112 48.112 0 01-7.5 0"/>
                            </svg>
                            <span class="truncate" x-text="emp.jabatan"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-350 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 16.5h1.5M13.5 16.5H15"/>
                            </svg>
                            <span class="truncate" x-text="emp.divisi"></span>
                        </div>
                        <div class="flex items-center gap-2" x-show="emp.atasan">
                            <svg class="w-4 h-4 text-slate-350 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3"/>
                            </svg>
                            <span class="truncate font-semibold text-[#006240]" x-text="'Atasan: ' + (emp.atasan ? emp.atasan.nama : '-')"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>

    </main>

    {{-- Floating Action Button - Tambah Karyawan --}}
    <button @click="showAddModal = true" 
            class="fixed bottom-8 right-8 inline-flex items-center gap-2 px-5 py-3.5 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all z-40">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        <span>Tambah Karyawan</span>
    </button>

    {{-- ─── Modal Tambah Karyawan ────────────────────────── --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showAddModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl max-w-md w-full overflow-hidden flex flex-col"
             @click.outside="showAddModal = false">
            
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800">Tambah Karyawan Baru</h3>
                <button @click="showAddModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('hc.employees.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-5 space-y-4 text-xs">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">NIK (Nomor Induk Karyawan)</label>
                            <input type="text" name="nik" required placeholder="Contoh: 202601002" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap</label>
                            <input type="text" name="nama" required placeholder="Contoh: Budi Santoso" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Alamat Email</label>
                            <input type="email" name="email" required placeholder="Contoh: budi@company.com" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nomor Telepon</label>
                            <input type="text" name="phone" placeholder="Contoh: 08123456789" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jabatan</label>
                            <input type="text" name="jabatan" required placeholder="Contoh: Software Engineer" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Divisi</label>
                            <input type="text" name="divisi" required placeholder="Contoh: Engineering Dept" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" required 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Status</label>
                            <select name="status" required 
                                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all">
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Atasan Langsung</label>
                        <select name="atasan_id" 
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all">
                            <option value="">-- Tanpa Atasan (Direktur/Owner) --</option>
                            @foreach($managers as $m)
                                <option value="{{ $m->id }}">{{ $m->nama }} - {{ $m->jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Foto Profil</label>
                        <input type="file" name="photo" accept="image/*" 
                               class="w-full px-3 py-2 text-xs border border-slate-250 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/35 focus:border-[#006240] transition-all bg-slate-50"/>
                    </div>
                </div>
                
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-100 text-xs font-semibold rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                        Simpan Karyawan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── Modal Edit Karyawan ──────────────────────────── --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showEditModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl max-w-md w-full overflow-hidden flex flex-col"
             @click.outside="showEditModal = false">
            
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800">Edit Data Karyawan</h3>
                <button @click="showEditModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" :action="'/hc/employees/' + editEmployee.id" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-5 space-y-4 text-xs">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">NIK (Nomor Induk Karyawan)</label>
                            <input type="text" name="nik" required x-model="editEmployee.nik" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap</label>
                            <input type="text" name="nama" required x-model="editEmployee.nama" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Alamat Email</label>
                            <input type="email" name="email" required x-model="editEmployee.email" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nomor Telepon</label>
                            <input type="text" name="phone" x-model="editEmployee.phone" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jabatan</label>
                            <input type="text" name="jabatan" required x-model="editEmployee.jabatan" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Divisi</label>
                            <input type="text" name="divisi" required x-model="editEmployee.divisi" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" required x-model="editEmployee.tanggal_masuk" 
                                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Status</label>
                            <select name="status" required x-model="editEmployee.status" 
                                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all">
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Atasan Langsung</label>
                        <select name="atasan_id" x-model="editEmployee.atasan_id" 
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all">
                            <option value="">-- Tanpa Atasan (Direktur/Owner) --</option>
                            @foreach($managers as $m)
                                <option value="{{ $m->id }}">{{ $m->nama }} - {{ $m->jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Foto Profil</label>
                        <div class="flex items-center gap-3">
                            <template x-if="editEmployee.photo">
                                <img class="w-12 h-12 rounded-full object-cover border border-slate-200 flex-shrink-0" :src="'/storage/' + editEmployee.photo" alt="Foto Profil">
                            </template>
                            <input type="file" name="photo" accept="image/*" 
                                   class="flex-1 px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all bg-slate-50"/>
                        </div>
                        <template x-if="editEmployee.photo">
                            <label class="inline-flex items-center gap-1.5 mt-1.5 cursor-pointer">
                                <input type="checkbox" name="remove_photo" value="1" class="rounded border-slate-300 text-[#006240] focus:ring-[#006240]/30">
                                <span class="text-[11px] text-slate-500 font-semibold">Hapus foto profil saat ini</span>
                            </label>
                        </template>
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

    {{-- ─── Modal Import CSV ────────────────────────────── --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showImportModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl max-w-sm w-full overflow-hidden flex flex-col"
             @click.outside="showImportModal = false">
            
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800">Impor Karyawan via CSV</h3>
                <button @click="showImportModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('hc.employees.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-5 space-y-4 text-xs">
                    <div class="p-3 bg-amber-50 border border-amber-100 text-amber-800 rounded-xl">
                        <p class="font-bold">Format CSV yang didukung:</p>
                        <p class="mt-1 font-mono">NIK, Nama, Email, Telepon, Jabatan, Divisi, Tanggal Masuk (YYYY-MM-DD), Status</p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pilih File CSV</label>
                        <input type="file" name="csv_file" required accept=".csv" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none transition-all"/>
                    </div>
                </div>
                
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showImportModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-100 text-xs font-semibold rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                        Unggah &amp; Impor
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-slate-400">© 2026 PerformancePro Inc.</p>
        <div class="flex gap-4">
            <a href="#" class="text-xs text-slate-400 hover:text-[#006240]">Privacy</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Terms</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Support</a>
        </div>
    </footer>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
