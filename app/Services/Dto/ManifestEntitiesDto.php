<?php
declare(strict_types=1);

namespace App\Services\Dto;


use App\Entities\Brand;

class ManifestEntitiesDto
{
    public ManifestDto $manifestDto;
    public Brand $brand;
}
