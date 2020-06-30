<?php
declare(strict_types=1);

namespace App\Domain\Factory;

use App\Entities\Epackage;
use App\Entities\EpackageRetailer;
use App\Entities\Retailer;
use App\Services\Dto\RetailerAssignDto;

class EpackageRetailerFactory
{
    public function create(
        Epackage $epackage,
        Retailer $retailer,
        RetailerAssignDto $retailerAssignDto
    ): EpackageRetailer {
        $epackageRetailer = new EpackageRetailer();
        $epackageRetailer->epackage_id = $epackage->id;
        $epackageRetailer->retailer_id = $retailer->id;
        $epackageRetailer->skuId = $retailerAssignDto->skuId;

        return $epackageRetailer;
    }
}
