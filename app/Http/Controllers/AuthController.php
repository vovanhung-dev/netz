<?php
namespace App\Http\Controllers;


use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }
        // Revoke old tokens (optional)
        $user->tokens()->delete();
        $token = $user->createToken('netzl-token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }


    public function me(Request $request)
    {
        return response()->json($request->user());
    }


    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();
        if ($token) {
            // delete via the tokens relationship to avoid calling delete on an unexpected type
            $request->user()->tokens()->where('id', $token->id)->delete();
        }
        return response()->json(['message' => 'Logged out']);
    }
}
