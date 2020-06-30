<?php
declare(strict_types=1);

namespace App\Domain\Services;


use App\Domain\Factory\EpackageRetailerFactory;
use App\Entities\Epackage;
use App\Entities\EpackageRetailer;
use App\Entities\Retailer;
use App\Repositories\EpackageRetailerRepository;
use App\Repositories\RetailerRepository;
use App\Services\Dto\EpackageRetailerDto;
use App\Services\Dto\RetailerAssignDto;
use App\Services\Epackage\EpackageExtractor;
use App\Traits\ValidationTrait;

class EpackageRetailerService
{
    use ValidationTrait;

    private RetailerRepository $retailerRepository;
    private EpackageRetailerRepository $epackageRetailerRepository;
    private EpackageRetailerFactory $epackageRetailerFactory;
    private EpackageExtractor $epackageExtractor;

    public function __construct(
        RetailerRepository $retailerRepository,
        EpackageRetailerRepository $epackageRetailerRepository,
        EpackageRetailerFactory $epackageRetailerFactory,
        EpackageExtractor $epackageExtractor
    ) {
        $this->retailerRepository = $retailerRepository;
        $this->epackageRetailerRepository = $epackageRetailerRepository;
        $this->epackageRetailerFactory = $epackageRetailerFactory;
        $this->epackageExtractor = $epackageExtractor;
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

    public function disengageRetailersFromEpack(Epackage $epackage, array $retailerDisengageDtos): void
    {
        foreach ($retailerDisengageDtos as $retailerDisengageDto) {
            $this->disengageRetailerFromEpack(
                $epackage,
                $retailerDisengageDto->retailerId
            );
        }
    }

    public function disengageRetailerFromEpack(Epackage $epackage, string $retailerId): void
    {
        $epackageRetailer = $this->epackageRetailerRepository->getByEpackageAndRetailer($epackage->id, $retailerId);
        $this->epackageExtractor->clearEpackageRetailer($epackageRetailer);
        $this->epackageRetailerRepository->delete($epackageRetailer);
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

        $this->epackageRetailerRepository->save($epackageRetailer);
        $this->extractEpackageRetailerFiles($epackageRetailer);

        return $epackageRetailer;
    }

    public function update(Epackage $epackage, EpackageRetailerDto $epackageRetailerDto): void
    {
        $epackageRetailer = $this->epackageRetailerRepository->getByEpackageAndRetailer(
            $epackage->id,
            $epackageRetailerDto->retailerId
        );
        $epackageRetailerDto->id = $epackageRetailer->id;

        $this->validateEntity($epackageRetailerDto);

        $this->updateEpackageRetailer($epackageRetailer, $epackageRetailerDto);
    }

    public function updateEpackageRetailer(
        EpackageRetailer $epackageRetailer,
        EpackageRetailerDto $epackageRetailerDto
    ): void {
        $this->epackageExtractor->clearEpackageRetailer($epackageRetailer);

        $epackageRetailer->change(trim($epackageRetailerDto->skuId));

        $this->epackageRetailerRepository->save($epackageRetailer);

        $this->extractEpackageRetailerFiles($epackageRetailer);
    }

    protected function extractEpackageRetailerFiles(EpackageRetailer $epackageRetailer): void
    {
        if ($epackageRetailer->canExtract()) {
            $this->epackageExtractor->extractEpackageRetailer($epackageRetailer);
        }
    }
}
