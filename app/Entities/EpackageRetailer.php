<?php

namespace App\Entities;


use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Entities\EpackageRetailer
 *
 * @property int $id
 * @property string $skuId
 * @property string $epackageLink
 * @property string $epackage_id
 * @property string $retailer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EpackageRetailer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EpackageRetailer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EpackageRetailer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EpackageRetailer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EpackageRetailer whereEpackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EpackageRetailer whereEpackageLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EpackageRetailer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EpackageRetailer whereRetailerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EpackageRetailer whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EpackageRetailer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Entities\Epackage $epackage
 * @property-read \App\Entities\Retailer $retailer
 */
class EpackageRetailer extends Model
{
    public const EPACKAGE_DIR_PREFIX = 'epackages';

    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }

    public function epackage(): BelongsTo
    {
        return $this->belongsTo(Epackage::class);
    }


    public function makeEpackageLink(): void
    {
        $this->epackageLink = strtolower(
            sprintf(
                '%s/%s/%s/%s',
                self::EPACKAGE_DIR_PREFIX,
                $this->retailer->domain,
                $this->epackage->getBrandName(),
                $this->skuId
            )
        );
    }

    public function change(string $skuId): void
    {
        $this->skuId = $skuId;
        $this->makeEpackageLink();
    }

    public function canExtract(): bool
    {
        return true;
    }

    public function isActive(): bool
    {
        return true;
    }
}
