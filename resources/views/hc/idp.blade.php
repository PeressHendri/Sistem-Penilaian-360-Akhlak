<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Individual Development Plan (IDP) – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700" x-data="{ openModal: false, activeIdp: { employee_id: '', program_id: '', nama: '', target_kompetensi: '', rencana_aksi: '', timeline: '', status: 'Rencana' } }">

<x-sidebar :active="'idp'"/>

<div class="ml-60 flex-1 flex flex-col min-h-screen">
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <span class="text-sm font-semibold text-[#006240]">Individual Development Plan (IDP)</span>
    </header>

    <main class="flex-1 p-8 max-w-5xl w-full mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Individual Development Plan (IDP)</h1>
            <p class="text-sm text-slate-400 mt-0.5">Rencana pengembangan kompetensi individu berkelanjutan bagi setiap karyawan berdasarkan hasil evaluasi.</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-800 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Rencana Pengembangan</h2>
            </div>
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-6">NIK</th>
                        <th class="py-3.5 px-6">Karyawan</th>
                        <th class="py-3.5 px-6">Kuadran Talenta</th>
                        <th class="py-3.5 px-6">Target Kompetensi &amp; Rencana</th>
                        <th class="py-3.5 px-6">Timeline</th>
                        <th class="py-3.5 px-6">Status IDP</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($employeeList as $row)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="py-4 px-6 text-slate-400 font-mono">{{ $row->nik }}</td>
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-900">{{ $row->nama }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $row->jabatan }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-block px-2.5 py-0.5 rounded-full font-bold text-[10px]
                                {{ $row->kategori === 'Star' ? 'bg-emerald-100 text-emerald-800' : ($row->kategori === 'Core' ? 'bg-sky-100 text-sky-800' : ($row->kategori === 'Need Improvement' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800')) }}">
                                {{ $row->kategori }}
                            </span>
                        </td>
                        <td class="py-4 px-6 max-w-xs">
                            @if($row->idp)
                                <p class="font-semibold text-slate-800">{{ $row->idp->target_kompetensi }}</p>
                                <p class="text-[10px] text-slate-400 mt-1 line-clamp-2">{{ $row->idp->rencana_aksi }}</p>
                            @else
                                <span class="text-slate-400 italic">Belum disusun</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-semibold text-slate-600">
                            {{ $row->idp ? $row->idp->timeline : '-' }}
                        </td>
                        <td class="py-4 px-6">
                            @if($row->idp)
                                <span class="inline-block px-2 py-0.5 rounded-full font-bold text-[10px]
                                    {{ $row->idp->status === 'Selesai' ? 'bg-emerald-100 text-emerald-800' : ($row->idp->status === 'Sedang Berjalan' ? 'bg-sky-100 text-sky-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $row->idp->status }}
                                </span>
                            @else
                                <span class="text-slate-300">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <button 
                                @click="activeIdp = { 
                                    employee_id: '{{ $row->employee_id }}', 
                                    program_id: '{{ $row->program_id }}', 
                                    nama: '{{ $row->nama }}', 
                                    target_kompetensi: '{{ $row->idp ? $row->idp->target_kompetensi : '' }}', 
                                    rencana_aksi: '{{ $row->idp ? $row->idp->rencana_aksi : '' }}', 
                                    timeline: '{{ $row->idp ? $row->idp->timeline : '' }}', 
                                    status: '{{ $row->idp ? $row->idp->status : 'Rencana' }}' 
                                }; openModal = true"
                                class="px-3 py-1.5 bg-[#006240] hover:bg-[#004d32] text-white font-bold rounded-xl transition-all shadow-sm hover:shadow text-[10px]">
                                {{ $row->idp ? 'Edit IDP' : 'Susun IDP' }}
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400 italic">Belum ada karyawan yang dinilai dan dipetakan. Silakan isi form penilaian terlebih dahulu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Form Susun IDP -->
    <div x-show="openModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50" x-cloak>
        <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl border border-slate-100" @click.outside="openModal = false">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-950">Form Rencana Pengembangan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Menyusun rencana aksi IDP untuk <span class="font-bold text-slate-700" x-text="activeIdp.nama"></span></p>
                </div>
                <button @click="openModal = false" class="p-1 rounded-lg hover:bg-slate-50 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('hc.idp.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="employee_id" :value="activeIdp.employee_id"/>
                <input type="hidden" name="program_id" :value="activeIdp.program_id"/>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Target Kompetensi</label>
                    <input type="text" name="target_kompetensi" x-model="activeIdp.target_kompetensi" required placeholder="Contoh: Meningkatkan skill Agile Project Management"
                           class="w-full px-3.5 py-2 text-xs border border-slate-100 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-[#006240] outline-none transition-all"/>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rencana Aksi</label>
                    <textarea name="rencana_aksi" x-model="activeIdp.rencana_aksi" required rows="4" placeholder="Detail pelatihan, sertifikasi, mentoring, dsb..."
                              class="w-full px-3.5 py-2 text-xs border border-slate-100 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-[#006240] outline-none transition-all resize-none"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Timeline</label>
                        <input type="text" name="timeline" x-model="activeIdp.timeline" required placeholder="Contoh: Q3 2026"
                               class="w-full px-3.5 py-2 text-xs border border-slate-100 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-[#006240] outline-none transition-all"/>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</label>
                        <select name="status" x-model="activeIdp.status" required
                                class="w-full px-3.5 py-2 text-xs border border-slate-100 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-[#006240] outline-none transition-all">
                            <option value="Rencana">Rencana</option>
                            <option value="Sedang Berjalan">Sedang Berjalan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-50">
                    <button type="button" @click="openModal = false" class="px-4 py-2 text-xs text-slate-500 hover:text-slate-700 transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#006240] hover:bg-[#004d32] text-white font-bold rounded-xl transition-all shadow-sm hover:shadow text-xs">Simpan Rencana</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2026 PerformancePro Inc.</p>
    </footer>
</div>
</body>
</html>
