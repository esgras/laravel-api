<?php

namespace App\Http\Requests;

use App\Services\Dto\RetailerAssignDto;

class RetailerAssignRequest extends ApiRequest
{
    use DisableValidationTrait;

    /**
     * @return RetailerAssignDto[]
     */
    public function getDtos(): array
    {
        $dtos = [];
        foreach ($this->getBulkArrayInput() as $item) {
            $dto = new RetailerAssignDto();
            $dto->retailerId = $item['retailerId'] ?? '';
            $dto->skuId = $item['skuId'] ?? '';
            $dtos[] = $dto;
        }

        return $dtos;
    }
}
