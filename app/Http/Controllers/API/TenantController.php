<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;

class TenantController extends Controller
{
    /**
     * Create a new tenant (store/business).
     * Only system admin should call this.
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'type' => 'nullable|string',
        ]);

        $tenant = Tenant::create([
            'name'  => $request->name,
            'email' => $request->email,
            'type'  => $request->type ?? 'gift',
        ]);

        return response()->json([
            'tenant' => $tenant,
        ]);
    }
}
