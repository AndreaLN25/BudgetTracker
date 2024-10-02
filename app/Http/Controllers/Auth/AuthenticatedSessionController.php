<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return redirect()
                ->back()
                ->withInput($request->only('email'))
                ->with('error', 'The credentials are incorrect.');
        }

        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return redirect()->route('home');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        if ($user) {
            if ($user->currentAccessToken()) {
                $user->currentAccessToken()->delete();
            }

            Auth::logout();

            return redirect()->route('home');
        }

        return redirect()->route('home');
    }
}
