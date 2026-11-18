<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\Tenancy\TenantContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        // Mengambil data Admin dari akun yang login.
        $admin = $request->user()->admin;

        // Memastikan akun memiliki role Owner.
        if (! $admin || $admin->role !== 'owner') {
            abort(403, 'Akses khusus Owner.');
        }

        // Mengambil data Owner.
        $owner = $admin->owners()->first();

        // Memastikan data Owner tersedia.
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

        // Mengambil data Owner yang sedang login.
        $owner = $this->getOwner($request);

        // Mengambil seluruh barbershop milik Owner.
        $barbershops = $owner->goBarberShops()->get();

        // Menyiapkan collection untuk menampung seluruh Service.
        $services = collect();

        try {

            // Mengambil Service dari setiap barbershop.
            foreach ($barbershops as $shop) {

                // Mengisi TenantContext sebelum query Service.
                $tenantContext->set($shop);

                // Mengambil Service beserta relasi barbershop.
                $shopServices = Service::with('goBarbershop')
                    ->latest()
                    ->get();

                // Menggabungkan hasil query.
                $services = $services->concat($shopServices);
            }

            // Mengurutkan Service dari yang terbaru.
            $services = $services
                ->sortByDesc('created_at')
                ->values();

        } finally {

            // Membersihkan TenantContext setelah query selesai.
            $tenantContext->clear();
        }

        // Mengirim data ke halaman daftar Service.
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
        // Mengambil data Owner.
        $owner = $this->getOwner($request);

        // Mengambil seluruh barbershop milik Owner.
        $barbershops = $owner->goBarberShops()->get();

        // Menampilkan form tambah Service.
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

        // Mengambil data Owner.
        $owner = $this->getOwner($request);

        // Memvalidasi data dari form.
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

            // Mengisi TenantContext sebelum menyimpan Service.
            $tenantContext->set($shop);

            // Menyimpan foto jika pengguna mengunggahnya.
            $photoPath = null;

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')
                    ->store('services', 'public');
            }

            // Menyimpan data Service.
            // go_barbershop_id diisi otomatis oleh BelongsToTenant.
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

            // Membersihkan TenantContext.
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

        // Mengambil data Owner.
        $owner = $this->getOwner($request);

        // Mengambil seluruh barbershop milik Owner.
        $barbershops = $owner->goBarberShops()->get();

        // Menyiapkan variabel Service yang akan dihapus.
        $service = null;

        try {

            // Memeriksa Service pada setiap barbershop milik Owner.
            foreach ($barbershops as $shop) {

                // Mengisi konteks tenant sebelum query.
                $tenantContext->set($shop);

                // Mencari Service berdasarkan ID.
                $service = Service::whereKey($id)->first();

                // Jika ditemukan, hentikan pencarian.
                if ($service) {
                    break;
                }
            }

            // Jika tidak ditemukan di seluruh barbershop Owner,
            // berarti Service tidak dimiliki oleh Owner ini.
            if (! $service) {
                abort(404, 'Service tidak ditemukan.');
            }

            // Menghapus foto Service jika tersedia.
            if ($service->photo) {
                Storage::disk('public')->delete($service->photo);
            }

            // Menghapus data Service.
            $service->delete();

            return redirect()
                ->route('owner.service')
                ->with('success', 'Service berhasil dihapus.');

        } finally {

            // Membersihkan TenantContext setelah proses selesai.
            $tenantContext->clear();
        }
    }
}
