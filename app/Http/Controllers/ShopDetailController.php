<?php

namespace App\Http\Controllers;

use App\Models\GoBarberShop;
use Illuminate\Database\Eloquent\Builder;

class ShopDetailController extends Controller
{
    public function show($shop)
    {
        $barbershop = GoBarberShop::with([
            'location',

            // Mengambil layanan milik barbershop ini.
            'services' => function ($query) {
                $query->withoutGlobalScope('tenant')
                    ->orderBy('service_name');
            },

            // Mengambil barber milik barbershop ini.
            'barbers' => function ($query) {
                $query->withoutGlobalScope('tenant');
            },

            'reviews' => function ($query) {
                $query->withoutGlobalScope('tenant');
            },
        ])
            ->withAvg([
                'reviews' => fn (Builder $query) =>
                    $query->withoutGlobalScope('tenant'),
            ], 'rating')
            ->withCount([
                'reviews' => fn (Builder $query) =>
                    $query->withoutGlobalScope('tenant'),
            ])
            ->where('go_barbershop_id', $shop)
            ->firstOrFail();

        return view('customer.shops.show', compact('barbershop'));
    }
}
