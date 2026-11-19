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
        'go_barbershop_id',
        'service_name',
        'photo',
        'price',
        'duration',
        'description',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration' => 'integer',
            'is_available' => 'boolean',
        ];
    }

    public function goBarbershop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'service_id';
    }
}
