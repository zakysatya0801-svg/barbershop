<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    // Menentukan tabel yang digunakan model.
    protected $table = 'services';

    // Menentukan primary key tabel services.
    protected $primaryKey = 'service_id';

    // Kolom yang boleh diisi melalui mass assignment.
    protected $fillable = [
        'go_barbershop_id',
        'service_name',
        'photo',
        'price',
        'duration',
    ];

    // Setiap service dimiliki oleh satu barbershop.
    public function goBarbershop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }
}