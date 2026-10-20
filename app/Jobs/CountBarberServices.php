<?php

namespace App\Jobs;

use App\Models\GoBarberShop;
use App\Models\Service;
use App\Support\Tenancy\TenantContext;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

/**
 * Menghitung layanan satu barbershop dan membersihkan context setelah job selesai.
 */
class CountBarberServices implements ShouldQueue
{
    use Queueable;

    public ?int $result = null;

    public function __construct(public int $goBarberShopId) {}

    public function handle(TenantContext $context): void
    {
        $goBarberShop = GoBarberShop::query()->findOrFail($this->goBarberShopId);
        $context->set($goBarberShop);

        try {
            $this->result = Service::query()
                ->where('go_barbershop_id', $context->id())
                ->count();
        } finally {
            $context->clear();
        }
    }
}
