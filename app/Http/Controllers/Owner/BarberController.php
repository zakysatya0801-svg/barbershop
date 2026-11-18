<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Support\Tenancy\TenantContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BarberController extends Controller
{
    // Menampilkan daftar barber milik barbershop Owner.
    public function index(Request $request): View
    {
        // Mengambil akun Owner yang sedang login.
        $admin = $request->user()->admin;

        // Mencari data Owner berdasarkan akun yang login.
        $owner = $admin->owners()->firstOrFail();

        // Mengambil seluruh barbershop milik Owner.
        $barbershops = $owner->goBarberShops;

        // Mengambil barber dari seluruh barbershop milik Owner.
        $barbers = Barber::withoutGlobalScope('tenant')
            ->whereIn(
                'go_barbershop_id',
                $barbershops->pluck('go_barbershop_id')
            )
            ->with('goBarbershop')
            ->latest()
            ->get();

        // Mengirim data ke halaman daftar barber.
        return view('base-client.barber', compact(
            'barbers',
            'barbershops'
        ));
    }

    // Menampilkan form tambah barber.
    public function create(Request $request): View
    {
        $owner = $request->user()->admin->owners()->firstOrFail();

        $barbershops = $owner->goBarberShops;

        return view('base-client.barber-create', compact('barbershops'));
    }

    // Menyimpan barber baru.

    public function store(
        Request $request,
        TenantContext $tenantContext
    ): RedirectResponse {

        // Mengambil akun Owner yang sedang login.
        $admin = $request->user()->admin;

        // Memastikan akun benar-benar memiliki role Owner.
        if (! $admin || $admin->role !== 'owner') {
            abort(403, 'Akses khusus Owner.');
        }

        // Mengambil data Owner.
        $owner = $admin->owners()->first();

        if (! $owner) {
            abort(403, 'Data Owner tidak ditemukan.');
        }

        // Memvalidasi data yang dikirim dari form.
        $validated = $request->validate([
            'go_barbershop_id' => 'required|integer',
            'barber_name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Memastikan barbershop yang dipilih milik Owner yang login.
        $shop = $owner->goBarberShops()
            ->where('go_barbershop_id', $validated['go_barbershop_id'])
            ->firstOrFail();

        try {

            // Mengisi TenantContext dengan barbershop pilihan.
            // Ini wajib dilakukan sebelum Barber::create().
            $tenantContext->set($shop);

            // Menyimpan foto jika Owner mengunggahnya.
            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')
                    ->store('barbers', 'public');
            }

            // Membuat data Barber.
            // Trait BelongsToTenant akan otomatis mengisi go_barbershop_id
            // berdasarkan TenantContext yang sudah diatur di atas.
            Barber::create([
                'barber_name' => $validated['barber_name'],
                'specialty' => $validated['specialty'],
                'photo' => $validated['photo'] ?? null,
            ]);

            return redirect()
                ->route('owner.barber')
                ->with('success', 'Barber berhasil ditambahkan.');

        } finally {

            // Membersihkan TenantContext setelah proses selesai.
            // Agar tidak digunakan oleh proses berikutnya secara tidak sengaja.
            $tenantContext->clear();
        }
    }

    // Menghapus data barber.
    public function destroy(Request $request, Barber $barber): RedirectResponse
    {
        $owner = $request->user()->admin->owners()->firstOrFail();

        // Memastikan barber yang akan dihapus milik Owner yang login.
        $barbershop = $owner->goBarberShops()
            ->where('go_barbershop_id', $barber->go_barbershop_id)
            ->firstOrFail();

        // Menghapus file foto jika tersedia.
        if ($barber->photo) {
            Storage::disk('public')->delete($barber->photo);
        }

        $barber->delete();

        return redirect()
            ->route('owner.barber')
            ->with('success', 'Data barber berhasil dihapus.');
    }
}
