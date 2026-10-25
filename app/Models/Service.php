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

    // Kolom yang boleh diisi melalui mass assignment.
    protected $fillable = [
        'service_name',
        'photo',
        'price',
        'duration',
    ];

    // Menghubungkan layanan dengan barbershop pemiliknya.
    public function goBarberShop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    // Mengatur tipe data harga dan durasi layanan.
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration' => 'integer',
        ];
    }
}
