<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('id_telegram');

        $user = User::where('id_telegram', $credentials['id_telegram'])->first();

        if ($user && $user->is_admin) {
            Auth::login($user);
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()->withErrors(['id_telegram' => 'Invalid credentials or not an admin.']);
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
