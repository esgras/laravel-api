<?php

namespace App\Entities;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Entities\Brand
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand query()
 * @mixin \Eloquent
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Brand whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Epackage[] $epackages
 * @property-read int|null $epackages_count
 */
class Brand extends Model
{
    public function epackages(): HasMany
    {
        return $this->hasMany(Epackage::class);
    }
}
