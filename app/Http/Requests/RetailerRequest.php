<?php

namespace App\Http\Requests;

use App\Services\Dto\RetailerDto;

class RetailerRequest extends ApiRequest
{
    use DisableValidationTrait;

    private RetailerDto $dto;

    public function __construct()
    {
        parent::__construct();

        $this->dto = new RetailerDto();
    }

    public function rules(): array
    {
        return $this->dto->rules();
    }

    public function getDto(): RetailerDto
    {
        $this->dto->name = $this->get('name');
        $this->dto->domain = $this->get('domain');
        $this->dto->productIdField = $this->get('productIdField');

        return $this->dto;
    }

    public function messages(): array
    {
        return $this->dto->messages();
    }
}
