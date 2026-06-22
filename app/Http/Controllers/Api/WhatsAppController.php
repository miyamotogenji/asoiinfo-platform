<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Contact;
use App\Models\WhatsappNumber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    /**
     * Webhook verification (Meta GET challenge).
     */
    public function verify(Request $request)
    {
        $mode      = $request->query('hub_mode');
        $token     = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode === 'subscribe' && $token === config('services.whatsapp.verify_token')) {
            return response($challenge, 200);
        }

        return response('Forbidden', 403);
    }

    /**
     * Receive inbound messages from Meta webhook.
     */
    public function receive(Request $request): JsonResponse
    {
        Log::info('WhatsApp webhook', $request->all());

        $entry = $request->input('entry.0.changes.0.value');
        if (!$entry || !isset($entry['messages'])) {
            return response()->json(['ok' => true]);
        }

        $phoneNumberId = $entry['metadata']['phone_number_id'] ?? null;
        $whatsappNum   = WhatsappNumber::where('phone_number_id', $phoneNumberId)->first();

        foreach ($entry['messages'] as $msgData) {
            $fromPhone = $msgData['from'];
            $msgId     = $msgData['id'];

            $contact     = Contact::findByWhatsapp($fromPhone);
            $contactName = $contact?->name
                ?? ($entry['contacts'][0]['profile']['name'] ?? 'Desconocido');

            $conversation = Conversation::firstOrCreate(
                ['contact_phone' => $fromPhone, 'queue' => 'new_messages'],
                [
                    'whatsapp_number_id' => $whatsappNum?->id,
                    'contact_name'       => $contactName,
                    'contact_id'         => $contact?->id,
                    'branch_id'          => $contact?->branch_id,
                    'business_group_id'  => $contact?->business_group_id,
                    'queue'              => $contact ? 'new_messages' : 'new_prospects',
                    'financial_status'   => 'unknown',
                ]
            );

            if ($contact?->branch) {
                $conversation->update([
                    'financial_status' => $contact->branch->financial_status,
                ]);
            }

            $type = $msgData['type'];
            $body = match($type) {
                'text'     => $msgData['text']['body'] ?? '',
                'image'    => '[Image received]',
                'document' => '[Document: ' . ($msgData['document']['filename'] ?? 'file') . ']',
                'audio'    => '[Audio received]',
                default    => "[{$type}]",
            };

            Message::create([
                'conversation_id'    => $conversation->id,
                'whatsapp_message_id' => $msgId,
                'direction'          => 'inbound',
                'type'               => $type,
                'body'               => $body,
                'is_read'            => false,
            ]);
        }

        return response()->json(['ok' => true]);
    }

    /**
     * Send a message from agent to contact.
     */
    public function send(Request $request): JsonResponse
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'body'            => 'required|string',
            'type'            => 'in:text,template',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);
        $whatsappNum  = $conversation->whatsappNumber;

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type'    => 'individual',
            'to'                => $conversation->contact_phone,
            'type'              => 'text',
            'text'              => ['body' => $request->body],
        ];

        $response = Http::withToken(config('services.whatsapp.token'))
            ->post(config('services.whatsapp.url') . "/{$whatsappNum->phone_number_id}/messages", $payload);

        if ($response->successful()) {
            $message = Message::create([
                'conversation_id'     => $conversation->id,
                'whatsapp_message_id' => $response->json('messages.0.id'),
                'direction'           => 'outbound',
                'type'                => 'text',
                'body'                => $request->body,
                'is_read'             => true,
                'sent_by'             => auth()->id(),
            ]);
            return response()->json($message, 201);
        }

        return response()->json(['error' => 'Failed to send message'], 500);
    }

    /**
     * Attend a conversation — moves from new_messages to in_progress.
     */
    public function attend(Conversation $conversation): JsonResponse
    {
        $conversation->attend(auth()->id());
        return response()->json($conversation);
    }

    /**
     * Close a conversation.
     */
    public function close(Request $request, Conversation $conversation): JsonResponse
    {
        $conversation->close($request->notes ?? '');
        return response()->json(['message' => 'Conversación finalizada']);
    }

    /**
     * Transfer conversation to another agent.
     */
    public function transfer(Request $request, Conversation $conversation): JsonResponse
    {
        $request->validate(['agent_id' => 'required|exists:users,id']);
        $conversation->update(['assigned_agent_id' => $request->agent_id]);
        return response()->json($conversation);
    }

    /**
     * Get inbox overview — all queues.
     */
    public function inbox(): JsonResponse
    {
        return response()->json([
            'new_messages'  => Conversation::with(['messages' => fn($q) => $q->latest()->limit(1)])
                ->where('queue', 'new_messages')->latest()->get(),
            'in_progress'   => Conversation::with(['assignedAgent', 'messages' => fn($q) => $q->latest()->limit(1)])
                ->where('queue', 'in_progress')->latest()->get(),
            'new_prospects' => Conversation::with(['messages' => fn($q) => $q->latest()->limit(1)])
                ->where('queue', 'new_prospects')->latest()->get(),
        ]);
    }
}
