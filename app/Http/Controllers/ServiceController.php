<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Menampilkan semua layanan barbershop aktif.
     */
    public function index(): View
    {
        $services = Service::query()
            ->latest()
            ->paginate(10);

        return view('owner.services.index', compact('services'));
    }

    /**
     * Menampilkan form tambah layanan.
     */
    public function create(): View
    {
        return view('owner.services.create');
    }

    /**
     * Menyimpan layanan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'string'],
            'is_available' => ['required', 'boolean'],
        ]);

        Service::create($validated);

        return redirect()
            ->route('owner.services.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit layanan.
     */
    public function edit(Service $service): View
    {
        return view('owner.services.edit', compact('service'));
    }

    /**
     * Memperbarui layanan.
     */
    public function update(
        Request $request,
        Service $service
    ): RedirectResponse {
        $validated = $request->validate([
            'service_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'string'],
            'is_available' => ['required', 'boolean'],
        ]);

        $service->update($validated);

        return redirect()
            ->route('owner.services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Menghapus layanan.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()
            ->route('owner.services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
