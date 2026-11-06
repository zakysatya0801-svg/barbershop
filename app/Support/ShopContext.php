<?php

namespace App\Support;

use App\Models\GoBarberShop;

class ShopContext
{
    protected ?GoBarberShop $shop = null;

    public function set(GoBarberShop $shop): void
    {
        $this->shop = $shop;
    }

    public function get(): ?GoBarberShop
    {
        return $this->shop;
    }

    public function id(): ?int
    {
        return $this->shop?->go_barbershop_id;
    }

    public function hasShop(): bool
    {
        return $this->shop !== null;
    }

    public function clear(): void
    {
        $this->shop = null;
    }
}
