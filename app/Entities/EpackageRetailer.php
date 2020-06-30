<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

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
 */
class EpackageRetailer extends Model
{
    //
}
