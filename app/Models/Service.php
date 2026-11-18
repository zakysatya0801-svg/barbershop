<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    // Menggunakan sistem pembatasan data berdasarkan tenant.
    use BelongsToTenant;

    // Nama tabel database.
    protected $table = 'services';

    // Primary key tabel.
    protected $primaryKey = 'service_id';

    // Kolom yang boleh diisi melalui mass assignment.
    protected $fillable = [
        'service_name',
        'photo',
        'price',
        'duration',
    ];

    // Relasi Service dengan barbershop pemiliknya.
    public function goBarbershop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }
}
