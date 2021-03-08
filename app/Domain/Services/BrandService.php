<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Entities\Brand;
use App\Entities\Retailer;
use App\Events\BrandDeleted;
use App\Exceptions\NotFoundException;
use App\Repositories\BrandRepository;
use App\Repositories\RetailerRepository;
use App\Services\Dto\BrandDto;
use App\Services\Epackage\EpackageExtractor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class BrandService
{
    private BrandRepository $brandRepository;
    private EpackageExtractor $epackageExtractor;

    public function __construct(
        BrandRepository $brandRepository,
        EpackageExtractor $epackageExtractor,
        RetailerRepository $retailerRepository
    ) {
        $this->brandRepository = $brandRepository;
        $this->epackageExtractor = $epackageExtractor;
        $this->retailerRepository = $retailerRepository;
    }

    public function get(string $id): Brand
    {
        return $this->brandRepository->get($id);
    }

    public function delete(string $id): void
    {
        $brand = $this->brandRepository->get($id);

        event(new BrandDeleted($brand->id));

        $this->brandRepository->delete($brand);
    }

    public function create(BrandDto $brandDto): Brand
    {
        $brand = new Brand;
        $brand->name = $brandDto->name;

        $brand = $this->brandRepository->save($brand);
        $this->createBrandRetailers($brand);

        return $brand;
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

    public function createAllBrandRetailers(): void
    {
        $brands = $this->brandRepository->findAll();
        $retailers = $this->retailerRepository->findAll();
        foreach ($brands as $brand) {
            foreach ($retailers as $retailer) {
                try {
                    $brand->getBrandRetailer($retailer);
                } catch (NotFoundException $exception) {
                    $brand->makeBrandRetailer($retailer);
                }
            }
        }
    }

    public function createBrandRetailersByBrand(Brand $brand): void
    {
        $retailers = $this->retailerRepository->findAll();
        foreach ($retailers as $retailer) {
            $brand->makeBrandRetailer($retailer);
        }
    }

    public function createBrandRetailersByRetailer(Retailer $retailer): void
    {
        $brands = $this->brandRepository->findAll();
        foreach ($brands as $brand) {
            $retailer->makeBrandRetailer($brand);
        }
    }

    public function activateRetailer(string $brandId, string $retailerId): Brand
    {
        $brand = $this->brandRepository->get($brandId);
        $retailer = $this->retailerRepository->get($retailerId);

        $brandRetailer = $brand->getBrandRetailer($retailer);
        $brandRetailer->activate();
    }

    public function deactivateRetailer(string $brandId, string $retailerId): Brand
    {
        /** @todo Implement */
    }
}
