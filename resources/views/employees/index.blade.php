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
        body { background: #f3f4f6; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 9px; }
        .emp-card { transition: box-shadow .18s, transform .18s; }
        .emp-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.09); transform: translateY(-2px); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex min-h-screen">

{{-- ─── Sidebar ────────────────────────────────────────── --}}
<x-sidebar :active="'employees'"/>

{{-- ─── Main ───────────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Kelola Karyawan</span>
        <button class="relative p-2 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Content --}}
    <main class="flex-1 p-8">

        {{-- ── Page Header ───────────────────────────── --}}
        <div class="flex items-start justify-between mb-7">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 leading-tight">Kelola Karyawan</h1>
                <p class="text-sm text-gray-400 mt-0.5">
                    Manage and view all employee records within the organization.
                </p>
            </div>
            {{-- Search + Filter --}}
            <div class="flex items-center gap-2 mt-1">
                <form method="GET" action="/employees" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Search by name or NIK..."
                           class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#006240]/30 focus:border-[#006240] w-52 transition-all"/>
                </form>
                <button class="flex items-center gap-1.5 px-3 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
                    </svg>
                    Filters
                </button>
            </div>
        </div>

        {{-- ── Employee Cards ────────────────────────── --}}
        @php
        $avatarPalette = [
            ['bg' => 'bg-slate-200',   'text' => 'text-slate-600'],
            ['bg' => 'bg-sky-100',     'text' => 'text-sky-600'],
            ['bg' => 'bg-violet-100',  'text' => 'text-violet-600'],
            ['bg' => 'bg-amber-100',   'text' => 'text-amber-600'],
            ['bg' => 'bg-rose-100',    'text' => 'text-rose-600'],
            ['bg' => 'bg-teal-100',    'text' => 'text-teal-600'],
        ];
        @endphp

        <div class="grid grid-cols-3 gap-5">
            @forelse ($employees as $i => $emp)
            @php
                $isAktif  = $emp->status === 'Aktif';
                $words    = explode(' ', $emp->nama);
                $initials = strtoupper(($words[0][0] ?? '') . (isset($words[1]) ? $words[1][0] : ''));
                $pal      = $avatarPalette[$i % count($avatarPalette)];
            @endphp

            <div class="emp-card bg-white rounded-2xl border border-gray-100 shadow-sm p-5 relative" x-data="{ open: false }" @click.outside="open = false">

                {{-- ── 3-dot menu ─────────────────── --}}
                <button @click.stop="open = !open"
                        class="absolute top-4 right-4 p-1 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div x-show="open" x-cloak
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-10 right-4 w-36 bg-white border border-gray-100 rounded-xl shadow-lg z-20 py-1 text-xs">
                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:bg-gray-50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg> Lihat Detail
                    </a>
                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:bg-gray-50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                        </svg> Edit
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <button class="flex items-center gap-2 w-full px-3 py-2 text-red-500 hover:bg-red-50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg> Hapus
                    </button>
                </div>

                {{-- ── Avatar ──────────────────────── --}}
                <div class="flex items-start gap-3 mb-3">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-full {{ $pal['bg'] }} {{ $pal['text'] }} flex items-center justify-center text-sm font-bold flex-shrink-0 select-none">
                            {{ $initials }}
                        </div>
                        @if ($isAktif)
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                        @endif
                    </div>
                </div>

                {{-- ── Status Badge ─────────────────── --}}
                @if ($isAktif)
                <span class="absolute top-14 right-4 inline-block px-2 py-0.5 bg-[#006240] text-white text-[10px] font-semibold rounded-full">
                    Aktif
                </span>
                @else
                <span class="absolute top-14 right-4 inline-flex items-center gap-1 px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-semibold rounded-full">
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> Non-Aktif
                </span>
                @endif

                {{-- ── Name & NIK ───────────────────── --}}
                <p class="text-sm font-bold text-gray-900">{{ $emp->nama }}</p>
                <p class="text-xs text-gray-400 mb-3">NIK: {{ $emp->nik }}</p>

                <div class="border-t border-gray-50 mb-3"></div>

                {{-- ── Jabatan & Divisi ─────────────── --}}
                <div class="space-y-1.5">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/>
                        </svg>
                        <span class="text-xs text-gray-500">{{ $emp->jabatan }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/>
                        </svg>
                        <span class="text-xs text-gray-500">{{ $emp->divisi }}</span>
                    </div>
                </div>

            </div>{{-- /card --}}
            @empty
            <div class="col-span-3 flex flex-col items-center justify-center py-24 text-center">
                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-3">
                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Belum ada karyawan</p>
                <p class="text-xs text-gray-400 mt-1">Tambah karyawan pertama Anda sekarang</p>
            </div>
            @endforelse
        </div>

        {{-- ── FAB: Tambah Karyawan ─────────────────── --}}
        <a href="#"
           class="fixed bottom-8 right-8 inline-flex items-center gap-2 px-5 py-3 bg-[#006240] hover:bg-[#004d31] text-white text-sm font-semibold rounded-full shadow-lg hover:shadow-xl transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Karyawan
        </a>

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2025 PerformancePro Inc.</p>
        <div class="flex gap-4">
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Privacy</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Terms</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Support</a>
        </div>
    </footer>

</div>{{-- /Main --}}

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
