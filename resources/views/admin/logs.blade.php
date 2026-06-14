<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Activity Log – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

{{-- ─── Sidebar ────────────────────────────────────────── --}}
<x-sidebar :active="'logs'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Activity Log</span>
        <button class="relative p-2 rounded-lg hover:bg-slate-50 transition-colors">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
        </button>
    </header>

    {{-- Main Container --}}
    <main class="flex-1 p-8 space-y-6">

        {{-- Breadcrumbs --}}
        <div class="flex items-center gap-2 text-xs font-semibold text-[#006240]/80">
            <span class="text-slate-400">Pengaturan</span>
            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
            <span>Activity Log</span>
        </div>

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Audit Trail / Activity Log</h1>
            <p class="text-sm text-slate-400 mt-0.5">Pantau semua perubahan data dan aktivitas akses pengguna secara real-time.</p>
        </div>

        {{-- Log Table --}}
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Log Riwayat Sistem</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3.5 px-6 w-1/4">User</th>
                            <th class="py-3.5 px-6 w-2/5">Aktivitas</th>
                            <th class="py-3.5 px-6">Modul</th>
                            <th class="py-3.5 px-6">IP Address</th>
                            <th class="py-3.5 px-6 text-right">Tanggal &amp; Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="py-3.5 px-6 font-semibold text-slate-800">
                                <div>
                                    <p class="font-bold text-slate-950">{{ $log->user_name ?? 'System' }}</p>
                                    <p class="text-[10px] text-slate-400 font-normal mt-0.5">{{ $log->user_email ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td class="py-3.5 px-6 text-slate-600 font-medium">
                                <span class="block max-w-md break-words">{{ $log->activity }}</span>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[10px] font-semibold">
                                    {{ $log->module ?? 'Sistem' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-400">{{ $log->ip_address ?? '127.0.0.1' }}</td>
                            <td class="py-3.5 px-6 text-right text-slate-400 font-medium">
                                {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i:s') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                Belum ada riwayat aktivitas yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50/20 text-xs text-slate-500">
                <div>
                    Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} log
                </div>
                <div class="flex gap-2">
                    {{-- Previous Page --}}
                    @if ($logs->onFirstPage())
                        <span class="px-3 py-1.5 border border-slate-200 bg-slate-50 text-slate-400 rounded-xl cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 rounded-xl">Sebelumnya</a>
                    @endif

                    {{-- Next Page --}}
                    @if ($logs->hasMorePages())
                        <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 rounded-xl">Berikutnya</a>
                    @else
                        <span class="px-3 py-1.5 border border-slate-200 bg-slate-50 text-slate-400 rounded-xl cursor-not-allowed">Berikutnya</span>
                    @endif
                </div>
            </div>
            @endif
        </div>

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2026 PerformancePro Inc.</p>
        <div class="flex gap-4">
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Privacy</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Terms</a>
            <a href="#" class="text-xs text-gray-400 hover:text-[#006240]">Support</a>
        </div>
    </footer>

</div>

</body>
</html>
