<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin(Request $request): View|RedirectResponse
    {
        // Jika sudah login, arahkan pengguna sesuai role akun.
        if (Auth::check()) {
            return $this->redirectByRole($request);
        }

        // Menampilkan halaman form login.
        return view('auth.login');
    }

    /**
     * Memeriksa email dan password pengguna.
     */
    public function login(Request $request): RedirectResponse
    {
        // Memvalidasi input sebelum memeriksa akun ke database.
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Memeriksa kecocokan email dan password.
        if (! Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak sesuai.',
                ])
                ->onlyInput('email');
        }

        // Memperbarui session setelah login berhasil.
        $request->session()->regenerate();

        // Mengarahkan pengguna ke dashboard berdasarkan role akun.
        return $this->redirectByRole($request);
    }

    /**
     * Mengakhiri sesi login pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        // Menghapus autentikasi pengguna saat ini.
        Auth::logout();

        // Menghapus session lama dan membuat token CSRF baru.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembali ke halaman login.
        return redirect()->route('login');
    }

    /**
     * Mengarahkan Admin dan Owner berdasarkan role akun.
     */
    private function redirectByRole(Request $request): RedirectResponse
    {
        // Mengambil pengguna yang sedang login.
        $user = $request->user();

        // Memastikan pengguna sudah login.
        if (! ($user instanceof User)) {
            return redirect()->route('login');
        }

        // Mengambil role melalui relasi User ke tabel admins.
        $role = $user->admin?->role;

        // Mengarahkan Admin ke dashboard Admin.
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Mengarahkan Owner ke dashboard Owner.
        // Mengarahkan Owner ke dashboard client.
        if ($role === 'owner') {
            return redirect()->route('client.dashboard');
        }

        return $this->logoutAndRedirectToLogin(
            $request,
            'Akun tidak memiliki akses Admin atau Owner.'
        );
    }

    private function logoutAndRedirectToLogin(
        Request $request,
        string $error
    ): RedirectResponse {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->withErrors(['email' => $error]);
    }
}
