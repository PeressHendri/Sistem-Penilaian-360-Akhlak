<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Kelola Akun – PerformancePro</title>
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
<x-sidebar :active="'users'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
         search: '',
         roleFilter: '',
         showAddModal: false,
         showEditModal: false,
         
         // Edit state
         editUser: {
             id: null,
             name: '',
             email: '',
             department: '',
             role: 'Staff'
         },
         
         users: {{ json_encode($usersList) }},
         
         get filteredUsers() {
             return this.users.filter(u => {
                 const matchesSearch = u.name.toLowerCase().includes(this.search.toLowerCase()) || 
                                       u.email.toLowerCase().includes(this.search.toLowerCase()) ||
                                       u.department.toLowerCase().includes(this.search.toLowerCase());
                 const matchesRole = this.roleFilter === '' || u.role === this.roleFilter;
                 return matchesSearch && matchesRole;
             });
         },
         
         openEdit(user) {
             this.editUser = { ...user };
             this.showEditModal = true;
         }
     }">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Kelola Akun</span>
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
    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6 flex flex-col justify-between">
        
        <div class="space-y-6">
            {{-- Hero Header --}}
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Akun</h1>
                    <p class="text-sm text-slate-400 max-w-2xl leading-relaxed">
                        Kelola akses, peran, dan data profil pengguna sistem.
                    </p>
                </div>
                
                {{-- Add button --}}
                <button @click="showAddModal = true"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-xs font-semibold text-white rounded-xl shadow-sm transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span>Tambah Akun Baru</span>
                </button>
            </div>

            {{-- Search & Filter Bar --}}
            <div class="p-4 bg-white border border-slate-100 rounded-2xl shadow-xs flex items-center justify-between gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           x-model="search"
                           placeholder="Cari nama, email, atau departemen..." 
                           class="w-full pl-9 pr-4 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                </div>
                
                <div class="flex items-center gap-2">
                    <select x-model="roleFilter"
                            class="px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 transition-all font-semibold text-slate-600">
                        <option value="">Semua Peran</option>
                        <option value="Administrator">Administrator</option>
                        <option value="Manager">Manager</option>
                        <option value="Pegawai">Pegawai</option>
                        <option value="Staff">Staff</option>
                    </select>
                    
                    <button @click="search = ''; roleFilter = ''" 
                            class="p-2 border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-400 hover:text-slate-600 transition-all"
                            title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Accounts Grid (3 columns) --}}
            <div class="grid grid-cols-3 gap-6">
                <template x-for="usr in filteredUsers" :key="usr.id">
                    <div class="hover-card bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex flex-col justify-between space-y-5">
                        
                        {{-- Top Section: Initials & details --}}
                        <div class="flex items-start gap-3.5">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0"
                                 :class="usr.color"
                                 x-text="usr.initials">
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-slate-800 truncate" x-text="usr.name"></h4>
                                <p class="text-[10px] text-slate-400 truncate mt-0.5" x-text="usr.email"></p>
                                
                                <div class="flex items-center gap-1.5 mt-2">
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[9px] font-bold rounded-lg" x-text="usr.department"></span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold" 
                                          :class="usr.role_class">
                                        <span class="w-1 h-1 rounded-full" :class="usr.role === 'Administrator' || usr.role === 'Staff' ? 'bg-emerald-600' : (usr.role === 'Manager' ? 'bg-blue-600' : 'bg-purple-600')"></span>
                                        <span x-text="usr.role"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Action buttons --}}
                        <div class="grid grid-cols-2 gap-2.5 border-t border-slate-50 pt-3 text-xs">
                            <button @click="openEdit(usr)"
                                    class="inline-flex items-center justify-center gap-1 px-3 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 rounded-xl font-bold text-slate-600 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                </svg>
                                <span>Edit</span>
                            </button>
                            
                            {{-- Delete form --}}
                            <form :action="'/users/' + usr.id" method="POST" @submit.prevent="if(confirm('Apakah Anda yakin ingin menghapus akun ini?')) $el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center gap-1 px-3 py-1.5 border border-rose-200 bg-white hover:bg-rose-50 rounded-xl font-bold text-rose-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </template>
                
                {{-- Empty state --}}
                <div x-show="filteredUsers.length === 0" x-cloak
                     class="col-span-3 py-16 text-center text-slate-400 text-xs">
                    Akun tidak ditemukan. Coba gunakan kata kunci pencarian yang lain.
                </div>
            </div>
        </div>

        {{-- Table Footer Pagination --}}
        <div class="px-5 py-3 border border-slate-100 rounded-2xl flex items-center justify-between text-xs text-slate-400 bg-white shadow-xs">
            <span x-text="'Menampilkan 1-' + filteredUsers.length + ' dari 124 akun'"></span>
            <div class="flex items-center gap-1.5 font-bold text-xs">
                <button class="p-1 rounded hover:bg-slate-100 text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                    </svg>
                </button>
                <button class="w-6 h-6 rounded-full bg-[#006240] text-white flex items-center justify-center shadow-xs">1</button>
                <button class="w-6 h-6 rounded-full hover:bg-slate-100 text-slate-500 flex items-center justify-center">2</button>
                <button class="w-6 h-6 rounded-full hover:bg-slate-100 text-slate-500 flex items-center justify-center">3</button>
                <button class="p-1 rounded hover:bg-slate-100 text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                    </svg>
                </button>
            </div>
        </div>

    </main>

    {{-- ─── Modal Create User ────────────────────────────── --}}
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
            
            {{-- Modal Header --}}
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800">Tambah Akun Baru</h3>
                <button @click="showAddModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                {{-- Modal Body --}}
                <div class="p-5 space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Contoh: Hermawan Wijaya" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Alamat Email</label>
                        <input type="email" name="email" required placeholder="Contoh: hermawan@company.com" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Departemen</label>
                        <input type="text" name="department" required placeholder="Contoh: Engineering Dept" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Peran (Role)</label>
                        <select name="role" required
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 transition-all font-semibold">
                            <option value="Administrator">Administrator</option>
                            <option value="Manager">Manager</option>
                            <option value="Pegawai">Pegawai</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>
                </div>
                
                {{-- Modal Footer --}}
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-100 text-xs font-semibold rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── Modal Edit User ──────────────────────────────── --}}
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
            
            {{-- Modal Header --}}
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800">Edit Akun Pengguna</h3>
                <button @click="showEditModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form :action="'/users/' + editUser.id" method="POST">
                @csrf
                @method('PUT')
                {{-- Modal Body --}}
                <div class="p-5 space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap</label>
                        <input type="text" name="name" required x-model="editUser.name" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Alamat Email</label>
                        <input type="email" name="email" required x-model="editUser.email" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Departemen</label>
                        <input type="text" name="department" required x-model="editUser.department" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Peran (Role)</label>
                        <select name="role" required x-model="editUser.role"
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 transition-all font-semibold">
                            <option value="Administrator">Administrator</option>
                            <option value="Manager">Manager</option>
                            <option value="Pegawai">Pegawai</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>
                </div>
                
                {{-- Modal Footer --}}
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-100 text-xs font-semibold rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                        Perbarui Akun
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
            <a href="#" class="text-xs text-slate-400 hover:text-[#006240]">Terms</a>
            <a href="#" class="text-xs text-slate-400 hover:text-[#006240]">Support</a>
        </div>
    </footer>

</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
