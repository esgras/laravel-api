<?php
declare(strict_types=1);

namespace App\Services\Dto;

use App\Utils\ValidateEntityInterface;
use Illuminate\Validation\Rule;

class RetailerAssignDto implements ValidateEntityInterface
{
    public string $epackageId;
    public string $retailerId;
    public string $skuId;

    public function toArray(): array
    {
        return [
            'epackage_id' => $this->epackageId,
            'retailer_id' => $this->retailerId,
            'skuId' => $this->skuId,
        ];
    }

    public function rules(): array
    {
        $uuidv4 = config('params.routing.uuid_v4');
        $self = $this;

        return [
            'retailer_id' => [
                'required',
                'regex:/' . $uuidv4 . '/',
                Rule::unique('epackage_retailers')->where(function ($query) use ($self) {
                    return $query->where('epackage_id', $self->epackageId)->where('retailer_id', $self->retailerId);
                })
            ],
            'skuId' => [
                'required',
                Rule::unique('epackage_retailers')->where(function($query) use ($self) {
                    return $query->where('retailer_id', $self->retailerId)->where('skuId', $self->skuId);
                })
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'retailer_id.unique' => 'Epackage already connected to retailer :input',
            'skuId.unique' => 'skuId already :input already used by retailer',
        ];
    }
}
