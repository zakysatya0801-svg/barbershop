<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin(Request $request): View|RedirectResponse
    {
        // Jika sudah login sebagai Owner, langsung ke dashboard.
        if (Auth::check()) {
            return $this->redirectByRole($request);
        }

        return view('auth.login');
    }

    /**
     * Menampilkan halaman registrasi Owner.
     */
    public function showRegister(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole($request);
        }

        return view('auth.register');
    }

    /**
     * Registrasi akun Owner.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                'unique:owners,email',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Menyimpan User, Admin, dan Owner sekaligus.
        DB::transaction(function () use ($validated): void {

            // 1. Membuat akun User.
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'owner',
                'status' => 'active',
            ]);

            // 2. Membuat data Admin dengan role Owner.
            $admin = Admin::create([
                'user_id' => $user->user_id,
                'role' => 'owner',
            ]);

            // 3. Membuat profil Owner.
            Owner::create([
                'nama_owners' => $validated['name'],
                'email' => $validated['email'],

                // Nama kolom sesuai database aktual.
                'phonr' => $validated['phone'],

                'admin_id' => $admin->admin_id,
            ]);
        });

        // Tidak melakukan login otomatis.
        // Pengguna kembali ke halaman Home.
        return redirect()
            ->route('home')
            ->with(
                'success',
                'Akun Owner berhasil dibuat! Silakan klik Masuk / Daftar untuk login.'
            );
    }

    /**
     * Proses login Owner.
     */
    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        // Memeriksa email, password, dan status akun.
        $authenticated = Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
            'status' => 'active',
        ]);

        if (! $authenticated) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak sesuai.',
                ])
                ->onlyInput('email');
        }

        // Memperbarui session.
        $request->session()->regenerate();

        $user = $request->user();

        // Hanya Owner yang boleh menggunakan login publik.
        if (! $user || ! $user->hasRole('owner')) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Login hanya tersedia untuk akun Owner GoBarberShop.',
                ])
                ->withInput([
                    'email' => $validated['email'],
                ]);
        }

        // Memastikan profil Owner tersedia.
        if (! $user->owner) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Profil Owner tidak ditemukan.',
                ]);
        }

        // Login berhasil, langsung ke dashboard Owner.
        return redirect()
            ->route('client.dashboard')
            ->with('success', 'Login berhasil! Selamat datang di Dashboard Owner.');
    }

    /**
     * Logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'Anda berhasil logout.');
    }

    /**
     * Pengalihan akun yang sudah login.
     */
    private function redirectByRole(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole('owner')) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
        }

        return redirect()->route('client.dashboard');
    }
}
