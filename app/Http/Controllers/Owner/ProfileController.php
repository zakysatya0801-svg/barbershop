<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Mengambil data Owner dari akun yang sedang login.
    private function getOwner(Request $request)
    {
        return $request->user()
            ->admin
            ?->owners()
            ->first();
    }

    // Menampilkan halaman profil Owner.
    public function edit(Request $request): View|RedirectResponse
    {
        $owner = $this->getOwner($request);

        // Jika data Owner tidak ditemukan, kembali ke dashboard.
        if (! $owner) {
            return redirect()
                ->route('client.dashboard')
                ->with('error', 'Data Owner tidak ditemukan.');
        }

        return view('base-client.profil', compact('owner'));
    }

    // Memproses perubahan informasi profil Owner.
    public function update(Request $request): RedirectResponse
    {
        $owner = $this->getOwner($request);

        if (! $owner) {
            return redirect()
                ->route('client.dashboard')
                ->with('error', 'Data Owner tidak ditemukan.');
        }

        // Validasi data sebelum disimpan ke database.
        $validated = $request->validate([
            'nama_owners' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('owners', 'email')
                    ->ignore($owner->owner_id, 'owner_id'),
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],
        ]);

        // Perbarui hanya tabel owners.
        $owner->update($validated);

        return redirect()
            ->route('owner.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
