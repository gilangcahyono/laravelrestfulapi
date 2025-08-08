<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactCreateRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Models\Contact;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    public function index(Request $request) // done
    {
        try {
            $contacts = Contact::where('user_id', $request->user()->id)->latest()->get();
            return response()->json([
                'ok' => true,
                'message' => 'Data fetched successfully',
                'data' => $contacts,
                'errors' => null
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'ok' => false,
                'message' => 'Internal server error',
                'data' => null,
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function store(ContactCreateRequest $request) // done
    {
        $data = $request->validated();
        try {
            $contact =  Contact::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'user_id' => request()->user()->id,
            ]);

            return response()->json([
                'ok' => true,
                'message' => 'Contact created successfully',
                'data' => $contact,
                'errors' => null
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'ok' => false,
                'message' => 'Internal server error',
                'data' => null,
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function show(Contact $contact)
    {
        // Gate::authorize('view', $contact);

        try {
            if (Gate::denies('view', $contact)) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Forbidden',
                    'data' => null,
                    'errors' => [
                        'message' => 'You are not authorized to view this contact'
                    ]
                ], 403);
            }

            return response()->json([
                'ok' => true,
                'message' => 'Data fetched successfully',
                'data' => $contact,
                'errors' => null
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'ok' => false,
                'message' => 'Internal server error',
                'data' => null,
                'errors' => $th->getMessage()
            ], 500);
        }
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
