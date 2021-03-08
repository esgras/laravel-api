<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Entities\Retailer;
use App\Repositories\RetailerRepository;
use App\Services\Dto\RetailerDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class RetailerService
{
    private RetailerRepository $retailerRepository;
    private BrandService $brandService;

    public function __construct(
        RetailerRepository $retailerRepository,
        BrandService $brandService
    ) {
        $this->retailerRepository = $retailerRepository;
        $this->brandService = $brandService;
    }

    public function get(string $id): Retailer
    {
        return $this->retailerRepository->get($id);
    }

    public function delete(string $id): void
    {
        $Retailer = $this->retailerRepository->get($id);
        $this->retailerRepository->delete($Retailer);
    }

    public function create(RetailerDto $retailerDto): Retailer
    {
        $retailer = new Retailer;
        $retailer->name = $retailerDto->name;
        $retailer->domain = $retailerDto->domain;
        $retailer->productIdField = $retailerDto->productIdField;

        $this->retailerRepository->save($retailer);

        $this->brandService->createBrandRetailersByRetailer($retailer);

        return $retailer;
    }

    public function update(Retailer $Retailer, RetailerDto $retailerDto): Retailer
    {
        $Retailer->name = $retailerDto->name;

        return $this->retailerRepository->save($Retailer);
    }

    /**
     * @return Collection|Retailer[]
     */
    public function findAll(): Collection
    {
        return $this->retailerRepository->findAll();
    }
}
