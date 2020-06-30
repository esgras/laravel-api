<?php
declare(strict_types=1);

namespace App\Services\Dto;

use App\Utils\ValidateEntityInterface;

class RetailerAssignDto implements ValidateEntityInterface
{
    public string $epackageId;
    public string $retailerId;
    public string $skuId;

    public function toArray(): array
    {
        return [
            'epackageId' => $this->epackageId,
            'retailerId' => $this->retailerId,
            'skuId' => $this->skuId,
        ];
    }

    public function rules(): array
    {
        $uuidv4 = config('params.routing.uuid_v4');

        return [
            'retailerId' => 'required|regex:/'.$uuidv4.'/',
            'skuId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
