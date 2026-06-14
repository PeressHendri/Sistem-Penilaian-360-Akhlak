<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Struktur Organisasi – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }
        
        /* Organization Tree Styles */
        .tree ul {
            padding-top: 20px; position: relative;
            transition: all 0.5s;
        }
        .tree li {
            float: left; text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
            transition: all 0.5s;
        }
        .tree li::before, .tree li::after{
            content: '';
            position: absolute; top: 0; right: 50%;
            border-t: 1px solid #cbd5e1;
            width: 50%; height: 20px;
        }
        .tree li::after{
            right: auto; left: 50%;
            border-l: 1px solid #cbd5e1;
        }
        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }
        .tree li:only-child{ padding-top: 0; }
        .tree li:first-child::before, .tree li:last-child::after{
            border: 0 none;
        }
        .tree li:last-child::before{
            border-r: 1px solid #cbd5e1;
            border-radius: 0 5px 0 0;
        }
        .tree li:first-child::after{
            border-radius: 5px 0 0 0;
        }
        .tree ul ul::before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-l: 1px solid #cbd5e1;
            width: 0; height: 20px;
        }
        .tree-card {
            display: inline-block;
            transition: all 0.2s;
        }
        .tree-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

{{-- ─── Sidebar ────────────────────────────────────────── --}}
<x-sidebar :active="'org_chart'"/>

{{-- ─── Main Content ────────────────────────────────────── --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen">

    {{-- Top Bar --}}
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Struktur Organisasi</span>
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

        {{-- Hero Header --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Struktur Organisasi</h1>
            <p class="text-sm text-slate-400 mt-0.5">Visualisasikan hubungan kerja dan jenjang atasan-bawahan untuk penilai otomatis.</p>
        </div>

        {{-- Tree Layout Card --}}
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 overflow-auto min-h-[500px] flex items-center justify-center">
            
            <div class="tree select-none">
                <ul>
                    @foreach($roots as $root)
                        @include('hc.org_node', ['node' => $root])
                    @endforeach
                </ul>
            </div>
            
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
