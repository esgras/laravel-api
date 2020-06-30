<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Epackage;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class EpackageRepository
{
    public function get(string $id): Epackage
    {
        try {
            return Epackage::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException('Epackage not found', Response::HTTP_NOT_FOUND, $exception);
        }
    }

    public function save(Epackage $epackage): Epackage
    {
        $epackage->save();
        return $epackage;
    }

    public function delete(Epackage $epackage): void
    {
        $epackage->delete();
    }

    /**
     * @return Collection|Epackage[]
     */
    public function findAll(): Collection
    {
        return Epackage::all();
    }
}
