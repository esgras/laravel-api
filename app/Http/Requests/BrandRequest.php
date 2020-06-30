<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Services\Dto\BrandDto;

class BrandRequest extends ApiRequest
{
    use DisableValidationTrait;

    private BrandDto $dto;

    public function __construct()
    {
        parent::__construct();

        $this->dto = new BrandDto();
    }

    public function rules(): array
    {
        return $this->dto->rules();
    }

    public function getDto(): BrandDto
    {
        $this->dto->name = $this->get('name');

        return $this->dto;
    }

    public function messages(): array
    {
        return $this->dto->messages();
    }
}
