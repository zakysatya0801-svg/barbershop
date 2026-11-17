<?php

namespace App\Http\Controllers;

use App\Models\BarbershopQrToken;
use Illuminate\Http\RedirectResponse;

class BarbershopQrScanController extends Controller
{
    public function __invoke(string $token): RedirectResponse
    {
        $qrToken = BarbershopQrToken::query()
            ->active()
            ->where('token_hash', hash('sha256', $token))
            ->with('barbershop')
            ->firstOrFail();

        return redirect()->route('shops.show', $qrToken->barbershop);
    }
}
