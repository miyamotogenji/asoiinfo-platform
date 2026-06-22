<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\WhatsappNumber;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'soporte');

        $inbox = [
            'soporte'     => Conversation::with([
                'messages' => fn($q) => $q->latest()->limit(1),
                'branch', 'businessGroup',
            ])->where('queue', 'new_messages')->latest()->get(),

            'en_atencion' => Conversation::with([
                'assignedAgent',
                'messages' => fn($q) => $q->latest()->limit(1),
                'branch',
            ])->where('queue', 'in_progress')->latest()->get(),

            'ventas'      => Conversation::with([
                'messages' => fn($q) => $q->latest()->limit(1),
                'branch', 'businessGroup',
            ])->where('queue', 'new_prospects')->latest()->get(),
        ];

        $numbers          = WhatsappNumber::where('is_active', true)->get();
        $activeConvId     = $request->conv;
        $activeConversation = null;

        if ($activeConvId) {
            $activeConversation = Conversation::with([
                'messages.sender',
                'contact',
                'branch.contractedServices.plan',
                'branch.accountsReceivable' => fn($q) => $q->whereIn('status', ['pending','overdue','partial'])->latest()->limit(3),
                'businessGroup',
                'assignedAgent',
                'whatsappNumber',
            ])->find($activeConvId);
        }

        return view('admin.chatbot.index', compact(
            'inbox', 'numbers', 'activeConvId', 'activeConversation', 'tab'
        ));
    }

    public function attend(Request $request, Conversation $conversation)
    {
        $conversation->attend(auth()->id());
        return redirect()->route('admin.chatbot.index', ['conv' => $conversation->id, 'tab' => 'en_atencion'])
            ->with('success', 'Conversación tomada en atención.');
    }

    public function close(Request $request, Conversation $conversation)
    {
        $conversation->close($request->notes ?? '');
        return redirect()->route('admin.chatbot.index')
            ->with('success', 'Conversación cerrada correctamente.');
    }

    public function send(Request $request, Conversation $conversation)
    {
        $request->validate(['body' => 'required|string|max:4096']);

        Message::create([
            'conversation_id' => $conversation->id,
            'direction'       => 'outbound',
            'type'            => 'text',
            'body'            => $request->body,
            'sender_id'       => auth()->id(),
            'status'          => 'sent',
            'sent_at'         => now(),
        ]);

        return redirect()->route('admin.chatbot.index', ['conv' => $conversation->id, 'tab' => request('tab', 'soporte')])
            ->with('success', 'Mensaje enviado.');
    }

    public function convertProspect(Request $request, Conversation $conversation)
    {
        $conversation->update(['queue' => 'in_progress', 'assigned_agent_id' => auth()->id()]);
        return redirect()->route('admin.grupos.create')
            ->with('success', 'Convierte este prospecto en cliente nuevo.');
    }

    public function transfer(Request $request, Conversation $conversation)
    {
        $request->validate(['target_queue' => 'required|in:soporte,ventas']);
        $queue = $request->target_queue === 'ventas' ? 'new_prospects' : 'new_messages';
        $conversation->update(['queue' => $queue]);
        return redirect()->route('admin.chatbot.index', ['conv' => $conversation->id])
            ->with('success', 'Conversación transferida.');
    }
}
