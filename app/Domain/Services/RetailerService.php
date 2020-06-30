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

    public function __construct(
        RetailerRepository $retailerRepository
    ) {
        $this->retailerRepository = $retailerRepository;
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
        $Retailer = new Retailer;
        $Retailer->name = $retailerDto->name;
        $Retailer->domain = $retailerDto->domain;
        $Retailer->productIdField = $retailerDto->productIdField;

        return $this->retailerRepository->save($Retailer);
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
