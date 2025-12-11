<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login portal (now redirects to default login).
     */
    public function showLayananLogin()
    {
        return redirect()->route('login');
    }

    /**
     * Show admin login form.
     */
    public function showAdminLogin()
    {
        return view('auth.login', ['title' => 'Masuk Admin', 'role' => User::ROLE_ADMIN]);
    }

    /**
     * Show profesional login form.
     */
    public function showProfesionalLogin()
    {
        return view('auth.login', ['title' => 'Masuk Profesional', 'role' => User::ROLE_PROFESIONAL]);
    }

    /**
     * Show klien login form.
     */
    public function showKlienLogin()
    {
        return view('auth.login', ['title' => 'Masuk Klien', 'role' => User::ROLE_KLIEN]);
    }

     /**
     * Show generic login form (redirects to portal).
     */
    public function showLoginForm()
    {
        return redirect('/masuk');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'nullable|in:' . implode(',', [User::ROLE_ADMIN, User::ROLE_PROFESIONAL, User::ROLE_KLIEN]),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Enforce role check if a specific role login was used
            if ($request->has('role') && $user->role !== $request->role) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->back()
                    ->withErrors(['email' => 'Akun Anda tidak memiliki akses untuk role ini.'])
                    ->withInput();
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Berhasil masuk ke sistem.');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput();
    }

    /**
     * Show registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'password' => 'required|string|min:6|confirmed',
            'nik' => 'required|string|max:20',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'role' => User::ROLE_KLIEN, // Default role for registration
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di LK3 Pedrahi.');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/masuk')->with('success', 'Berhasil keluar dari sistem.');
    }

    /**
     * Show dashboard based on user role.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        switch ($user->role) {
            case User::ROLE_ADMIN:
                // Redirect to the admin dashboard route so the controller can supply data
                return redirect()->route('admin.dashboard');
            case User::ROLE_PROFESIONAL:
                return redirect()->route('profesional.dashboard');
            case User::ROLE_KLIEN:
                return redirect()->route('klien.dashboard');
            default:
                return redirect('/')->with('error', 'Role tidak valid.');
        }
    }
}
