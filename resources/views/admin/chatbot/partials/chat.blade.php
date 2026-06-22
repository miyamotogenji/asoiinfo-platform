<input type="hidden" id="currentConvId" value="{{ $conversation->id }}">

{{-- Financial alert bar --}}
@if(in_array($conversation->financial_status, ['overdue', 'blocked']))
<div class="alert-bar">
    ⚠️ ALERTA:
    @if($conversation->financial_status === 'blocked')
        Cliente <strong>BLOQUEADO</strong> — soporte requiere autorización del administrador.
    @else
        Cliente <strong>VENCIDO</strong> — recordar estado financiero antes de atender.
    @endif
</div>
@endif

{{-- Chat header --}}
<div style="padding:12px 16px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;flex-shrink:0">
    <div>
        <strong>{{ $conversation->contact_name ?? $conversation->contact_phone }}</strong>
        <div style="font-size:.78rem;color:var(--muted)">
            {{ $conversation->contact_phone }}
            @if($conversation->branch)
                · {{ $conversation->branch->name }}
            @endif
        </div>
    </div>
    <div style="display:flex;gap:6px">
        @if($conversation->queue === 'new_messages' || $conversation->queue === 'new_prospects')
            <button onclick="attendConversation({{ $conversation->id }})" class="btn btn-success btn-sm">▶ Atender</button>
        @elseif($conversation->queue === 'in_progress')
            <button onclick="closeConversation({{ $conversation->id }})" class="btn btn-ghost btn-sm">✓ Finalizar</button>
            <button onclick="showTransfer({{ $conversation->id }})" class="btn btn-ghost btn-sm">→ Transferir</button>
        @endif
    </div>
</div>

{{-- Messages --}}
<div class="chat-area" id="chatArea">
    @forelse($conversation->messages()->orderBy('created_at')->get() as $msg)
        @if($msg->is_internal_note)
            <div class="bubble note">📝 Nota interna: {{ $msg->body }}</div>
        @elseif($msg->direction === 'inbound')
            <div class="bubble in">
                {{ $msg->body }}
                <time>{{ $msg->created_at->format('d/m H:i') }}</time>
            </div>
        @else
            <div class="bubble out">
                {{ $msg->body }}
                <time>{{ $msg->created_at->format('d/m H:i') }} · {{ $msg->sender?->name ?? 'Asesor' }}</time>
            </div>
        @endif
    @empty
        <div class="empty-state">
            <div class="icon">💬</div>
            <div>Sin mensajes aún</div>
        </div>
    @endforelse
</div>

{{-- Input bar --}}
<div class="chat-input">
    <div class="chat-input-row">
        <textarea id="msgInput" placeholder="Escribe un mensaje... (Enter para enviar, Shift+Enter para salto de línea)"></textarea>
        <button onclick="sendMessage()" class="btn btn-primary">Enviar</button>
    </div>
    <div style="display:flex;gap:6px;margin-top:6px">
        <button class="btn btn-ghost btn-sm" onclick="sendInvoiceModal()">📄 Enviar factura</button>
        <button class="btn btn-ghost btn-sm" onclick="addNote()">📝 Nota interna</button>
        <label class="btn btn-ghost btn-sm" style="cursor:pointer">
            📎 Archivo
            <input type="file" style="display:none" onchange="uploadFile(this)">
        </label>
    </div>
</div>

<script>
// Scroll to bottom on load
document.getElementById('chatArea').scrollTop = 99999;

function addNote() {
    const note = prompt('Nota interna (solo visible para asesores):');
    if (!note) return;
    const convId = document.getElementById('currentConvId').value;
    fetch('/api/v1/whatsapp/send', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
        body: JSON.stringify({ conversation_id: convId, body: note, is_note: true })
    }).then(() => loadConversation(convId));
}

function showTransfer(convId) {
    const agentId = prompt('ID del asesor al que transferir:');
    if (!agentId) return;
    fetch(`/api/v1/whatsapp/conversations/${convId}/transfer`, {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
        body: JSON.stringify({ agent_id: agentId })
    }).then(() => loadConversation(convId));
}
</script>
