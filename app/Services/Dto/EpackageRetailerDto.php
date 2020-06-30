<?php
declare(strict_types=1);

namespace App\Services\Dto;

use App\Utils\ValidateEntityInterface;
use Illuminate\Validation\Rule;

class EpackageRetailerDto implements ValidateEntityInterface
{
    public string $id;
    public string $retailerId;
    public string $skuId;

    public function toArray(): array
    {
        return [
            'skuId' => $this->skuId,
        ];
    }

    public function rules(): array
    {
        $self = $this;

        return [
            'skuId' => [
                'required',
                Rule::unique('epackage_retailers')->where(function ($query) use ($self) {
                    return $query->where([
                        ['retailer_id', '=', $self->retailerId],
                        ['skuId', '=', $self->skuId],
                    ]);
                })->ignore($this->id)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'skuId.unique' => 'skuId already :input already used by retailer',
        ];
    }
}
