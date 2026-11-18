<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\Tenancy\TenantContext;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Mengambil data Owner berdasarkan akun yang sedang login.
     * Memastikan seluruh operasi hanya untuk barbershop milik Owner tersebut.
     */
    private function getOwner(Request $request)
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
     * Menampilkan daftar Service milik Owner.
     */
    public function index(
        Request $request,
        TenantContext $tenantContext
    ): View {
        $owner = $this->getOwner($request);
        $barbershops = $owner->goBarberShops()->get();

        $services = collect();

        try {
            foreach ($barbershops as $shop) {
                $tenantContext->set($shop);

                $shopServices = Service::with('goBarbershop')
                    ->latest()
                    ->get();

                $services = $services->concat($shopServices);
            }

            $services = $services
                ->sortByDesc('created_at')
                ->values();

        } finally {
            $tenantContext->clear();
        }

        return view('base-client.service', [
            'owner' => $owner,
            'barbershops' => $barbershops,
            'services' => $services,
        ]);
    }

    /**
     * Menampilkan form tambah Service.
     */
    public function create(Request $request): View
    {
        $owner = $this->getOwner($request);
        $barbershops = $owner->goBarberShops()->get();

        return view('base-client.service-create', [
            'owner' => $owner,
            'barbershops' => $barbershops,
        ]);
    }

    /**
     * Menyimpan Service baru.
     */
    public function store(
        Request $request,
        TenantContext $tenantContext
    ): RedirectResponse {
        $owner = $this->getOwner($request);

        $validated = $request->validate([
            'go_barbershop_id' => 'required|integer',
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Memastikan barbershop yang dipilih milik Owner login.
        $shop = $owner->goBarberShops()
            ->where(
                'go_barbershop_id',
                $validated['go_barbershop_id']
            )
            ->firstOrFail();

        try {
            $tenantContext->set($shop);

            $photoPath = null;

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')
                    ->store('services', 'public');
            }

            Service::create([
                'service_name' => $validated['service_name'],
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'photo' => $photoPath,
            ]);

            return redirect()
                ->route('owner.service')
                ->with('success', 'Service berhasil ditambahkan.');

        } finally {
            $tenantContext->clear();
        }
    }

    /**
     * Menghapus Service milik Owner.
     */
    public function destroy(
        Request $request,
        $id,
        TenantContext $tenantContext
    ): RedirectResponse {
        $owner = $this->getOwner($request);
        $barbershops = $owner->goBarberShops()->get();

        $service = null;

        try {
            foreach ($barbershops as $shop) {
                $tenantContext->set($shop);

                $service = Service::whereKey($id)->first();

                if ($service) {
                    break;
                }
            }

            if (! $service) {
                abort(404, 'Service tidak ditemukan.');
            }

            if ($service->photo) {
                Storage::disk('public')->delete($service->photo);
            }

            $service->delete();

            return redirect()
                ->route('owner.service')
                ->with('success', 'Service berhasil dihapus.');

        } finally {
            $tenantContext->clear();
        }
    }
}
