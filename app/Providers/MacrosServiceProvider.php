<?php

namespace App\Providers;

use App\Exceptions\NotUniqueResultException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;
use \Illuminate\Database\Eloquent\Builder;

class MacrosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return voidf
     */
    public function boot()
    {
        Builder::macro('singleOrFail', function () {
            $result = $this->get();
            if (!$result->count()) {
                throw new ModelNotFoundException('No results');
            }

            if ($result->count() == 1) {
                return $result->first();
            }
            throw new NotUniqueResultException('Not unique result exception');
        });

    }
}
