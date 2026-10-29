<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarbershopQrToken extends Model
{
    protected $fillable = ['status'];

    protected function casts(): array
    {
        return [
            'issued_at' => 'immutable_datetime',
            'expires_at' => 'immutable_datetime',
            'revoked_at' => 'immutable_datetime',
        ];
    }

    public function barbershop(): BelongsTo
    {
        return $this->belongsTo(go_barbershops::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active'
            && $this->revoked_at === null
            && (
                $this->expires_at === null
                || $this->expires_at->isFuture()
            );
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active')
            ->whereNull('revoked_at')
            ->where(function (Builder $query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }
}
