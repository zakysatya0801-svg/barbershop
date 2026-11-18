<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Owner;
use App\Support\Tenancy\TenantContext;
use Illuminate\Http\RedirectResponse;
// Mengelola konteks tenant barbershop.
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BarbershopController extends Controller
{
    /**
     * Mengambil data Owner berdasarkan akun yang login.
     * Semua operasi dibatasi pada barbershop milik Owner tersebut.
     */
    private function getOwner(Request $request): Owner
    {
        $admin = $request->user()->admin;

        if (! $admin || $admin->role !== 'owner') {
            abort(403, 'Akses khusus Owner.');
        }

        $owner = $admin->owners()->first();

        if (! $owner) {
            abort(403, 'Data Owner tidak ditemukan.');
        }

        return $owner;
    }

    /**
     * Menampilkan daftar barbershop milik Owner.
     */
    public function index(Request $request): View
    {
        $owner = $this->getOwner($request);

        $barbershops = $owner->goBarberShops()
            ->latest()
            ->get();

        return view('base-client.barbershop', [
            'owner' => $owner,
            'barbershops' => $barbershops,
        ]);
    }

    /**
     * Menampilkan form tambah barbershop.
     */
    public function create(Request $request): View
    {
        $owner = $this->getOwner($request);

        return view('base-client.barbershop-create', [
            'owner' => $owner,
        ]);
    }

    /**
     * Menyimpan barbershop baru.
     */
    public function store(Request $request): RedirectResponse
    {
        // Mengambil data Owner yang sedang login.
        $admin = $request->user()->admin;

        if (! $admin || $admin->role !== 'owner') {
            abort(403, 'Akses khusus Owner.');
        }

        // Mengambil data Owner.
        $owner = $admin->owners()->first();

        if (! $owner) {
            abort(403, 'Data Owner tidak ditemukan.');
        }

        // Memvalidasi data Barber dari form.
        $validated = $request->validate([
            'go_barbershop_id' => 'required|integer',
            'barber_name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Memastikan barbershop yang dipilih benar-benar milik Owner.
        $shop = $owner->goBarberShops()
            ->where('go_barbershop_id', $validated['go_barbershop_id'])
            ->firstOrFail();

        // Mengisi konteks tenant dengan barbershop yang dipilih.
        $tenantContext = app(TenantContext::class);
        $tenantContext->set($shop);

        try {
            // Menyimpan foto Barber jika ada.
            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')
                    ->store('barbers', 'public');
            }

            // Membuat data Barber setelah konteks tenant tersedia.
            Barber::create($validated);

            return redirect()
                ->route('owner.barber')
                ->with('success', 'Barber berhasil ditambahkan.');

        } finally {
            // Membersihkan konteks tenant setelah proses selesai.
            $tenantContext->clear();
        }
    }

    /**
     * Menampilkan form edit barbershop.
     */
    public function edit(Request $request, $id): View
    {
        $owner = $this->getOwner($request);

        // Pastikan barbershop benar-benar milik Owner yang login.
        $barbershop = $owner->goBarberShops()
            ->where('go_barbershop_id', $id)
            ->firstOrFail();

        return view('base-client.barbershop-edit', [
            'owner' => $owner,
            'barbershop' => $barbershop,
        ]);
    }

    /**
     * Memperbarui data barbershop.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $owner = $this->getOwner($request);

        // Hanya barbershop milik Owner yang boleh diperbarui.
        $barbershop = $owner->goBarberShops()
            ->where('go_barbershop_id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'barbershop_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i',
        ]);

        // Ganti foto lama hanya jika ada foto baru yang diunggah.
        if ($request->hasFile('photo')) {
            if ($barbershop->photo) {
                Storage::disk('public')->delete($barbershop->photo);
            }

            $validated['photo'] = $request->file('photo')
                ->store('barbershops', 'public');
        } else {
            // Jangan mengubah foto jika pengguna tidak mengunggah foto baru.
            unset($validated['photo']);
        }

        $barbershop->update($validated);

        return redirect()
            ->route('owner.barbershop')
            ->with('success', 'Barbershop berhasil diperbarui.');
    }
}
