<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\GoBarberShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
        $barbers = Barber::whereIn(
            'go_barbershop_id',
            $barbershops->pluck('go_barbershop_id')
        )->with('goBarbershop')->latest()->get();

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
    public function store(Request $request): RedirectResponse
    {
        $owner = $request->user()->admin->owners()->firstOrFail();

        // Memeriksa input dari form.
        $validated = $request->validate([
            'go_barbershop_id' => ['required', 'integer'],
            'barber_name' => ['required', 'string', 'max:255'],
            'specialty' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Memastikan barbershop benar-benar milik Owner yang login.
        $barbershop = $owner->goBarberShops()
            ->where('go_barbershop_id', $validated['go_barbershop_id'])
            ->firstOrFail();

        // Menyimpan foto ke storage jika Owner mengunggah foto.
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('barbers', 'public');
        }

        // Mengisi foreign key berdasarkan barbershop yang sudah diverifikasi.
        $validated['go_barbershop_id'] = $barbershop->go_barbershop_id;

        // Membuat data barber baru.
        Barber::create($validated);

        return redirect()
            ->route('owner.barber')
            ->with('success', 'Data barber berhasil ditambahkan.');
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
