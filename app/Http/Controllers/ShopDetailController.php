<?php

namespace App\Http\Controllers;

use App\Models\GoBarberShop;
use Illuminate\Database\Eloquent\Builder;

class ShopDetailController extends Controller
{
    public function show($shop)
    {
        // Mengambil data barbershop berdasarkan ID
        $barbershop = GoBarberShop::with([
            'location',
            'services' => fn ($query) => $query->withoutGlobalScope('tenant'),
            'barbers' => fn ($query) => $query->withoutGlobalScope('tenant'),
            'reviews' => fn ($query) => $query->withoutGlobalScope('tenant'),
        ])
            ->withAvg([
                'reviews' => fn (Builder $query) => $query->withoutGlobalScope('tenant'),
            ], 'rating')
            ->withCount([
                'reviews' => fn (Builder $query) => $query->withoutGlobalScope('tenant'),
            ])
            ->where('go_barbershop_id', $shop)
            ->firstOrFail();

        // Menampilkan halaman detail barbershop
        return view('customer.shops.show', compact('barbershop'));
    }
}
