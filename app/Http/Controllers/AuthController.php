<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login Admin dan Owner.
     */
    public function showLogin(Request $request)
    {
        // Jika sudah login, arahkan pengguna sesuai role.
        if (Auth::check()) {
            return $this->redirectByRole($request);
        }

        // Menampilkan halaman form login.
        return view('auth.login');
    }

    /**
     * Memeriksa email dan password pengguna.
     */
    public function login(Request $request)
    {
        // Memvalidasi input sebelum memeriksa akun ke database.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Memeriksa kecocokan email dan password.
        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak sesuai.',
                ])
                ->onlyInput('email');
        }

        // Memperbarui session setelah login berhasil.
        $request->session()->regenerate();

        // Mengambil pengguna yang berhasil login.
        $user = Auth::user();

        // Memastikan objek pengguna tersedia.
        if (! $user) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Pengguna tidak ditemukan.',
                ]);
        }

        // Mengarahkan pengguna ke dashboard sesuai role.
        return $this->redirectByRole($request);
    }

    /**
     * Mengakhiri sesi login pengguna.
     */
    public function logout(Request $request)
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
     * Mengarahkan Admin dan Owner berdasarkan role.
     */
    private function redirectByRole(Request $request)
    {
        // Mengambil pengguna yang sedang login.
        $user = Auth::user();

        // Memastikan pengguna sudah login.
        if (! ($user instanceof User)) {
            return redirect()->route('login');
        }

        // Mengambil role melalui relasi User ke tabel admins.
        $role = $user->admin()->value('role');

        // Mengarahkan Admin ke dashboard Admin.
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Mengarahkan Owner ke dashboard Owner.
        // Mengarahkan Owner ke dashboard client.
        if ($role === 'owner') {
            return redirect()->route('client.dashboard');
        }

        // Keluar jika role tidak sesuai.
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Akun tidak memiliki akses Admin atau Owner.',
            ]);
    }
}
