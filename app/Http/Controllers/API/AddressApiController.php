<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressApiController extends Controller
{
    // ✅ List addresses for authenticated user
    public function index(Request $request)
    {
        return $request->user()->addresses()->latest()->get();
    }

    // ✅ Store a new address
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'city' => 'required|string',
            'area' => 'required|string',
            'neighborhood' => 'required|string',
            'address' => 'required|string', // <- change from 'street' to 'address'
            'building' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_default' => 'boolean',
        ]);
        

        if ($request->boolean('is_default')) {
            $request->user()->addresses()->update(['is_default' => false]);
        }

        return $request->user()->addresses()->create($validated);
    }

    // ✅ Update existing address
    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'city' => 'required|string',
            'area' => 'required|string',
            'neighborhood' => 'required|string',
            'street' => 'required|string',
            'building' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_default' => 'boolean',
        ]);

        if ($request->boolean('is_default')) {
            $request->user()->addresses()->update(['is_default' => false]);
        }

        $address->update($validated);

        return $address;
    }

    // ✅ Delete address
    public function destroy(Request $request, Address $address)
    {
        if ($address->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $address->delete();

        return response()->json(['message' => 'Address deleted']);
    }
    
}
