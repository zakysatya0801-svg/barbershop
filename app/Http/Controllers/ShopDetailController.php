<?php

namespace App\Http\Controllers;

use App\Models\GoBarberShop;

class ShopDetailController extends Controller
{
    public function show($shop)
    {
        // Mengambil data barbershop berdasarkan ID
        $barbershop = GoBarberShop::with([
            'location',
            'services',
            'barbers',
            'reviews',
        ])
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->where('go_barbershop_id', $shop)
        ->firstOrFail();

        // Menampilkan halaman detail barbershop
        return view('customer.shops.show', compact('barbershop'));
    }
}
