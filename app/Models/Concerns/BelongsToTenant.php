<?php

namespace App\Models\Concerns;

use App\Support\Tenancy\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LogicException;

/**
 * Trait untuk mengatur isolasi data berdasarkan tenant.
 *
 * @mixin Model
 */
trait BelongsToTenant
{
    /**
     * Mendaftarkan Global Scope dan event model.
     */
    protected static function bootBelongsToTenant(): void
    {
        // GLOBAL SCOPE: membatasi data sesuai barbershop aktif.
        static::addGlobalScope(
            'tenant',
            function (Builder $builder): void {
                $tenantContext = app(TenantContext::class);

                if (! $tenantContext->has()) {
                    $builder->whereRaw('1 = 0');

                    return;
                }

                $tenantId = $tenantContext->id();
                $model = $builder->getModel();
                $relationship = $model->tenantRelationship();

                // Model yang menggunakan relasi tenant, seperti Barber.
                if ($relationship !== null) {
                    $builder->whereHas(
                        $relationship,
                        function (Builder $query) use ($tenantId): void {
                            $relatedModel = $query->getModel();

                            $query->where(
                                $relatedModel->qualifyColumn(
                                    'go_barbershop_id'
                                ),
                                $tenantId
                            );
                        }
                    );

                    return;
                }

                // Model yang memiliki kolom go_barbershop_id, seperti Service.
                $builder->where(
                    $model->qualifyColumn('go_barbershop_id'),
                    $tenantId
                );
            }
        );

        // SAVING: memvalidasi kepemilikan tenant sebelum menyimpan.
        static::saving(
            function (Model $model): void {
                $tenantContext = app(TenantContext::class);

                if (! $tenantContext->has()) {
                    throw new LogicException(
                        'TenantContext harus diisi sebelum data tenant disimpan.'
                    );
                }

                $tenantId = $tenantContext->id();
                $relationship = $model->tenantRelationship();

                // Validasi model yang menggunakan relasi tenant, seperti Barber.
                if ($relationship !== null) {
                    $relation = $model->{$relationship}();

                    if (! $relation instanceof BelongsTo) {
                        throw new LogicException(
                            'Relasi tenant harus menggunakan belongsTo.'
                        );
                    }

                    $foreignKey = $relation->getForeignKeyName();
                    $relatedId = $model->getAttribute($foreignKey);

                    if ($relatedId === null) {
                        $relatedId = $tenantId;
                        $model->setAttribute($foreignKey, $relatedId);
                    }

                    $relatedShop = $relation->getRelated()
                        ->newQueryWithoutScopes()
                        ->whereKey($relatedId)
                        ->first();

                    if (
                        ! $relatedShop
                        || (int) $relatedShop->getKey() !== $tenantId
                    ) {
                        throw new LogicException(
                            'Data terkait bukan milik barbershop aktif.'
                        );
                    }

                    return;
                }

                // Validasi model yang menggunakan go_barbershop_id.
                $modelTenantId = $model->getAttribute(
                    'go_barbershop_id'
                );

                $originalTenantId = $model->getRawOriginal(
                    'go_barbershop_id'
                );

                if (
                    $model->exists
                    && $originalTenantId !== null
                    && (int) $originalTenantId !== $tenantId
                ) {
                    throw new LogicException(
                        'Data tidak dapat dipindahkan dari barbershop lain.'
                    );
                }

                if (
                    $modelTenantId !== null
                    && (int) $modelTenantId !== $tenantId
                ) {
                    throw new LogicException(
                        'Data tidak dapat dipindahkan ke barbershop lain.'
                    );
                }

                // Isi tenant secara otomatis.
                $model->setAttribute(
                    'go_barbershop_id',
                    $tenantId
                );
            }
        );
    }

    /**
     * Nama relasi tenant.
     * Model dengan foreign key berbeda dapat mengubah method ini.
     */
    protected function tenantRelationship(): ?string
    {
        return null;
    }
}
