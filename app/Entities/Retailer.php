<?php

namespace App\Entities;

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
 */
class Retailer extends Model
{
    public const PRODUCT_ID_FIELD_VALUES = ['mpn', 'ean'];

    public function epackageRetailers(): HasMany
    {
        return $this->hasMany(EpackageRetailer::class);
    }
}
