<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GoBarberShop;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $barbershops = GoBarberShop::query()
            ->with('activeToken')
            ->orderBy('barbershop_name')
            ->get();

        $qrImageUrls = [];

        foreach ($barbershops as $barbershop) {
            if ($barbershop->activeToken !== null) {
                $qrImageUrls[$barbershop->go_barbershop_id] = Storage::disk('public')
                    ->url($barbershop->activeToken->qrImagePath());
            }
        }

        return view('pages.admin.dashboard', compact('barbershops', 'qrImageUrls'));
    }
}
