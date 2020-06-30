<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Factory\EpackageFactory;
use App\Entities\Epackage;
use App\Repositories\EpackageRepository;
use App\Services\Epackage\EpackageExtractor;
use App\Services\ManifestService;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class EpackageService
{
    use ValidationTrait;

    private EpackageRepository $epackageRepository;
    private ManifestService $manifestService;
    private EpackageFactory $epackageFactory;
    private EpackageExtractor $epackageExtractor;

    public function __construct(
        EpackageRepository $epackageRepository,
        ManifestService $manifestService,
        EpackageFactory $epackageFactory,
        EpackageExtractor $epackageExtractor
    ) {
        $this->epackageRepository = $epackageRepository;
        $this->manifestService = $manifestService;
        $this->epackageFactory = $epackageFactory;
        $this->epackageExtractor = $epackageExtractor;
    }

    public function get(string $id): Epackage
    {
        return $this->epackageRepository->get($id);
    }

    public function create(UploadedFile $file): Epackage
    {
        $epackage = $this->makeEpackage($file);
        $this->validateEntity($epackage);

        return $this->epackageRepository->save($epackage);
    }

    public function update(Epackage $epackage, UploadedFile $file): Epackage
    {
        $epackage = $this->makeEpackage($file, $epackage);
        $this->validateEntity($epackage);

        return $this->epackageRepository->save($epackage);
    }

    public function deleteEpack(Epackage $epackage): void
    {
        $this->epackageExtractor->clearEpackage($epackage);
        $this->epackageRepository->delete($epackage);
    }


    public function delete(string $id): void
    {
        $epackage = $this->epackageRepository->get($id);
        $this->epackageRepository->delete($epackage);
    }

    /**
     * @return Collection|Epackage[]
     */
    public function findAll(): Collection
    {
//        $data = $this->

        return $this->epackageRepository->findAll();
    }


    protected function makeEpackage(UploadedFile $file, ?Epackage $epackage = null): Epackage
    {
        $manifestEntities = $this->manifestService->loadManifestEntitiesByFile($file);

        return $epackage ? $epackage->change($file, $manifestEntities):
            $this->epackageFactory->create($file, $manifestEntities);
    }
}
