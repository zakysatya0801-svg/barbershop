<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommissionScheme extends Model
{
    protected $primaryKey = 'commission_scheme_id';

    protected $fillable = [
        'go_barbershop_id',
        'commission_rate',
        'valid_from',
        'valid_to',
    ];

    protected function casts(): array
    {
        return [
            'commission_rate' => 'decimal:2',
            'valid_from' => 'datetime',
            'valid_to' => 'datetime',
        ];
    }

    public function goBarberShop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    /**
     * Mengambil tarif yang berlaku pada waktu tertentu dengan interval [mulai, selesai).
     *
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function effectiveAt(Builder $query, CarbonInterface $instant): void
    {
        $query->where('valid_from', '<=', $instant)
            ->where(function (Builder $query) use ($instant): void {
                $query->whereNull('valid_to')
                    ->orWhere('valid_to', '>', $instant);
            });
    }
}
