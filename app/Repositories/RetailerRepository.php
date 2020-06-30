<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Retailer;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class RetailerRepository
{
    /**
     * @param string $id
     * @return Retailer
     * @throws NotFoundException
     */
    public function get(string $id): Retailer
    {
        try {
            return Retailer::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException('Retailer not found', Response::HTTP_NOT_FOUND, $exception);
        }
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
