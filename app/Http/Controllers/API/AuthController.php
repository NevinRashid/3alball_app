<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Tenant;

class AuthController extends Controller
{
    // ✅ Register a new user (customer or shop owner)
    public function register(Request $request)
    {
        // Default to customer if role is not sent
        $request->merge(['role' => $request->role ?? 'customer']);

        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|string|unique:users,phone',
            'password'   => 'required|string|min:6',
            'role'       => 'required|in:admin,shop_owner,customer',
            'tenant_id'  => 'nullable|exists:tenants,id',
            'store_name' => 'required_if:role,shop_owner|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $tenantId = $request->tenant_id;

        // Auto-create tenant if shop_owner and no tenant_id passed
        if (!$tenantId && $request->role === 'shop_owner') {
            $tenant = Tenant::create([
                'name'  => $request->store_name,
                'email' => $request->email,
                'type'  => 'gift',
            ]);
            $tenantId = $tenant->id;
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => bcrypt($request->password),
            'role'      => $request->role,
            'tenant_id' => $tenantId,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registered successfully',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    // ✅ Login using email or phone
    public function login(Request $request)
{
    $request->validate([
        'login'    => 'required|string', 
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->login)
                ->orWhere('phone', $request->login)
                ->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'login' => ['The provided credentials are incorrect.'],
        ]);
    }

    
    if (! $user->is_active) {
        return response()->json([
            'message' => 'Your account has been suspended. Please contact support.',
        ], 403); // Forbidden
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token'   => $token,
        'user'    => $user,
    ]);
}


    // ✅ Logout current session
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    // ✅ Get current user info
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // ✅ Update user password
    public function updatePassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        // Get the currently authenticated user
        $user = $request->user();

        // Check if the current password matches the stored password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        // Update the password and save it
        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }
}
