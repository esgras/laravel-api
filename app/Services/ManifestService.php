<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\FileException;
use App\Repositories\BrandRepository;
use App\Services\Dto\ManifestDto;
use App\Services\Dto\ManifestEntitiesDto;
use App\Services\Epackage\EpackageStorage;
use Symfony\Component\HttpFoundation\File\File;
use App\Traits\ValidationTrait;

class ManifestService
{
    use ValidationTrait;

    public const MANIFEST_FILE = 'manifest.json';

    private EpackageStorage $epackageStorage;
    private FilesystemService $fs;
    private BrandRepository $brandRepository;

    public function __construct(
        EpackageStorage $epackageStorage,
        FilesystemService $fs,
        BrandRepository $brandRepository
    ) {
        $this->epackageStorage = $epackageStorage;
        $this->fs = $fs;
        $this->brandRepository = $brandRepository;
    }

    public function loadManifestByFile(File $uploadedArchive): ManifestDto
    {
        $epackExtractedPath = $this->epackageStorage->extractByTemporaryPath($uploadedArchive);

        try {
            $manifestDto = $this->getDto($epackExtractedPath);
            $this->validateEntity($manifestDto);

            return $manifestDto;
        } finally {
            $this->epackageStorage->removeByAbsolutePath($epackExtractedPath);
        }
    }

    public function loadManifestEntitiesByFile(File $uploadedArchive): ManifestEntitiesDto
    {
        $dto = new ManifestEntitiesDto();
        $dto->manifestDto = $this->loadManifestByFile($uploadedArchive);
        $dto->brand = $this->brandRepository->getByName($dto->manifestDto->brandName);

        return $dto;
    }


    /**
     * @param string $manifestDir
     * @return array
     * @throws FileException
     */
    protected function getDto(string $manifestDir): ManifestDto
    {
        $manifestFile = rtrim($manifestDir, '/') . '/' . self::MANIFEST_FILE;

        if (!$this->fs->exists($manifestFile) || !$this->fs->isWritable($manifestFile)) {
            throw new FileException('Can\'t read manifest file');
        }
        $manifestData = json_decode(file_get_contents($manifestFile), true);
        if (!$manifestData) {
            throw new FileException('Wrong ' . self::MANIFEST_FILE . ' format');
        }

        $manifestDto = new ManifestDto();
        $manifestDto->emsId = $manifestData['emsId'];
        $manifestDto->packageId = $manifestData['packageID'];
        $manifestDto->brandName = $manifestData['productData']['brandName'];
        $manifestDto->productName = $manifestData['productData']['productName'];
        $manifestDto->mpn = $manifestData['productData']['MPN'];
        $manifestDto->ean = $manifestData['productData']['EAN'];
        $manifestDto->data = $manifestData['data'];

        return $manifestDto;
    }
}
