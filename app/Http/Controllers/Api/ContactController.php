<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactCreateRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        return Contact::where('user_id', $request->user()->id)->latest()->get();
    }

    public function store(ContactCreateRequest $request)
    {
        $data = $request->validated();
        return Contact::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'user_id' => request()->user()->id,
        ]);
    }

    public function show(Contact $contact)
    {
        Gate::authorize('view', $contact);
        return $contact;
    }

    public function update(ContactUpdateRequest $request, Contact $contact)
    {
        Gate::authorize('update', $contact);
        $data = $request->validated();
        return $contact->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);
    }

    public function destroy(Contact $contact)
    {
        return $contact->delete();
    }
}
