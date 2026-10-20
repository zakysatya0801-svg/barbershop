<?php

namespace App\Support\Tenancy;

use App\Models\GoBarberShop;
use RuntimeException;

/**
 * Menyimpan satu GoBarberShop aktif selama satu request/job.
 * Didaftarkan sebagai scoped() binding di AppServiceProvider agar state
 * tidak bocor antar-request/job pada queue worker atau server berdurasi panjang.
 */
final class TenantContext
{
    private ?GoBarberShop $goBarberShop = null;

    public function set(GoBarberShop $goBarberShop): void
    {
        $this->goBarberShop = $goBarberShop;
    }

    public function clear(): void
    {
        $this->goBarberShop = null;
    }

    public function has(): bool
    {
        return $this->goBarberShop !== null;
    }

    /**
     * Gagal cepat jika context belum diisi (mencegah query lintas barbershop secara tak sengaja).
     */
    public function goBarberShop(): GoBarberShop
    {
        return $this->goBarberShop ?? throw new RuntimeException('TenantContext (Barbershop) belum diisi.');
    }

    public function id(): int
    {
        return $this->goBarberShop()->go_barbershop_id;
    }

    public function idOrNull(): ?int
    {
        return $this->goBarberShop?->go_barbershop_id;
    }
}
