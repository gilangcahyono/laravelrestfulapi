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
            $contacts = Contact::where('user_id', $request->user()->id)
                ->when($request->search, function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->latest()
                ->get();
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
        try {
            // Gate::authorize('view', $contact);
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
        $data = $request->validated();
        try {
            if (Gate::denies('update', $contact)) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Forbidden',
                    'data' => null,
                    'errors' => [
                        'message' => 'You are not authorized to view this contact'
                    ]
                ], 403);
            }

            $contact =  $contact->update([
                'name' => $data['name'],
                'phone' => $data['phone'],
            ]);

            return response()->json([
                'ok' => true,
                'message' => 'Contact updated successfully',
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

    public function destroy(Contact $contact)
    {
        try {
            if (Gate::denies('delete', $contact)) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Forbidden',
                    'data' => null,
                    'errors' => [
                        'message' => 'You are not authorized to delete this contact'
                    ]
                ], 403);
            }
            $currentContact = Contact::find($contact->id);
            $contact->delete();
            response()->json([
                'ok' => true,
                'message' => 'Contact deleted successfully',
                'data' => $currentContact,
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
}
