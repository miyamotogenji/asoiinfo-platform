<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\BusinessGroup;
use App\Models\LegalEntity;
use App\Models\Branch;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::with(['businessGroup', 'branch'])
            ->when($request->search, fn($q, $s) =>
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('whatsapp', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%"))
            ->when($request->type,      fn($q, $t)  => $q->where('type', $t))
            ->when($request->group_id,  fn($q, $id) => $q->where('business_group_id', $id))
            ->latest()->paginate(25);

        $groups = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        return view('admin.contacts.index', compact('contacts', 'groups'));
    }

    public function create(Request $request)
    {
        $groups   = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        $entities = LegalEntity::where('status', 'active')->orderBy('legal_name')->get();
        $branches = Branch::where('status', 'active')->orderBy('name')->get();
        $whatsapp = $request->whatsapp ?? '';
        $convId   = $request->conv ?? null;
        return view('admin.contacts.create', compact('groups', 'entities', 'branches', 'whatsapp', 'convId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'business_group_id'   => 'nullable|exists:business_groups,id',
            'legal_entity_id'     => 'nullable|exists:legal_entities,id',
            'branch_id'           => 'nullable|exists:branches,id',
            'phone'               => 'nullable|string|max:20',
            'whatsapp'            => 'nullable|string|max:20|unique:contacts,whatsapp',
            'email'               => 'nullable|email',
            'position'            => 'nullable|string|max:100',
            'authorized_support'  => 'boolean',
            'authorized_invoices' => 'boolean',
            'authorized_quotes'   => 'boolean',
            'type'                => 'in:employee,prospect,unknown',
            'notes'               => 'nullable|string',
        ]);

        $contact = Contact::create([...$data, 'created_by' => auth()->id()]);

        // If contact was created from a conversation, update the conversation
        if ($request->conv_id) {
            \App\Models\Conversation::where('id', $request->conv_id)
                ->update([
                    'contact_id'        => $contact->id,
                    'contact_name'      => $contact->name,
                    'branch_id'         => $contact->branch_id,
                    'business_group_id' => $contact->business_group_id,
                ]);
        }

        return redirect()->route('admin.contactos.index')->with('success', 'Contacto creado.');
    }

    public function edit(Contact $contacto)
    {
        $groups   = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        $entities = LegalEntity::where('status', 'active')->orderBy('legal_name')->get();
        $branches = Branch::where('status', 'active')->orderBy('name')->get();
        return view('admin.contacts.edit', ['contact' => $contacto, 'groups' => $groups, 'entities' => $entities, 'branches' => $branches]);
    }

    public function update(Request $request, Contact $contacto)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'business_group_id'   => 'nullable|exists:business_groups,id',
            'legal_entity_id'     => 'nullable|exists:legal_entities,id',
            'branch_id'           => 'nullable|exists:branches,id',
            'phone'               => 'nullable|string|max:20',
            'whatsapp'            => "nullable|string|max:20|unique:contacts,whatsapp,{$contacto->id}",
            'email'               => 'nullable|email',
            'position'            => 'nullable|string|max:100',
            'authorized_support'  => 'boolean',
            'authorized_invoices' => 'boolean',
            'authorized_quotes'   => 'boolean',
            'type'                => 'in:employee,prospect,unknown',
            'status'              => 'in:active,inactive',
            'notes'               => 'nullable|string',
        ]);

        $contacto->update($data);
        return redirect()->route('admin.contactos.index')->with('success', 'Contacto actualizado.');
    }

    public function destroy(Contact $contacto)
    {
        $contacto->delete();
        return redirect()->route('admin.contactos.index')->with('success', 'Contacto eliminado.');
    }
}

