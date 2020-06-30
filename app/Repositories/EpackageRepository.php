<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Epackage;
use Illuminate\Database\Eloquent\Collection;

class EpackageRepository
{
    public function get(string $id): Epackage
    {
        return Epackage::findOrFail($id);
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
