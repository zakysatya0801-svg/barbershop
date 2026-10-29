<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GoBarberShop extends Model
{
    protected $table = 'go_barbershops';

    protected $primaryKey = 'go_barbershop_id';

    protected $fillable = [
        'owner_id',
        'location_id',
        'barbershop_name',
        'description',
        'photo',
        'open_time',
        'close_time',
    ];
    
public function qrTokens(): HasMany
{
    return $this->hasMany(BarbershopQrToken::class);
}

public function activeToken(): HasOne
{
    return $this->hasOne(BarbershopQrToken::class)
        ->ofMany('issued_at', 'max', function ($query) {
            $query->where('status', 'active')
                ->whereNull('revoked_at')
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                });
        });
}


    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'owner_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function commissionSchemes(): HasMany
    {
        return $this->hasMany(
            CommissionScheme::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }
}
