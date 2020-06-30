<?php
declare(strict_types=1);

namespace App\Services\Dto;

use App\Entities\Retailer;
use App\Utils\ValidateEntityInterface;
use Illuminate\Validation\Rule;

class RetailerDto implements ValidateEntityInterface
{
    public ?string $id = null;
    public string $name;
    public string $domain;
    public string $productIdField;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'domain' => $this->domain,
            'productIdField' => $this->productIdField
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', Rule::unique(Retailer::class)->ignore($this->id)],
            'domain' => ['required', Rule::unique(Retailer::class)->ignore($this->id)],
            'productIdField' => ['required', Rule::in(Retailer::PRODUCT_ID_FIELD_VALUES)]
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Retailer name is used',
            'domain.unique' => 'Retailer domain is used',
        ];
    }
}
