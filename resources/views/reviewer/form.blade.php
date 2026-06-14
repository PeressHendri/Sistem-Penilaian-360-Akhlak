<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Isi Penilaian – PerformancePro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background: #f8fafc; }
    </style>
</head>
<body class="flex min-h-screen text-slate-700">

<x-sidebar :active="'assessments'"/>

<div class="ml-60 flex-1 flex flex-col min-h-screen">
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-20">
        <div class="flex items-center space-x-2">
            <a href="{{ route('reviewer.assessments.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <span class="text-base font-bold text-[#006240]">PerformancePro</span>
        </div>
        <div id="save-indicator" class="text-xs text-slate-400 font-medium opacity-0 transition-opacity">
            Semua draf tersimpan secara otomatis
        </div>
    </header>

    <main class="flex-1 p-8 max-w-4xl w-full mx-auto space-y-6">
        
        {{-- Stepper Progress Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Stepper box --}}
            <div class="md:col-span-2 bg-white border border-slate-150 rounded-2xl p-6 shadow-xs flex items-center justify-center">
                <div class="flex items-center w-full max-w-lg justify-between relative">
                    <!-- Background Connecting Line -->
                    <div class="absolute top-5 left-0 right-0 h-0.5 bg-slate-100 -z-0"></div>
                    <!-- Active Connecting Line (1 to 2) -->
                    <div class="absolute top-5 left-0 w-1/3 h-0.5 bg-[#006240] -z-0"></div>
                    
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold bg-[#e6f4ea] text-[#137333]">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-[10px] font-bold mt-2 text-slate-400">Persiapan</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold bg-[#006240] text-white ring-4 ring-[#e6f4ea]">
                            <span>2</span>
                        </div>
                        <span class="text-[10px] font-bold mt-2 text-[#006240]">Input Skor</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold border bg-white text-slate-400 border-slate-200">
                            <span>3</span>
                        </div>
                        <span class="text-[10px] font-bold mt-2 text-slate-400">Review</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold border bg-white text-slate-400 border-slate-200">
                            <span>4</span>
                        </div>
                        <span class="text-[10px] font-bold mt-2 text-slate-400">Submit</span>
                    </div>
                </div>
            </div>

            {{-- Progress box --}}
            <div class="bg-white border border-slate-150 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Progres</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tahap 2 dari 4</span>
                </div>
                <div class="my-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-slate-800 tracking-tight">50%</span>
                    <span class="text-xs font-bold text-slate-400">Selesai</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-[#006240] w-1/2 h-full rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Ratee Profile Header -->
        <div class="bg-white border border-slate-150 p-6 rounded-2xl shadow-xs flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Menilai Karyawan</span>
                <h1 class="text-lg font-bold text-slate-900">{{ $reviewerRow->ratee_nama }}</h1>
                <p class="text-xs text-slate-500 font-semibold">{{ $reviewerRow->ratee_jabatan }} • {{ $reviewerRow->ratee_divisi }}</p>
            </div>
            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded-full font-bold text-xs bg-emerald-50 text-emerald-800">
                    Sebagai: {{ $reviewerRow->tipe_penilai }}
                </span>
                <p class="text-[10px] text-slate-400 mt-1.5 font-medium">Batas Waktu: {{ \Carbon\Carbon::parse($reviewerRow->tanggal_selesai)->format('d M Y') }}</p>
            </div>
        </div>

        <form action="{{ route('reviewer.assessments.submit', $form->id) }}" method="POST" id="assessment-form">
            @csrf
            
            <div class="space-y-8">
                @foreach($groupedIndicators as $groupName => $group)
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-[#006240]/10 flex items-center justify-center font-bold text-xs text-[#006240]">
                            {{ $group['kode'] }}
                        </div>
                        <div>
                            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">{{ $groupName }}</h2>
                            <p class="text-[10px] text-slate-400 mt-0.5">Indikator core value budaya perusahaan.</p>
                        </div>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($group['items'] as $item)
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-start">
                                <div class="space-y-1 max-w-xl">
                                    <h3 class="text-xs font-bold text-slate-800">{{ $item['nama'] }}</h3>
                                    <p class="text-[11px] text-slate-400 leading-relaxed">{{ $item['deskripsi'] }}</p>
                                </div>
                                <span class="text-[10px] text-slate-400 font-mono font-bold">Bobot: {{ $item['bobot'] }}%</span>
                            </div>

                            <!-- Rating options 1 to 5 -->
                            <div class="flex items-center space-x-6">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Skor:</span>
                                <div class="flex items-center space-x-3">
                                    @for($i = 1; $i <= 5; $i++)
                                    <label class="flex items-center justify-center w-10 h-10 border border-slate-100 rounded-xl cursor-pointer transition-all hover:bg-slate-50 relative group
                                        {{ $item['score'] == $i ? 'bg-[#006240]/10 border-[#006240] text-[#006240] font-black' : 'bg-slate-50/30 text-slate-600' }}">
                                        <input type="radio" name="scores[{{ $item['id'] }}]" value="{{ $i }}" 
                                               class="hidden score-radio" {{ $item['score'] == $i ? 'checked' : '' }}
                                               {{ $isSubmitted ? 'disabled' : '' }}/>
                                        <span class="text-xs select-none">{{ $i }}</span>
                                    </label>
                                    @endfor
                                </div>
                            </div>

                            <!-- Comments -->
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Catatan Perilaku / Komentar Tambahan</label>
                                <textarea name="comments[{{ $item['id'] }}]" rows="2" placeholder="Tuliskan bukti perilaku nyata karyawan..."
                                          class="w-full px-3.5 py-2 text-xs border border-slate-100 rounded-xl bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-[#006240] outline-none transition-all resize-none comment-textarea"
                                          {{ $isSubmitted ? 'disabled' : '' }}>{{ $item['comment'] }}</textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            @if(!$isSubmitted)
            <div class="flex items-center justify-end space-x-4 pt-6">
                <button type="button" onclick="history.back()" class="px-6 py-2.5 text-xs text-slate-500 hover:text-slate-700 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-[#006240] hover:bg-[#004d32] text-white font-bold rounded-xl transition-all shadow-sm hover:shadow text-xs">
                    Kirim &amp; Finalisasi Penilaian
                </button>
            </div>
            @endif
        </form>
    </main>

    <footer class="bg-white border-t border-gray-100 px-8 py-3 flex items-center justify-between mt-auto">
        <p class="text-xs text-gray-400">© 2026 PerformancePro Inc.</p>
    </footer>
</div>

<script>
    @if(!$isSubmitted)
    // Auto-save draft via AJAX
    const saveIndicator = document.getElementById('save-indicator');
    const form = document.getElementById('assessment-form');

    function saveDraft() {
        saveIndicator.style.opacity = '1';
        saveIndicator.innerText = 'Menyimpan draf...';

        const formData = new FormData(form);
        fetch('{{ route('reviewer.assessments.save', $form->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            saveIndicator.innerText = 'Semua perubahan draf disimpan';
            setTimeout(() => {
                saveIndicator.style.opacity = '0';
            }, 2000);
        })
        .catch(error => {
            saveIndicator.innerText = 'Gagal menyimpan otomatis';
        });
    }

    // Attach listeners for auto save
    document.querySelectorAll('.score-radio').forEach(radio => {
        radio.addEventListener('change', (e) => {
            // Style radio wrappers
            const name = radio.getAttribute('name');
            document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
                const label = r.closest('label');
                label.className = 'flex items-center justify-center w-10 h-10 border border-slate-100 rounded-xl cursor-pointer transition-all hover:bg-slate-50 relative group bg-slate-50/30 text-slate-600';
            });
            const activeLabel = radio.closest('label');
            activeLabel.className = 'flex items-center justify-center w-10 h-10 border border-[#006240] rounded-xl cursor-pointer transition-all bg-[#006240]/10 text-[#006240] font-black relative group';

            saveDraft();
        });
    });

    let typingTimer;
    document.querySelectorAll('.comment-textarea').forEach(textarea => {
        textarea.addEventListener('input', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(saveDraft, 1500);
        });
    });
    @endif
</script>
</body>
</html>
