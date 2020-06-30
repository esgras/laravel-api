<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Brand;
use App\Exceptions\NotUniqueResultException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

class BrandRepository
{
    public function get(string $id): Brand
    {
        return Brand::findOrFail($id);
    }

    /**
     * @param string $name
     * @return Brand
     * @throws NotFoundHttpException
     */
    public function getByName(string $name): Brand
    {
        try {
            return Brand::where('name', '=', $name)->singleOrFail();
        } catch (ModelNotFoundException | NotUniqueResultException $exception) {
            throw new NotFoundHttpException("No brand find by name {$name}");
        }
    }

    /**
     * @throws Exception
     */
    public function delete(Brand $brand): void
    {
        $brand->delete();
    }

    /**
     * @return Collection|Brand[]
     */
    public function findAll(): Collection
    {
        return Brand::all();
    }

    public function save(Brand $brand): Brand
    {
        $brand->save();

        return $brand;
    }

}
