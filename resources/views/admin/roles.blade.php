<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Atur Hak Akses – PerformancePro</title>
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
<x-sidebar :active="request()->is('*permissions*') ? 'permissions' : 'roles'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
         matrix: {{ json_encode($matrix) }},
         activeRole: '',
         showAddRoleModal: false,
         newRoleName: '',
         init() {
             this.activeRole = Object.keys(this.matrix)[0] || '';
         }
     }">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">
            {{ request()->is('*permissions*') ? 'Hak Akses' : 'Kelola Role' }}
        </span>
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

        {{-- Breadcrumbs --}}
        <div class="flex items-center gap-2 text-xs font-semibold text-[#006240]/80">
            <span class="text-slate-400">Pengaturan</span>
            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
            <span>{{ request()->is('*permissions*') ? 'Hak Akses' : 'Kelola Role' }}</span>
        </div>

        {{-- Hero Header --}}
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                {{ request()->is('*permissions*') ? 'Matriks Izin / Hak Akses' : 'Kelola Peran & Otorisasi' }}
            </h1>
            <p class="text-sm text-slate-400 max-w-2xl leading-relaxed">
                Kelola hak akses untuk setiap peran dalam sistem. Sinkronisasikan izin terhadap modul dashboard, karyawan, formulir, dan hasil secara real-time.
            </p>
        </div>

        {{-- Stats Row Cards --}}
        <div class="grid grid-cols-3 gap-6">
            
            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4 relative overflow-hidden h-24">
                <div class="absolute -right-8 -bottom-8 w-20 h-20 bg-slate-50 rounded-full"></div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider block">Total Peran Aktif</span>
                    <span class="text-2xl font-extrabold text-slate-800 mt-1 block" x-text="Object.keys(matrix).length">0</span>
                </div>
            </div>

            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4 relative overflow-hidden h-24">
                <div class="absolute -right-8 -bottom-8 w-20 h-20 bg-slate-50 rounded-full"></div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider block">Modul Utama</span>
                    <span class="text-2xl font-extrabold text-slate-800 mt-1 block">{{ $totalModules }}</span>
                </div>
            </div>

            <div class="bg-[#006240] text-white p-5 rounded-2xl shadow-sm flex items-center gap-4 relative overflow-hidden h-24">
                <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-white/5 rounded-full"></div>
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296"/>
                    </svg>
                </div>
                <div class="space-y-0.5">
                    <span class="text-[9.5px] font-bold text-white/85 uppercase tracking-wider block">Status Kebijakan</span>
                    <span class="text-xs font-bold text-white block">Tersinkronisasi Realtime</span>
                </div>
            </div>

        </div>

        {{-- Form Matrix --}}
        <form method="POST" action="{{ route('admin.roles.store') }}" class="space-y-6">
            @csrf
            
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
                
                <div class="px-6 pt-5 pb-0 border-b border-slate-100 flex flex-col space-y-4 bg-slate-50/20">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 font-semibold">Matriks Izin Role</h3>
                        <p class="text-[10.5px] text-slate-400 mt-0.5">Pilih tab peran untuk menyesuaikan hak akses granular.</p>
                    </div>

                    {{-- Dynamic Tabs --}}
                    <div class="flex items-center justify-between border-b border-slate-100 -mx-6 px-6 bg-white">
                        <div class="flex items-center gap-6 overflow-x-auto select-none">
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <button type="button" 
                                        @click="activeRole = roleName"
                                        :class="activeRole === roleName ? 'border-[#006240] text-[#006240] font-bold' : 'border-transparent text-slate-400 hover:text-slate-600'"
                                        class="py-3 px-1 border-b-2 text-xs font-semibold transition-all focus:outline-none"
                                        x-text="roleName">
                                </button>
                            </template>
                        </div>
                        
                        <button type="button" 
                                @click="showAddRoleModal = true"
                                class="py-3 px-1 text-xs font-bold text-[#006240] hover:text-[#004d31] transition-colors flex items-center gap-1 focus:outline-none">
                            <span>+ Peran Baru</span>
                        </button>
                    </div>
                </div>

                {{-- Table Matrix --}}
                <table class="w-full text-left border-collapse bg-white">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider select-none">
                            <th class="py-3.5 px-6 w-2/5">Nama Modul</th>
                            <th class="py-3.5 px-4 text-center">Lihat</th>
                            <th class="py-3.5 px-4 text-center">Buat</th>
                            <th class="py-3.5 px-4 text-center">Ubah</th>
                            <th class="py-3.5 px-4 text-center">Hapus</th>
                            <th class="py-3.5 px-6 text-center">Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        
                        {{-- Dashboard --}}
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-[#006240] flex-shrink-0 border border-emerald-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">Dashboard Utama</span>
                                        <span class="text-[10px] text-slate-400 block mt-0.5">Akses visual ringkasan metrik</span>
                                    </div>
                                </div>
                            </td>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][dashboard][lihat]'" x-model="matrix[roleName].dashboard.lihat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][dashboard][buat]'" x-model="matrix[roleName].dashboard.buat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][dashboard][ubah]'" x-model="matrix[roleName].dashboard.ubah" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][dashboard][hapus]'" x-model="matrix[roleName].dashboard.hapus" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-6 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][dashboard][validasi]'" x-model="matrix[roleName].dashboard.validasi" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                        </tr>

                        {{-- Karyawan --}}
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-sky-50 flex items-center justify-center text-sky-600 flex-shrink-0 border border-sky-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">Kelola Karyawan</span>
                                        <span class="text-[10px] text-slate-400 block mt-0.5">Master data pegawai &amp; atasan</span>
                                    </div>
                                </div>
                            </td>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][karyawan][lihat]'" x-model="matrix[roleName].karyawan.lihat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][karyawan][buat]'" x-model="matrix[roleName].karyawan.buat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][karyawan][ubah]'" x-model="matrix[roleName].karyawan.ubah" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][karyawan][hapus]'" x-model="matrix[roleName].karyawan.hapus" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-6 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][karyawan][validasi]'" x-model="matrix[roleName].karyawan.validasi" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                        </tr>

                        {{-- Formulir --}}
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 flex-shrink-0 border border-amber-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">Formulir Penilaian</span>
                                        <span class="text-[10px] text-slate-400 block mt-0.5">Input penilaian, skor, dan feedback</span>
                                    </div>
                                </div>
                            </td>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][formulir][lihat]'" x-model="matrix[roleName].formulir.lihat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][formulir][buat]'" x-model="matrix[roleName].formulir.buat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][formulir][ubah]'" x-model="matrix[roleName].formulir.ubah" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][formulir][hapus]'" x-model="matrix[roleName].formulir.hapus" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-6 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][formulir][validasi]'" x-model="matrix[roleName].formulir.validasi" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                        </tr>

                        {{-- Hasil --}}
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600 flex-shrink-0 border border-purple-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">Hasil Penilaian</span>
                                        <span class="text-[10px] text-slate-400 block mt-0.5">Analisis hasil, talent mapping, &amp; IDP</span>
                                    </div>
                                </div>
                            </td>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][hasil][lihat]'" x-model="matrix[roleName].hasil.lihat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][hasil][buat]'" x-model="matrix[roleName].hasil.buat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][hasil][ubah]'" x-model="matrix[roleName].hasil.ubah" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][hasil][hapus]'" x-model="matrix[roleName].hasil.hapus" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-6 text-center" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][hasil][validasi]'" x-model="matrix[roleName].hasil.validasi" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- Save buttons --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="/admin/dashboard"
                   class="px-5 py-2.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition-all shadow-sm active:scale-95">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-md transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Simpan Konfigurasi</span>
                </button>
            </div>

        </form>

    </main>

    {{-- ─── Modal Create Role ────────────────────────────── --}}
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4"
         x-show="showAddRoleModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl max-w-sm w-full overflow-hidden flex flex-col"
             @click.outside="showAddRoleModal = false">
            
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800">Tambah Peran Baru</h3>
                <button @click="showAddRoleModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf
                <div class="p-5 space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Peran (Role Name)</label>
                        <input type="text" name="new_role_name" required x-model="newRoleName" placeholder="Contoh: Human Capital Specialist" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>
                </div>
                
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="showAddRoleModal = false" class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-100 text-xs font-semibold rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#006240] hover:bg-[#004d31] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                        Tambah Peran
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
