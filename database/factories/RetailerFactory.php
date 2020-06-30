<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Entities\Retailer;

$factory->define(Retailer::class, function (Faker $faker) {
    $productIdFieldValues = Retailer::PRODUCT_ID_FIELD_VALUES;

    return [
        'name' => $faker->firstName,
        'domain' => $faker->domainName,
        'productIdField' => reset($productIdFieldValues)
    ];
});
