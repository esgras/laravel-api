<?php

namespace App\Entities;

//use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Entities\Test
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Foo[] $foos
 * @property-read int|null $foos_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Test whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Test whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Test whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Test whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Test extends Model
{
    public function change(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function foos(): HasMany
    {
        return $this->hasMany(Foo::class);
    }

    public function addFoo(Foo $foo): self
    {
        $foo->test_id = $this->id;

        return $this;
    }
}
