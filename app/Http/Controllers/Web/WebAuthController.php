<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends Controller
{
    public function login(Request $request)
    {

        $creds = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $isAuthAttemp = Auth::attempt($creds);

        if ($isAuthAttemp) {
            $request->session()->regenerate();

            return redirect()->route('book.index');
        }

        return back()->withErrors([
            'alert' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('/');
    }
}
