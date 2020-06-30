<?php
declare(strict_types=1);

namespace App\Domain\Factory;

use App\Entities\Epackage;
use App\Repositories\FileRepository;
use App\Services\Dto\ManifestEntitiesDto;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use App\Entities\File;

class EpackageFactory
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function create(SymfonyFile $uploadedFile, ManifestEntitiesDto $manifestEntitiesDto): Epackage
    {
        $file = new File();
        $file->setFile($uploadedFile);
        $this->fileRepository->save($file);

        $manifestDto = $manifestEntitiesDto->manifestDto;

        $epackage = new Epackage();
        $epackage->cmsId = $manifestDto->emsId;
        $epackage->cmsPackId = $manifestDto->packageId;
        $epackage->mpn = $manifestDto->mpn;
        $epackage->ean = $manifestDto->ean;
        $epackage->productName = $manifestDto->productName;
        $epackage->file_id = $file->id;

        $epackage->brand_id = $manifestEntitiesDto->brand->id;

        return $epackage;
    }
}
