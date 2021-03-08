<?php

namespace App\Http\Resources;

use App\Entities\EpackageRetailer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EpackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $brand = $this->brand;
        $epackageRetailers = [];

        /** @var EpackageRetailer $epackageRetailer */
        foreach ($this->epackageRetailers as $epackageRetailer) {
            $retailer = $epackageRetailer->retailer;

            $epackageRetailers[] = [
                "id" => $epackageRetailer->id,
                "skuId" => $epackageRetailer->skuId,
                "epackageId" => $this->id,
                "retailerId" => $retailer->id,
                "retailer" => $retailer->name,
                'createdAt' => $epackageRetailer->created_at,
                'updatedAt' => $epackageRetailer->updated_at,
                "epackageLink" => $epackageRetailer->epackageLink,
            ];
        }

        $epackage = [
            'id' => $this->id,
            'product' => [
                'name' => $this->productName,
                'mpn' => $this->mpn,
                'ean' => $this->ean
            ],
            'brand' => [
                'id' => $brand->id,
                'name' => $brand->name,
                'createdAt' => $brand->created_at,
                'updatedAt' => $brand->updated_at
            ],
            'cmsId' => $this->cmsId,
            'cmsPackId' => $this->cmsPackId,
            "epackage_retailers" => $epackageRetailers,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];

        return $epackage;
    }
}
