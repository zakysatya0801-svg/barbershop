<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use BelongsToTenant;

    protected $table = 'services';

    protected $primaryKey = 'service_id';

    protected $fillable = [
        'shop_id',
        'service_name',
        'photo',
        'price',
        'duration',
    ];

    // Menghubungkan layanan dengan barbershop
    public function goBarberShop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'shop_id',
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
