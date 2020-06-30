<?php

namespace App\Http\Requests;

use App\Entities\Epackage;
use App\Services\Dto\EpackageRetailerDto;

class EpackageRetailerRequest extends ApiRequest
{
    use DisableValidationTrait;

    public function getDto(): EpackageRetailerDto
    {
        $dto = new EpackageRetailerDto();
        $dto->skuId = $this->get('skuId');

        return $dto;
    }
}
