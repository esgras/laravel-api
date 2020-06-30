<?php
declare(strict_types=1);

namespace App\Services\Epackage;

use App\Entities\Epackage;
use App\Entities\EpackageRetailer;
use App\Exceptions\FileException;

class EpackageExtractor
{
    private EpackageStorage $epackageStorage;

    public function __construct(EpackageStorage $epackageStorage)
    {
        $this->epackageStorage = $epackageStorage;
    }

    /**
     * @param Epackage $epackage
     * @throws FileException
     */
    public function extractEpackage(Epackage $epackage): void
    {
        foreach ($epackage->epackageRetailers as $epackageRetailer) {
            $this->extractEpackageRetailer($epackageRetailer);
        }
    }

    public function clearEpackage(Epackage $epackage): void
    {
        foreach ($epackage->epackageRetailers as $epackageRetailer) {
            $this->clearEpackageRetailer($epackageRetailer);
        }
    }

    /**
     * @param EpackageRetailer $epackageRetailer
     * @throws FileException
     */
    public function extractEpackageRetailer(EpackageRetailer $epackageRetailer): void
    {
        if ($epackageRetailer->isActive()) {
            $this->epackageStorage->extractEpackageRetailerArchive($epackageRetailer);
        }
    }

    public function clearEpackageRetailer(EpackageRetailer $epackageRetailer): void
    {
        if (!$epackageRetailer->isActive()) {
            return;
        }

        $this->epackageStorage->removeByEpackageLink($epackageRetailer->epackageLink);
    }
}
