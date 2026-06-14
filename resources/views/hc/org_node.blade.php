<li>
    <div class="tree-card bg-white border border-slate-100 p-3.5 rounded-2xl shadow-xs w-44 text-center">
        <p class="font-bold text-xs text-slate-800 truncate" title="{{ $node->nama }}">{{ $node->nama }}</p>
        <p class="text-[10px] text-slate-400 mt-0.5 font-medium truncate" title="{{ $node->jabatan }}">{{ $node->jabatan }}</p>
        <span class="inline-block mt-2 px-2 py-0.5 bg-green-50 text-[#006240] text-[9px] font-bold rounded-lg">
            {{ $node->divisi }}
        </span>
    </div>
    @if($node->bawahan && $node->bawahan->count() > 0)
        <ul>
            @foreach($node->bawahan as $child)
                @include('hc.org_node', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>
