<?php
declare(strict_types=1);

namespace App\Services\Dto;

use App\Utils\ValidateEntityInterface;

class ManifestDto implements ValidateEntityInterface
{
    public string $emsId;
    public string $packageId;
    public string $brandName;
    public string $productName;
    public string $mpn;
    public string $ean;
    public array $data;

    public function toArray(): array
    {
        return [
            'packageId' => $this->packageId ?? null,
            'emsId' => $this->emsId ?? null,
            'brandName' => $this->brandName ?? null,
            'productName' => $this->productName ?? null,
            'mpn' => $this->mpn ?? null,
            'ean' => $this->ean ?? null,
            'data' => $this->data ?? []
        ];
    }

    public function rules(): array
    {
        return [
            'packageId' => 'required',
            'emsId' => 'required',
            'brandName' => 'required',
            'productName' => 'required',
            'mpn' => 'required',
            'ean' => 'required',
            'data' => 'required'
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
