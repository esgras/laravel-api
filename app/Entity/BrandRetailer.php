<?php

namespace App\Entity;

use App\Entities\Brand;
use App\Entities\Retailer;
use App\Traits\ActiveEntityTrait;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Entity\BrandRetailer
 *
 * @property string $id
 * @property string $retailer_id
 * @property string $brand_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entities\Brand $brand
 * @property-read \App\Entities\Retailer $retailer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\BrandRetailer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\BrandRetailer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\BrandRetailer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\BrandRetailer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\BrandRetailer whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\BrandRetailer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\BrandRetailer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\BrandRetailer whereRetailerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\BrandRetailer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BrandRetailer extends Model
{
    use ActiveEntityTrait;

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }

    public function activate(): self
    {
        $this->active = true;
        $this->save();

        return $this;
    }

    public function deactivate(): self
    {
        $this->active = false;
        $this->save();

        return $this;
    }
}
