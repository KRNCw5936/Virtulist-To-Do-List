<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller 
{
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login');
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('homepage.dashboard');
        }        

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request) {
        Auth::logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('login');
    }
    

    // Login dengan Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan data dari Google. Error: ' . $e->getMessage());
        }
    
        // Cek apakah user sudah ada berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();
    
        if (!$user) {
            // Jika belum ada, buat user baru dengan provider google
            $user = User::create([
                'username' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'phone_number' => null,
                'password' => Hash::make(uniqid()), // password acak
                'provider' => 'google', // <== Tambahan penting di sini
            ]);
        } else {
            // Jika user sudah ada tapi belum ada provider-nya, set provider-nya
            if (!$user->provider) {
                $user->update(['provider' => 'google']);
            }
        }
    
        Auth::login($user, true);
        return redirect()->route('homepage.dashboard');
    }
    
}
