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
<x-sidebar :active="'roles'"/>

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
        <span class="text-sm font-semibold text-[#006240]">Hak Akses</span>
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
            <span>Hak Akses</span>
        </div>

        {{-- Hero Header --}}
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Atur Hak Akses</h1>
            <p class="text-sm text-slate-400 max-w-2xl leading-relaxed">
                Kelola granularitas akses untuk setiap peran dalam sistem. Pastikan matriks izin dikonfigurasikan dengan tepat untuk menjaga keamanan dan privasi data.
            </p>
        </div>

        {{-- Stats Row Cards --}}
        <div class="grid grid-cols-3 gap-6">
            
            {{-- Stat 1 --}}
            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4 relative overflow-hidden h-24">
                <div class="absolute -right-8 -bottom-8 w-20 h-20 bg-slate-50 rounded-full"></div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider block">Total Peran Aktif</span>
                    <span class="text-2xl font-extrabold text-slate-800 mt-1 block" x-text="Object.keys(matrix).length">5</span>
                </div>
            </div>

            {{-- Stat 2 --}}
            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4 relative overflow-hidden h-24">
                <div class="absolute -right-8 -bottom-8 w-20 h-20 bg-slate-50 rounded-full"></div>
                <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider block">Modul Sistem</span>
                    <span class="text-2xl font-extrabold text-slate-800 mt-1 block">{{ $totalModules }}</span>
                </div>
            </div>

            {{-- Stat 3 --}}
            <div class="bg-[#006240] text-white p-5 rounded-2xl shadow-sm flex items-center gap-4 relative overflow-hidden h-24">
                <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-white/5 rounded-full"></div>
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                    </svg>
                </div>
                <div class="space-y-0.5">
                    <span class="text-[9.5px] font-bold text-white/85 uppercase tracking-wider block">Status Validasi</span>
                    <span class="text-xs font-bold text-white block">Semua kebijakan tersinkronisasi</span>
                </div>
            </div>

        </div>

        {{-- Form Matrix Form --}}
        <form method="POST" action="{{ route('roles.store') }}" class="space-y-6">
            @csrf
            
            {{-- Main Permission matrix card --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
                
                {{-- Card Header: Subtitle & Tabs --}}
                <div class="px-6 pt-5 pb-0 border-b border-slate-100 flex flex-col space-y-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Matriks Izin</h3>
                        <p class="text-[10.5px] text-slate-400 mt-0.5">Pilih peran untuk menyesuaikan akses modul.</p>
                    </div>

                    {{-- Dynamic Tabs --}}
                    <div class="flex items-center justify-between border-b border-slate-100 -mx-6 px-6">
                        <div class="flex items-center gap-6 overflow-x-auto select-none">
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <button type="button" 
                                        @click="activeRole = roleName"
                                        :class="activeRole === roleName ? 'border-[#006240] text-[#006240] font-bold' : 'border-transparent text-slate-400 hover:text-slate-600'"
                                        class="py-3 px-1 border-b-2 text-xs font-semibold transition-all"
                                        x-text="roleName">
                                </button>
                            </template>
                        </div>
                        
                        {{-- Add Role Button --}}
                        <button type="button" 
                                @click="showAddRoleModal = true"
                                class="py-3 px-1 text-xs font-bold text-[#006240] hover:text-[#004d31] transition-colors flex items-center gap-1">
                            <span>+ Role Baru</span>
                        </button>
                    </div>
                </div>

                {{-- Table Matrix --}}
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider select-none">
                            <th class="py-3.5 px-6">Nama Modul</th>
                            
                            {{-- LIHAT Column --}}
                            <th class="py-3.5 px-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>Lihat</span>
                                </div>
                            </th>
                            
                            {{-- BUAT Column --}}
                            <th class="py-3.5 px-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Buat</span>
                                </div>
                            </th>
                            
                            {{-- UBAH Column --}}
                            <th class="py-3.5 px-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                    </svg>
                                    <span>Ubah</span>
                                </div>
                            </th>
                            
                            {{-- HAPUS Column --}}
                            <th class="py-3.5 px-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                    <span>Hapus</span>
                                </div>
                            </th>
                            
                            {{-- VALIDASI Column --}}
                            <th class="py-3.5 px-6 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Validasi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        
                        {{-- Row 1: Dashboard Utama --}}
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 flex-shrink-0 border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">Dashboard Utama</span>
                                        <span class="text-[10px] text-slate-400 block mt-0.5">Akses metrik dan ringkasan</span>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Checkboxes for Dashboard Utama --}}
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][dashboard][lihat]'" x-model="matrix[roleName].dashboard.lihat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][dashboard][buat]'" x-model="matrix[roleName].dashboard.buat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][dashboard][ubah]'" x-model="matrix[roleName].dashboard.ubah" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][dashboard][hapus]'" x-model="matrix[roleName].dashboard.hapus" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-6 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][dashboard][validasi]'" x-model="matrix[roleName].dashboard.validasi" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                        </tr>
                        
                        {{-- Row 2: Kelola Karyawan --}}
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 flex-shrink-0 border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">Kelola Karyawan</span>
                                        <span class="text-[10px] text-slate-400 block mt-0.5">Data master pegawai</span>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Checkboxes for Kelola Karyawan --}}
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][karyawan][lihat]'" x-model="matrix[roleName].karyawan.lihat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][karyawan][buat]'" x-model="matrix[roleName].karyawan.buat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][karyawan][ubah]'" x-model="matrix[roleName].karyawan.ubah" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][karyawan][hapus]'" x-model="matrix[roleName].karyawan.hapus" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-6 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][karyawan][validasi]'" x-model="matrix[roleName].karyawan.validasi" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                        </tr>
                        
                        {{-- Row 3: Formulir Penilaian --}}
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 flex-shrink-0 border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">Formulir Penilaian</span>
                                        <span class="text-[10px] text-slate-400 block mt-0.5">Template KPI & OKR</span>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Checkboxes for Formulir Penilaian --}}
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][formulir][lihat]'" x-model="matrix[roleName].formulir.lihat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][formulir][buat]'" x-model="matrix[roleName].formulir.buat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][formulir][ubah]'" x-model="matrix[roleName].formulir.ubah" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][formulir][hapus]'" x-model="matrix[roleName].formulir.hapus" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-6 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][formulir][validasi]'" x-model="matrix[roleName].formulir.validasi" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                        </tr>
                        
                        {{-- Row 4: Hasil Penilaian --}}
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 flex-shrink-0 border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">Hasil Penilaian</span>
                                        <span class="text-[10px] text-slate-400 block mt-0.5">Review skor final</span>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Checkboxes for Hasil Penilaian --}}
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][hasil][lihat]'" x-model="matrix[roleName].hasil.lihat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][hasil][buat]'" x-model="matrix[roleName].hasil.buat" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][hasil][ubah]'" x-model="matrix[roleName].hasil.ubah" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-4 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][hasil][hapus]'" x-model="matrix[roleName].hasil.hapus" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                            <template x-for="(roleData, roleName) in matrix" :key="roleName">
                                <td class="py-4 px-6 text-center font-semibold" x-show="activeRole === roleName">
                                    <input type="checkbox" :name="'matrix[' + roleName + '][hasil][validasi]'" x-model="matrix[roleName].hasil.validasi" class="w-4.5 h-4.5 rounded border-slate-200 text-[#006240] focus:ring-[#006240]/30 cursor-pointer"/>
                                </td>
                            </template>
                        </tr>

                    </tbody>
                </table>

            </div>

            {{-- Footer Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="/dashboard"
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
            
            {{-- Modal Header --}}
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-800">Tambah Peran Baru</h3>
                <button @click="showAddRoleModal = false" class="p-1 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                {{-- Modal Body --}}
                <div class="p-5 space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Peran (Role Name)</label>
                        <input type="text" name="new_role_name" required x-model="newRoleName" placeholder="Contoh: Supervisor" 
                               class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] transition-all"/>
                    </div>
                </div>
                
                {{-- Modal Footer --}}
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
