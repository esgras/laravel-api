<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Retailer;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class RetailerRepository
{
    public function get(string $id): Retailer
    {
        return Retailer::findOrFail($id);
    }

    /**
     * @throws Exception
     */
    public function delete(Retailer $retailer): void
    {
        $retailer->delete();
    }

    /**
     * @return Collection|Retailer[]
     */
    public function findAll(): Collection
    {
        return Retailer::all();
    }

    public function save(Retailer $retailer): Retailer
    {
        $retailer->save();

        return $retailer;
    }
}
