<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Score Detail – PerformancePro</title>
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
        /* Custom range slider styling */
        .custom-slider {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 8px;
            border-radius: 9999px;
            outline: none;
            transition: background 0.15s ease-in-out;
        }
        .custom-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #006847;
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 4px rgba(0, 104, 71, 0.3);
            transition: transform 0.1s ease;
        }
        .custom-slider::-webkit-slider-thumb:hover {
            transform: scale(1.1);
        }
        .custom-slider::-moz-range-thumb {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #006847;
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 4px rgba(0, 104, 71, 0.3);
            transition: transform 0.1s ease;
        }
        .custom-slider::-moz-range-thumb:hover {
            transform: scale(1.1);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex min-h-screen text-slate-800">

{{-- Sidebar --}}
<x-sidebar :active="'scores'"/>

{{-- Main Content area --}}
<div class="ml-60 flex-1 flex flex-col min-h-screen"
     x-data="{
         design_system: {{ $scores['design_system'] ?? 8 }},
         prototyping_speed: {{ $scores['prototyping_speed'] ?? 9 }},
         teamwork: {{ $scores['teamwork'] ?? 7 }},
         
         get averageScore() {
             let avg = (this.design_system + this.prototyping_speed + this.teamwork) / 3;
             return avg.toFixed(1);
         },
         
         get performanceLabel() {
             let avg = parseFloat(this.averageScore);
             if (avg >= 8.0) return 'Exceeds Expectations';
             if (avg >= 6.0) return 'Meets Expectations';
             return 'Needs Improvement';
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
    <main class="flex-1 p-8 max-w-4xl w-full mx-auto space-y-8">
        
        {{-- Profile and Score widget --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
            
            {{-- Sarah Jenkins profile card --}}
            <div class="md:col-span-2 bg-white rounded-xl border border-slate-200/80 p-6 shadow-xs flex items-center gap-5 border-t-4 border-t-[#006847]">
                <img src="{{ $ratee->avatar_url ?? 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150' }}" 
                     alt="{{ $ratee->nama }}" 
                     class="w-20 h-20 rounded-full object-cover border-2 border-slate-100 select-none"/>
                
                <div class="space-y-1.5">
                    <h2 class="text-xl font-bold text-slate-800 leading-tight">{{ $ratee->nama }}</h2>
                    <p class="text-xs font-medium text-slate-500">{{ $ratee->jabatan }} &bull; {{ $ratee->divisi }}</p>
                    <div class="flex flex-wrap items-center gap-2 pt-1.5">
                        <span class="px-2.5 py-0.5 bg-emerald-50 text-[#006847] text-[10px] font-bold rounded-full border border-emerald-100">
                            Q3 Review
                        </span>
                        <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded-full border border-indigo-100">
                            Self-Assessment Complete
                        </span>
                    </div>
                </div>
            </div>

            {{-- Overall score card --}}
            <div class="bg-[#005c3e] text-white rounded-xl p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-200 block">Overall Score</span>
                    <div class="flex items-baseline gap-1.5 mt-2">
                        <span class="text-4xl font-extrabold tracking-tight" x-text="averageScore">8.4</span>
                        <span class="text-sm font-medium text-emerald-200/80">/ 10</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10">
                    <span class="text-xs font-semibold text-emerald-100" x-text="performanceLabel">Exceeds Expectations</span>
                </div>
            </div>

        </div>

        {{-- Assessment Form --}}
        <form method="POST" action="{{ route('scores.store') }}" class="space-y-8">
            @csrf
            <input type="hidden" name="action" id="formAction" value="submit" />

            {{-- 1. Technical Competency --}}
            <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-[#f8fafc] border-b border-slate-200/60 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#006847] flex items-center justify-center flex-shrink-0 border border-emerald-100">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 tracking-wide uppercase">Technical Competency</h3>
                </div>

                <div class="p-6 space-y-8">
                    
                    {{-- Design System Implementation --}}
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Design System Implementation</h4>
                                <p class="text-xs text-slate-400 mt-1">Adherence to established design tokens and component structures.</p>
                            </div>
                            <div class="w-12 h-10 border border-slate-200 bg-[#f8fafc] rounded-lg flex items-center justify-center shadow-xs">
                                <span class="text-sm font-bold text-[#006847]" x-text="design_system">8</span>
                            </div>
                        </div>

                        {{-- Range Slider --}}
                        <div class="pt-2">
                            <input type="range" 
                                   name="design_system"
                                   x-model.number="design_system"
                                   min="0" max="10" step="1"
                                   :style="`background: linear-gradient(to right, #006847 0%, #006847 ${design_system * 10}%, #e2e8f0 ${design_system * 10}%, #e2e8f0 100%)`"
                                   class="custom-slider"/>
                            <div class="flex justify-between text-[11px] text-slate-400 font-semibold mt-1 px-1 select-none">
                                <span>0</span>
                                <span>5</span>
                                <span>10</span>
                            </div>
                        </div>

                        {{-- Evidence & Notes --}}
                        <div class="space-y-1.5 pt-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                                </svg>
                                <span>Evidence & Notes</span>
                            </label>
                            <textarea name="design_system_notes" 
                                      placeholder="Detail specific examples or projects..." 
                                      class="w-full min-h-[80px] p-3.5 text-xs text-slate-700 bg-[#f8fafc] border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all resize-y">{{ $scores['design_system_notes'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 my-4"></div>

                    {{-- Prototyping Speed --}}
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Prototyping Speed</h4>
                                <p class="text-xs text-slate-400 mt-1">Ability to deliver high-fidelity prototypes within sprint timelines.</p>
                            </div>
                            <div class="w-12 h-10 border border-slate-200 bg-[#f8fafc] rounded-lg flex items-center justify-center shadow-xs">
                                <span class="text-sm font-bold text-[#006847]" x-text="prototyping_speed">9</span>
                            </div>
                        </div>

                        {{-- Range Slider --}}
                        <div class="pt-2">
                            <input type="range" 
                                   name="prototyping_speed"
                                   x-model.number="prototyping_speed"
                                   min="0" max="10" step="1"
                                   :style="`background: linear-gradient(to right, #006847 0%, #006847 ${prototyping_speed * 10}%, #e2e8f0 ${prototyping_speed * 10}%, #e2e8f0 100%)`"
                                   class="custom-slider"/>
                            <div class="flex justify-between text-[11px] text-slate-400 font-semibold mt-1 px-1 select-none">
                                <span>0</span>
                                <span>5</span>
                                <span>10</span>
                            </div>
                        </div>

                        {{-- Evidence & Notes --}}
                        <div class="space-y-1.5 pt-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                                </svg>
                                <span>Evidence & Notes</span>
                            </label>
                            <textarea name="prototyping_speed_notes" 
                                      placeholder="Detail specific examples or projects..." 
                                      class="w-full min-h-[80px] p-3.5 text-xs text-slate-700 bg-[#f8fafc] border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all resize-y">{{ $scores['prototyping_speed_notes'] ?? '' }}</textarea>
                        </div>
                    </div>

                </div>
            </div>

            {{-- 2. Communication & Collaboration --}}
            <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-[#f8fafc] border-b border-slate-200/60 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0 border border-sky-100">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 tracking-wide uppercase">Communication & Collaboration</h3>
                </div>

                <div class="p-6 space-y-8">
                    
                    {{-- Cross-functional Teamwork --}}
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Cross-functional Teamwork</h4>
                                <p class="text-xs text-slate-400 mt-1">Effectiveness in working with Engineering and PMs.</p>
                            </div>
                            <div class="w-12 h-10 border border-slate-200 bg-[#f8fafc] rounded-lg flex items-center justify-center shadow-xs">
                                <span class="text-sm font-bold text-[#006847]" x-text="teamwork">7</span>
                            </div>
                        </div>

                        {{-- Range Slider --}}
                        <div class="pt-2">
                            <input type="range" 
                                   name="teamwork"
                                   x-model.number="teamwork"
                                   min="0" max="10" step="1"
                                   :style="`background: linear-gradient(to right, #006847 0%, #006847 ${teamwork * 10}%, #e2e8f0 ${teamwork * 10}%, #e2e8f0 100%)`"
                                   class="custom-slider"/>
                            <div class="flex justify-between text-[11px] text-slate-400 font-semibold mt-1 px-1 select-none">
                                <span>0</span>
                                <span>5</span>
                                <span>10</span>
                            </div>
                        </div>

                        {{-- Evidence & Notes --}}
                        <div class="space-y-1.5 pt-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                                </svg>
                                <span>Evidence & Notes</span>
                            </label>
                            <textarea name="teamwork_notes" 
                                      placeholder="Detail specific examples or projects..." 
                                      class="w-full min-h-[80px] p-3.5 text-xs text-slate-700 bg-[#f8fafc] border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#006847]/20 focus:border-[#006847] transition-all resize-y">{{ $scores['teamwork_notes'] ?? '' }}</textarea>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Footer Action Buttons --}}
            <div class="border-t border-slate-200 pt-6 flex items-center justify-end gap-3 select-none">
                <button type="submit" 
                        onclick="document.getElementById('formAction').value = 'draft';"
                        class="px-5 py-2.5 border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-all shadow-xs active:scale-98">
                    Save as Draft
                </button>
                
                <button type="submit" 
                        onclick="document.getElementById('formAction').value = 'submit';"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#006847] hover:bg-[#005036] text-white text-xs font-semibold rounded-lg shadow-xs transition-all active:scale-98">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Submit Assessment</span>
                </button>
            </div>

        </form>

    </main>

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
