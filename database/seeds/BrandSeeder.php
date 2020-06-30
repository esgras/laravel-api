<?php

use Illuminate\Database\Seeder;
use App\Entities\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = ['Hansa', 'Panasonic', 'Philips', 'Electrolux', 'LG'];
        foreach ($brands as $brandName) {
            factory(Brand::class)->create([
                'name' => $brandName
            ]);
        }
    }
}
