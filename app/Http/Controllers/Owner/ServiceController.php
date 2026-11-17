<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::latest()->paginate(10);

        return view('owner.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('owner.services.create');
    }

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
            ->route('owner.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(int $service): View
    {
        $service = Service::findOrFail($service);

        return view('owner.services.edit', compact('service'));
    }

    public function update(Request $request, int $service): RedirectResponse
    {
        $service = Service::findOrFail($service);

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
            ->route('owner.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(int $service): RedirectResponse
    {
        $service = Service::findOrFail($service);

        $service->delete();

        return redirect()
            ->route('owner.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
