<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barber extends Model
{
    use BelongsToTenant;

    // Menentukan nama tabel di database.
    protected $table = 'barbers';

    // Menentukan primary key karena bukan kolom "id" biasa.
    protected $primaryKey = 'barber_id';

    // Kolom yang boleh diisi melalui mass assignment.
    protected $fillable = [
        'barber_name',
        'specialty',
        'photo',
    ];

    // Setiap barber dimiliki oleh satu barbershop.
    public function goBarbershop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }
}
