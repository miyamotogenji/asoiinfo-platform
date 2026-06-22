@if ($paginator->hasPages())
<nav class="flex items-center justify-between gap-4" aria-label="Pagination">
    <p class="text-xs" style="color:#6b7280">
        Mostrando {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de <strong class="text-gray-300">{{ $paginator->total() }}</strong> registros
    </p>
    <div class="flex items-center gap-1">
        {{-- Previous --}}
        @if($paginator->onFirstPage())
            <span class="px-3 py-1.5 text-xs rounded-lg" style="background:#0f1623;color:#374151;cursor:not-allowed">← Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 text-xs rounded-lg transition-colors" style="background:#1a2235;color:#9ca3af" onmouseover="this.style.background='#1e2a42'" onmouseout="this.style.background='#1a2235'">← Anterior</a>
        @endif

        {{-- Pages --}}
        @foreach($elements as $element)
            @if(is_string($element))
                <span class="px-2 text-xs" style="color:#4b5563">…</span>
            @endif
            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 text-xs rounded-lg font-semibold" style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 text-xs rounded-lg transition-colors" style="background:#1a2235;color:#9ca3af" onmouseover="this.style.background='#1e2a42'" onmouseout="this.style.background='#1a2235'">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 text-xs rounded-lg transition-colors" style="background:#1a2235;color:#9ca3af" onmouseover="this.style.background='#1e2a42'" onmouseout="this.style.background='#1a2235'">Siguiente →</a>
        @else
            <span class="px-3 py-1.5 text-xs rounded-lg" style="background:#0f1623;color:#374151;cursor:not-allowed">Siguiente →</span>
        @endif
    </div>
</nav>
@endif
