<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        return Contact::where('user_id', $request->user()->id)->latest()->get();
    }

    public function store(Request $request)
    {
        return Contact::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'user_id' => $request->user()->id,
        ]);
    }

    public function show(Contact $contact)
    {
        return $contact;
    }

    public function update(Request $request, Contact $contact)
    {
        return $contact->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
    }

    public function destroy(Contact $contact)
    {
        return $contact->delete();
    }
}
