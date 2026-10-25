<?php

namespace App\Models\Concerns;

use App\Support\Tenancy\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LogicException;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder): void {
            $tenantContext = app(TenantContext::class);

            if (! $tenantContext->has()) {
                $builder->whereRaw('1 = 0');

                return;
            }

            $tenantId = $tenantContext->id();
            $tenantRelationship = $builder->getModel()->tenantRelationship();

            if ($tenantRelationship !== null) {
                $builder->whereHas(
                    $tenantRelationship,
                    function (Builder $query) use ($tenantId): void {
                        $query->where('go_barbershop_id', $tenantId);
                    }
                );

                return;
            }

            $builder->where(
                $builder->qualifyColumn('go_barbershop_id'),
                $tenantId
            );
        });

        static::saving(function (Model $model): void {
            $tenantContext = app(TenantContext::class);

            if (! $tenantContext->has()) {
                throw new LogicException(
                    'TenantContext harus diisi sebelum data tenant disimpan.'
                );
            }

            $tenantId = $tenantContext->id();
            $tenantRelationship = $model->tenantRelationship();

            if ($tenantRelationship !== null) {
                $relation = $model->{$tenantRelationship}();
                $originalRelatedId = $model->getRawOriginal(
                    $relation->getForeignKeyName()
                );

                if (
                    $model->exists
                    && $originalRelatedId !== null
                    && ! $relation->getRelated()
                        ->newQuery()
                        ->whereKey($originalRelatedId)
                        ->exists()
                ) {
                    throw new LogicException(
                        'Data tidak dapat dipindahkan dari barbershop lain.'
                    );
                }

                if (! $relation
                    ->where('go_barbershop_id', $tenantId)
                    ->exists()) {
                    throw new LogicException(
                        'Data terkait bukan milik barbershop aktif.'
                    );
                }

                return;
            }

            $modelTenantId = $model->getAttribute('go_barbershop_id');
            $originalTenantId = $model->getRawOriginal('go_barbershop_id');

            if (
                $model->exists
                && $originalTenantId !== null
                && (int) $originalTenantId !== $tenantId
            ) {
                throw new LogicException(
                    'Data tidak dapat dipindahkan dari barbershop lain.'
                );
            }

            if ($modelTenantId !== null && (int) $modelTenantId !== $tenantId) {
                throw new LogicException(
                    'Data tidak dapat dipindahkan ke barbershop lain.'
                );
            }

            $model->setAttribute('go_barbershop_id', $tenantId);
        });
    }

    protected function tenantRelationship(): ?string
    {
        return null;
    }
}
