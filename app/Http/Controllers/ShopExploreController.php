<?php

namespace App\Http\Controllers;

use App\Models\GoBarberShop;
use App\Models\Location;
use Illuminate\Http\Request;

class ShopExploreController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data barbershop beserta lokasi dan layanan.
        $query = GoBarberShop::with(['location', 'services']);

        // Filter berdasarkan nama barbershop.
        if ($request->filled('search')) {
            $query->where('barbershop_name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kota.
        if ($request->filled('city')) {
            $query->whereHas('location', function ($q) use ($request) {
                $q->where('city', $request->city);
            });
        }

        // Filter berdasarkan harga maksimal layanan.
        if ($request->filled('max_price')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('price', '<=', $request->max_price);
            });
        }

        // Filter barbershop yang sedang buka.
        if ($request->boolean('open_now')) {
            $now = now('Asia/Jakarta')->format('H:i:s');

            $query->where('open_time', '<=', $now)
                  ->where('close_time', '>=', $now);
        }

        // Mengambil data barbershop dengan pagination.
        $shops = $query->paginate(4)->withQueryString();

        // Mengambil daftar kota untuk filter.
        $cities = Location::whereNotNull('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        // Menampilkan halaman Jelajah Barbershop.
        return view('customer.shops.index', [
            'shops' => $shops,
            'cities' => $cities,
        ]);
    }
}
