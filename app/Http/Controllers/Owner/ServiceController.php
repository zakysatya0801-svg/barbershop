<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ServiceController extends Controller
{
    // Menampilkan daftar service milik Owner.
    public function index(Request $request): View
    {
        $admin = $request->user()->admin;

        $owner = $admin->owners()->firstOrFail();

        // Mengambil semua barbershop milik Owner.
        $barbershops = $owner->goBarberShops;

        // Mengambil service dari barbershop milik Owner.
        $services = Service::whereIn(
            'go_barbershop_id',
            $barbershops->pluck('go_barbershop_id')
        )->with('goBarbershop')->latest()->get();

        return view('base-client.service', compact(
            'services',
            'barbershops'
        ));
    }

    // Menampilkan form tambah service.
    public function create(Request $request): View
    {
        $owner = $request->user()->admin->owners()->firstOrFail();

        $barbershops = $owner->goBarberShops;

        return view('base-client.service-create', compact('barbershops'));
    }

    // Menyimpan service baru.
    public function store(Request $request): RedirectResponse
    {
        $owner = $request->user()->admin->owners()->firstOrFail();

        // Memvalidasi data yang dikirim dari form.
        $validated = $request->validate([
            'go_barbershop_id' => ['required', 'integer'],
            'service_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Memastikan barbershop pilihan adalah milik Owner.
        $barbershop = $owner->goBarberShops()
            ->where('go_barbershop_id', $validated['go_barbershop_id'])
            ->firstOrFail();

        // Menyimpan foto service jika diunggah.
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('services', 'public');
        }

        $validated['go_barbershop_id'] = $barbershop->go_barbershop_id;

        // Menyimpan service ke database.
        Service::create($validated);

        return redirect()
            ->route('owner.service')
            ->with('success', 'Service berhasil ditambahkan.');
    }

    // Menghapus service.
    public function destroy(Request $request, Service $service): RedirectResponse
    {
        $owner = $request->user()->admin->owners()->firstOrFail();

        // Memastikan service milik barbershop Owner.
        $owner->goBarberShops()
            ->where('go_barbershop_id', $service->go_barbershop_id)
            ->firstOrFail();

        // Menghapus foto service jika ada.
        if ($service->photo) {
            Storage::disk('public')->delete($service->photo);
        }

        $service->delete();

        return redirect()
            ->route('owner.service')
            ->with('success', 'Service berhasil dihapus.');
    }
}
