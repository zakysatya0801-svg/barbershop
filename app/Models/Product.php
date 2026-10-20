<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'produks';

    protected $primaryKey = 'produk_id';

    // Kolom yang boleh diisi melalui mass assignment.
    protected $fillable = [
        'go_barbershop_id',
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
