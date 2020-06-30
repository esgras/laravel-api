<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Entities\Brand;
use App\Repositories\BrandRepository;
use App\Services\Dto\BrandDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class BrandService
{
    private BrandRepository $brandRepository;

    public function __construct(
        BrandRepository $brandRepository
    ) {
        $this->brandRepository = $brandRepository;
    }

    public function get(string $id): Brand
    {
        return $this->brandRepository->get($id);
    }

    public function delete(string $id): void
    {
        $brand = $this->brandRepository->get($id);
        $this->brandRepository->delete($brand);
    }

    public function create(BrandDto $brandDto): Brand
    {
        $brand = new Brand;
        $brand->name = $brandDto->name;

        return $this->brandRepository->save($brand);
    }

    public function update(Brand $brand, BrandDto $brandDto): Brand
    {
        $brand->name = $brandDto->name;

        return $this->brandRepository->save($brand);
    }

    /**
     * @return Collection|Brand[]
     */
    public function findAll(): Collection
    {
        return $this->brandRepository->findAll();
    }
}
