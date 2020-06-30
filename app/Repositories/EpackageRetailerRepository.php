<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Epackage;
use App\Entities\EpackageRetailer;
use App\Entities\Retailer;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class EpackageRetailerRepository
{
    public function get(string $id): EpackageRetailer
    {
        try {
            return EpackageRetailer::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException('Epackage retailer not found', Response::HTTP_NOT_FOUND, $exception);
        }
    }

    public function save(EpackageRetailer $epackageRetailer): EpackageRetailer
    {
        $epackageRetailer->save();
        return $epackageRetailer;
    }

    public function delete(EpackageRetailer $epackageRetailer): void
    {
        $epackageRetailer->delete();
    }

    /**
     * @param string $epackageId
     * @param string $retailerId
     * @return EpackageRetailer
     * @throws NotFoundException
     */
    public function getByEpackageAndRetailer(string $epackageId, string $retailerId): EpackageRetailer
    {
        try {
            return EpackageRetailer::where('epackage_id', '=', $epackageId)
                ->where('retailer_id', '=', $retailerId)
                ->singleOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException(
                sprintf('Epackage %s not assigned to retailer %s', $epackageId, $retailerId),
                Response::HTTP_NOT_FOUND,
                $exception
            );
        }
    }
}
