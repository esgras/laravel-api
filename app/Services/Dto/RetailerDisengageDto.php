<?php
declare(strict_types=1);

namespace App\Services\Dto;

use App\Utils\ValidateEntityInterface;

class RetailerDisengageDto implements ValidateEntityInterface
{
    public string $retailerId;

    public function toArray(): array
    {
        return [
            'retailerId' => $this->retailerId,
        ];
    }

    public function rules(): array
    {
        return [
            'retailerId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
