<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\File;

class FileRepository
{
    public function save(File $file): File
    {
        $file->save();
        return $file;
    }
}
