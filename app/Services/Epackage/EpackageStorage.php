<?php
declare(strict_types=1);

namespace App\Services\Epackage;

use App\Entities\EpackageRetailer;
use App\Services\FilesystemService;
use Symfony\Component\HttpFoundation\File\File;
use App\Exceptions\FileException;

class EpackageStorage
{
    private string $extractedTemporaryPath;
    private string $packagesDir;
    private FilesystemService $fs;

    public function __construct()
    {
        $this->extractedTemporaryPath = config('params.paths.temp');
        $this->packagesDir = config('params.paths.packages_dir');
        $this->fs = new FilesystemService();
    }

    /**
     * @param File $archiveFile
     * @return string
     * @throws FileException
     */
    public function extractByTemporaryPath(File $archiveFile): string
    {
        $absolutePath = $this->extractedTemporaryPath . '/' . uniqid();
        $this->fs->extractByPath($archiveFile, $absolutePath);

        return $absolutePath;
    }

    public function removeByAbsolutePath(string $path): void
    {
        $this->fs->deleteDirectory($path);
    }

    /**
     * @param EpackageRetailer $epackageRetailer
     * @throws FileException
     */
    public function extractEpackageRetailerArchive(EpackageRetailer $epackageRetailer): void
    {
        if (!$epackageRetailer->epackageLink) {
            return;
        }

        $this->extractByExtractedPath(
            $epackageRetailer->epackage->getArchiveFile(),
            $epackageRetailer->epackageLink
        );
    }

    /**
     * @param File $archiveFile
     * @param string $extractedPath
     * @return string
     * @throws FileException
     */
    public function extractByExtractedPath(File $archiveFile, string $extractedPath): string
    {
        $absolutePath = $this->packagesDir . $extractedPath;

        $this->fs->extractByPath($archiveFile, $absolutePath, true, true);

//        $this->linkReplacer->replaceByExtractedPath($absolutePath);

        return $absolutePath;
    }

    public function removeByEpackageLink(string $epackageLink): void
    {
        $this->fs->deleteDirectory(
            $this->makeEpackageLinkPath($epackageLink)
        );
    }

    protected function makeEpackageLinkPath(string $epackageLink): string
    {
        return $this->packagesDir . $epackageLink;
    }
}
