<?php

use Illuminate\Database\Seeder;
use App\Entities\Retailer;

class RetailerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getRetailerData() as $name => $domain) {
            factory(Retailer::class)->create([
                'name' => $name,
                'domain' => $domain
            ]);
        }
    }

    private function getRetailerData(): array
    {
        return [
            'Yandex market' => 'market.yandex.ru',
            'Holodilnik' => 'www.holodilnik.ru',
            'Technopark' => 'www.technopark.ru',
            'Citilink' => 'www.citilink.ru',
            'DNS' => 'www.dns-shop.ru',
            'Mvideo' => 'www.mvideo.ru',
            'Onlinetrade' => 'www.onlinetrade.ru',
            'OZON' => 'www.ozon.ru',
            'Techport' => 'www.techport.ru',
            'Eldorado' => 'www.eldorado.ru',
            'KorpCentr' => 'kcentr.ru',
            'RBT' => 'www.rbt.ru',
            'BERU' => 'beru.ru',
            'Ulmart' => 'www.ulmart.ru',
            'Wildberries' => 'www.wildberries.ru',
            'Nord24' => 'www.nord24.ru',
            'Technopoint' => 'technopoint.ru',
            'Goods' => 'goods.ru',
            'Poiskhome' => 'poiskhome.ru',
            'Империя Техно' => 'www.imperiatechno.ru',
            'Polno' => 'www.polno.ru',
            'Tmall' => 'tmall.ru',
        ];
    }
}
