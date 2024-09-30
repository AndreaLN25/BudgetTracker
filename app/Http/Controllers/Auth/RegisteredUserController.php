<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class RegisteredUserController extends Controller
{
    public function store(LoginRequest $request)
    {
        // Autenticar al usuario
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Las credenciales son incorrectas.'], 401);
        }

        // Regenerar el token de acceso
        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function destroy(Request $request)
    {
        // Cerrar sesión y revocar el token
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
