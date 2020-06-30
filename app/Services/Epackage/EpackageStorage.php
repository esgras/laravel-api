<?php
declare(strict_types=1);

namespace App\Services\Epackage;

use App\Services\FilesystemService;
use Symfony\Component\HttpFoundation\File\File;

class EpackageStorage
{
    private string $extractedTemporaryPath;
    private FilesystemService $fs;

    public function __construct()
    {
        $this->extractedTemporaryPath = config('params.paths.temp');
        $this->fs = new FilesystemService();
    }

    /**
     * @param File $archiveFile
     * @return string
     * @throws \App\Exceptions\FileException
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
}
