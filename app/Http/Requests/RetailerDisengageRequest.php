<?php

namespace App\Http\Requests;

use App\Services\Dto\RetailerAssignDto;
use App\Services\Dto\RetailerDisengageDto;

class RetailerDisengageRequest extends ApiRequest
{
    use DisableValidationTrait;

    /**
     * @return RetailerAssignDto[]
     */
    public function getDtos(): array
    {
        $dtos = [];
        foreach ($this->getBulkArrayInput() as $item) {
            $dto = new RetailerDisengageDto();
            $dto->retailerId = $item['retailerId'] ?? '';
            $dtos[] = $dto;
        }

        return $dtos;
    }
}
