<?php
declare(strict_types=1);

namespace App\Domain\Services;


use App\Domain\Factory\EpackageRetailerFactory;
use App\Entities\Epackage;
use App\Entities\EpackageRetailer;
use App\Entities\Retailer;
use App\Repositories\RetailerRepository;
use App\Services\Dto\RetailerAssignDto;

class EpackageRetailerService
{
    private RetailerRepository $retailerRepository;
    private EpackageRetailerFactory $epackageRetailerFactory;

    public function __construct(
        RetailerRepository $retailerRepository,
        EpackageRetailerFactory $epackageRetailerFactory
    ) {
        $this->retailerRepository = $retailerRepository;
        $this->epackageRetailerFactory = $epackageRetailerFactory;
    }

    public function assignRetailersToEpack(Epackage $epackage, array $retailerAssignDtos): void
    {
        foreach ($retailerAssignDtos as $retailerAssignDto) {
            $this->assignRetailerToEpack(
                $epackage,
                $retailerAssignDto
            );
        }
    }

    public function assignRetailerToEpack(Epackage $epackage, RetailerAssignDto $retailerAssignDto): void
    {
        $retailer = $this->retailerRepository->get($retailerAssignDto->retailerId);
        $this->makeEpackageRetailer($epackage, $retailer, $retailerAssignDto);
    }

    public function makeEpackageRetailer(
        Epackage $epackage,
        Retailer $retailer,
        RetailerAssignDto $assignDto
    ): EpackageRetailer {
        $epackageRetailer = $this->epackageRetailerFactory->create($epackage, $retailer, $assignDto);
        $this->saveEpackageRetailer($epackageRetailer);

        return $epackageRetailer;
    }
}
