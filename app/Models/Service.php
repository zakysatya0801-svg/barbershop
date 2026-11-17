<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use BelongsToTenant;

    // Menentukan tabel yang digunakan model.
    protected $table = 'services';

    // Menentukan primary key tabel services.
    protected $primaryKey = 'service_id';

    protected $fillable = [
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

    // Mengatur tipe data
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration' => 'integer',
        ];
    }
}
