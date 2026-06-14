<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Kelola Akun – PerformancePro</title>
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
<x-sidebar :active="'users'"/>

{{-- Main Content --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
          search: '',
          roleFilter: '',
          showAddModal: false,
          showEditModal: false,
          
          editUser: {
              id: null,
              name: '',
              email: '',
              department: '',
              role: 'Penilai'
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
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Akun</h1>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">
                        Kelola akses, peran, dan data profil pengguna sistem.
                    </p>
                </div>
                
                {{-- Add button --}}
                <button @click="showAddModal = true"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#006847] hover:bg-[#005036] text-xs font-semibold text-white rounded-lg shadow-xs transition-all active:scale-98">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                    </svg>
                    <span>Tambah Akun Baru</span>
                </button>
            </div>

            {{-- Search & Filter Bar --}}
            <div class="p-3 bg-white border border-slate-200/80 rounded-xl shadow-xs flex items-center justify-between gap-4 select-none">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           x-model="search"
                           placeholder="Cari nama, email, atau departemen..." 
                           class="w-full pl-9 pr-4 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all"/>
                </div>
                
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <select x-model="roleFilter"
                                class="appearance-none pl-3 pr-8 py-2 text-xs border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-[#006847]/20 transition-all font-semibold text-slate-600 cursor-pointer">
                            <option value="">Semua Peran</option>
                            <option value="Administrator">Administrator</option>
                            <option value="Human Capital">Human Capital</option>
                            <option value="Penilai">Penilai</option>
                            <option value="Management">Management</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </div>
                    </div>
                    
                    <button @click="search = ''; roleFilter = ''" 
                            class="p-2 border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-400 hover:text-slate-600 transition-all"
                            title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A50.065 50.065 0 0112 3z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Accounts Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <template x-for="usr in filteredUsers" :key="usr.id">
                    <div class="bg-white border border-slate-200/80 rounded-xl p-5 shadow-xs flex flex-col justify-between space-y-5">
                        
                        {{-- Top Details --}}
                        <div class="flex items-start gap-4">
                            <!-- Photo Avatar -->
                            <template x-if="usr.photo">
                                <img :src="usr.photo" :alt="usr.name" class="w-12 h-12 rounded-full object-cover border border-slate-200 flex-shrink-0 select-none"/>
                            </template>
                            <!-- Initials Avatar -->
                            <template x-if="!usr.photo">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0 select-none"
                                     :class="usr.role === 'Administrator' ? 'bg-[#006847] text-white' : 
                                             (usr.role === 'Human Capital' || usr.role === 'Management' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-700')"
                                     x-text="usr.initials">
                                </div>
                            </template>
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-slate-800 truncate" x-text="usr.name"></h4>
                                <p class="text-[11px] text-slate-400 truncate mt-0.5" x-text="usr.email"></p>
                                
                                <div class="flex flex-wrap items-center gap-1.5 mt-3 select-none">
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[9.5px] font-semibold rounded" x-text="usr.department"></span>
                                    
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9.5px] font-semibold" 
                                          :class="usr.role === 'Administrator' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 
                                                  (usr.role === 'Human Capital' || usr.role === 'Management' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-slate-50 text-slate-500 border border-slate-100')">
                                        <span class="w-1 h-1 rounded-full" 
                                              :class="usr.role === 'Administrator' ? 'bg-emerald-600' : 
                                                      (usr.role === 'Human Capital' || usr.role === 'Management' ? 'bg-blue-600' : 'bg-slate-400')"></span>
                                        <span x-text="usr.role"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="grid grid-cols-2 gap-3 border-t border-slate-100 pt-4 text-xs select-none">
                            <button @click="openEdit(usr)"
                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-slate-200 bg-white hover:bg-slate-50 rounded-lg font-semibold text-slate-600 transition-colors">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                </svg>
                                <span>Edit</span>
                            </button>
                            
                            <form :action="'/admin/users/' + usr.id" method="POST" @submit.prevent="if(confirm('Apakah Anda yakin ingin menghapus akun ini?')) $el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-slate-200 bg-white hover:bg-rose-50/50 rounded-lg font-semibold text-rose-600 transition-colors">
                                    <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </template>
            </div>
            
            {{-- Pagination Bar --}}
            <div class="border-t border-slate-200/60 pt-6 flex items-center justify-between mt-8 select-none">
                <span class="text-xs text-slate-400 font-medium" x-text="`Menampilkan 1-${filteredUsers.length} dari ${filteredUsers.length} akun`">Menampilkan 1-4 dari 124 akun</span>
                <div class="flex items-center gap-1">
                    <button class="p-1.5 border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                        </svg>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center text-xs font-bold bg-[#006847] text-white rounded-lg">1</button>
                    <button class="w-8 h-8 flex items-center justify-center text-xs font-bold border border-slate-200 text-slate-500 rounded-lg hover:bg-slate-50">2</button>
                    <button class="w-8 h-8 flex items-center justify-center text-xs font-bold border border-slate-200 text-slate-500 rounded-lg hover:bg-slate-50">3</button>
                    <button class="p-1.5 border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

    </main>

    {{-- Modal Add --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showAddModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-xl border border-slate-200 shadow-xl max-w-sm w-full overflow-hidden flex flex-col"
             @click.outside="showAddModal = false">
            
            <div class="px-5 py-4 bg-[#f8fafc] border-b border-slate-200/60 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800">Tambah Akun Baru</h3>
                <button @click="showAddModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="p-5 space-y-4 text-left">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Contoh: Andi Wijaya" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all"/>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Alamat Email</label>
                        <input type="email" name="email" required placeholder="Contoh: andi@company.com" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all"/>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Divisi / Departemen</label>
                        <input type="text" name="department" required placeholder="Contoh: IT Dept" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all"/>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Peran (Role)</label>
                        <select name="role" required 
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all">
                            <option value="Penilai">Penilai</option>
                            <option value="Human Capital">Human Capital</option>
                            <option value="Administrator">Administrator</option>
                            <option value="Management">Management</option>
                        </select>
                    </div>
                </div>
                
                <div class="px-5 py-3.5 bg-[#f8fafc] border-t border-slate-200/60 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold rounded-lg transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#006847] hover:bg-[#005036] text-white text-xs font-bold rounded-lg shadow-xs transition-all">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showEditModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-xl border border-slate-200 shadow-xl max-w-sm w-full overflow-hidden flex flex-col"
             @click.outside="showEditModal = false">
            
            <div class="px-5 py-4 bg-[#f8fafc] border-b border-slate-200/60 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800">Edit Akun</h3>
                <button @click="showEditModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" :action="'/admin/users/' + editUser.id">
                @csrf
                @method('PUT')
                <div class="p-5 space-y-4 text-left">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap</label>
                        <input type="text" name="name" required x-model="editUser.name" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all"/>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Alamat Email</label>
                        <input type="email" name="email" required x-model="editUser.email" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all"/>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Divisi / Departemen</label>
                        <input type="text" name="department" required x-model="editUser.department" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all"/>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Peran (Role)</label>
                        <select name="role" required x-model="editUser.role" 
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all">
                            <option value="Penilai">Penilai</option>
                            <option value="Human Capital">Human Capital</option>
                            <option value="Administrator">Administrator</option>
                            <option value="Management">Management</option>
                        </select>
                    </div>
                </div>
                
                <div class="px-5 py-3.5 bg-[#f8fafc] border-t border-slate-200/60 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold rounded-lg transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#006847] hover:bg-[#005036] text-white text-xs font-bold rounded-lg shadow-xs transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

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
