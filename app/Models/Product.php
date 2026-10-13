<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'produks';

    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'go_barbershop_id',
        'name_product',
        'price',
        'description',
        'photo',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }
}
