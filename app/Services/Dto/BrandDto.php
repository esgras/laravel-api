<?php
declare(strict_types=1);

namespace App\Services\Dto;

use App\Entities\Brand;
use App\Utils\ValidateEntityInterface;
use Illuminate\Validation\Rule;

class BrandDto implements ValidateEntityInterface
{
    public ?string $id = null;
    public string $name;

    public function toArray(): array
    {
        return [
            'name' => $this->name
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:2', Rule::unique(Brand::class)->ignore($this->id)]
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Brand name is used'
        ];
    }
}
