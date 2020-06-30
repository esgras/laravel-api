<?php

namespace App\Entities;

//use Illuminate\Database\Eloquent\Model;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Entities\Foo
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $test_id
 * @property-read \App\Entities\Test $test
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Foo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Foo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Foo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Foo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Foo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Foo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Foo whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Foo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Foo extends Model
{
    public function change(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
