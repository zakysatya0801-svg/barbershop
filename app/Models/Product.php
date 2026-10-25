<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use BelongsToTenant;

    protected $table = 'produks';

    protected $primaryKey = 'produk_id';

    // Kolom yang boleh diisi melalui mass assignment.
    protected $fillable = [
        'name_product',
        'price',
        'description',
        'photo',
    ];

    // Menghubungkan produk dengan barbershop pemiliknya.
    public function goBarberShop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    // Mengatur tipe data harga produk.
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }
}
