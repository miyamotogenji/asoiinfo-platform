<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $contacts = Contact::with(['businessGroup', 'legalEntity', 'branch'])
            ->when($request->group_id,  fn($q, $id) => $q->where('business_group_id', $id))
            ->when($request->branch_id, fn($q, $id) => $q->where('branch_id', $id))
            ->when($request->type,      fn($q, $t)  => $q->where('type', $t))
            ->when($request->search,    fn($q, $s)  =>
                $q->where('name', 'ilike', "%{$s}%")
                  ->orWhere('whatsapp', 'ilike', "%{$s}%")
                  ->orWhere('phone', 'ilike', "%{$s}%")
                  ->orWhere('email', 'ilike', "%{$s}%"))
            ->paginate(25);

        return response()->json($contacts);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'                 => 'required|string|max:255',
            'business_group_id'    => 'nullable|exists:business_groups,id',
            'legal_entity_id'      => 'nullable|exists:legal_entities,id',
            'branch_id'            => 'nullable|exists:branches,id',
            'phone'                => 'nullable|string|max:20',
            'whatsapp'             => 'nullable|string|max:20|unique:contacts,whatsapp',
            'email'                => 'nullable|email',
            'position'             => 'nullable|string|max:100',
            'authorized_support'   => 'boolean',
            'authorized_invoices'  => 'boolean',
            'authorized_quotes'    => 'boolean',
            'type'                 => 'in:employee,prospect,unknown',
            'status'               => 'in:active,inactive',
            'notes'                => 'nullable|string',
        ]);

        $contact = Contact::create([...$data, 'created_by' => auth()->id()]);
        return response()->json($contact->load(['businessGroup', 'legalEntity', 'branch']), 201);
    }

    public function show(Contact $contact): JsonResponse
    {
        $contact->load(['businessGroup', 'legalEntity', 'branch', 'conversations']);
        return response()->json($contact);
    }

    public function update(Request $request, Contact $contact): JsonResponse
    {
        $data = $request->validate([
            'name'                 => 'sometimes|string|max:255',
            'business_group_id'    => 'nullable|exists:business_groups,id',
            'legal_entity_id'      => 'nullable|exists:legal_entities,id',
            'branch_id'            => 'nullable|exists:branches,id',
            'phone'                => 'nullable|string|max:20',
            'whatsapp'             => "nullable|string|max:20|unique:contacts,whatsapp,{$contact->id}",
            'email'                => 'nullable|email',
            'position'             => 'nullable|string|max:100',
            'authorized_support'   => 'boolean',
            'authorized_invoices'  => 'boolean',
            'authorized_quotes'    => 'boolean',
            'type'                 => 'in:employee,prospect,unknown',
            'status'               => 'in:active,inactive',
            'notes'                => 'nullable|string',
        ]);

        $contact->update($data);
        return response()->json($contact);
    }

    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();
        return response()->json(['message' => 'Contacto eliminado']);
    }

    public function convertToClient(Request $request, Contact $contact): JsonResponse
    {
        $data = $request->validate([
            'business_group_id' => 'required|exists:business_groups,id',
            'legal_entity_id'   => 'required|exists:legal_entities,id',
            'branch_id'         => 'required|exists:branches,id',
        ]);

        $contact->update([...$data, 'type' => 'employee', 'status' => 'active']);
        return response()->json($contact->load(['businessGroup', 'legalEntity', 'branch']));
    }
}
