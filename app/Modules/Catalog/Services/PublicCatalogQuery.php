<?php

namespace App\Modules\Catalog\Services;

use App\Models\Barber;
use App\Models\GoBarberShop;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

final class PublicCatalogQuery
{
    /**
     * @return array{
     *     services: Collection<int, Service>,
     *     barbers: Collection<int, Barber>,
     *     products: Collection<int, Product>
     * }
     */
    public function forBarbershop(GoBarberShop $barbershop): array
    {
        $barbershopId = $barbershop->go_barbershop_id;

        return [
            'services' => Service::query()
                ->withoutGlobalScope('tenant')
                ->where('go_barbershop_id', $barbershopId)
                ->orderBy('service_name')
                ->get([
                    'service_id',
                    'go_barbershop_id',
                    'service_name',
                    'photo',
                    'price',
                    'duration',
                ]),
            'barbers' => Barber::query()
                ->withoutGlobalScope('tenant')
                ->where('go_barbershop_id', $barbershopId)
                ->orderBy('barber_name')
                ->get([
                    'barber_id',
                    'go_barbershop_id',
                    'barber_name',
                    'specialty',
                    'photo',
                ]),
            'products' => Product::query()
                ->withoutGlobalScope('tenant')
                ->where('go_barbershop_id', $barbershopId)
                ->orderBy('name_product')
                ->get([
                    'produk_id',
                    'go_barbershop_id',
                    'name_product',
                    'price',
                    'description',
                    'photo',
                ]),
        ];
    }
}
