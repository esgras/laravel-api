<?php

namespace App\Entities;

use App\Entity\BrandRetailer;
use App\Exceptions\NotFoundException;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Entities\Retailer
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Retailer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Retailer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Retailer query()
 * @mixin \Eloquent
 * @property string $id
 * @property string $name
 * @property string $domain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Retailer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Retailer whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Retailer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Retailer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Retailer whereUpdatedAt($value)
 * @property string $productIdField
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Retailer whereProductIdField($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\EpackageRetailer[] $epackageRetailers
 * @property-read int|null $epackage_retailers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\BrandRetailer[] $brandRetailers
 * @property-read int|null $brand_retailers_count
 */
class Retailer extends Model
{
    protected $with = ['epackageRetailers', 'brandRetailers'];

    public const PRODUCT_ID_FIELD_VALUES = ['mpn', 'ean'];

    public function epackageRetailers(): HasMany
    {
        return $this->hasMany(EpackageRetailer::class);
    }

    public function brandRetailers(): HasMany
    {
        return $this->hasMany(BrandRetailer::class);
    }

    /**
     * @throws NotFoundException
     */
    public function getBrandRetailer(Brand $brand): BrandRetailer
    {
        foreach ($this->getBrandRetailers() as $brandRetailer) {
            if ($brandRetailer->isBrandEquals($brand)) {
                return $brandRetailer;
            }
        }

        throw new NotFoundException('BrandRetailer not found');
    }

    /**
     * @throws NotFoundException
     */
    public function isActiveForBrand(Brand $brand): bool
    {
        return $this->getBrandRetailer($brand)->isActive();
    }
}
