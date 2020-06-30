<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\FileException;
use Illuminate\Filesystem\Filesystem;
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
//        bool $renameDirsToLowercase = false,
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

//        if ($renameDirsToLowercase) {
//            $this->renameSubdirsToLowerCase($absolutePath);
//        }

        $zip->close();
    }
}
