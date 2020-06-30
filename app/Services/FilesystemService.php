<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\FileException;
use FilesystemIterator;
use Illuminate\Filesystem\Filesystem;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\HttpFoundation\File\File;
use ZipArchive;

class FilesystemService extends Filesystem
{
    /**
     * @param File $archive
     * @param string $absolutePath
     * @param bool $clearFiles
     * @throws FileException
     */
    public function extractByPath(
        File $archive,
        string $absolutePath,
        bool $renameDirsToLowercase = false,
        bool $clearFiles = false
    ): void {
        $filename = $archive->getRealPath();
        if ($filename === false) {
            throw new FileException(
                sprintf("File %s doesn't exits", $archive->getPathname())
            );
        }

        $zip = new ZipArchive();

        $res = $zip->open($filename);

        if ($res !== true) {
            throw new FileException('Can\'t open archive file');
        }

        if ($clearFiles) {
            $this->cleanDirectory($absolutePath);
        }

        if (!$zip->extractTo($absolutePath)) {
            throw new FileException("Can't extract archive file by path ${absolutePath}");
        }

        if ($renameDirsToLowercase) {
            $this->renameSubdirsToLowerCase($absolutePath);
        }

        $zip->close();
    }

    public function renameSubdirsToLowerCase(string $path): void
    {
        $it = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
        $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($it as $file) {
            $lowercaseBaseName = mb_strtolower($file->getBaseName());
            $destinationPath = $file->getPath() . '/' . $lowercaseBaseName;
            if ($file->isDir() && $lowercaseBaseName !== $file->getBaseName()) {
                if ($this->isDirectory($destinationPath)) {
                    $this->deleteDirectory($destinationPath);
                }

                // rename directory to lowercase
                $this->move($file->getPathName(), $destinationPath);
            }
        }
    }
}
