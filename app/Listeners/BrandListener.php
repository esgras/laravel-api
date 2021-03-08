<?php

namespace App\Listeners;

use App\Domain\Services\EpackageService;
use App\Events\BrandDeleted;
use App\Repositories\BrandRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BrandListener
{
    private BrandRepository $brandRepository;
    private EpackageService $epackageService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BrandRepository $brandRepository, EpackageService $epackageService)
    {
        $this->brandRepository = $brandRepository;
        $this->epackageService = $epackageService;
    }

    /**
     * Handle the event.
     *
     * @param  BrandDeleted  $event
     * @return void
     */
    public function handle(BrandDeleted $event)
    {
        $brand = $this->brandRepository->get($event->getId());
        foreach ($brand->epackages as $epackage) {
            $this->epackageService->deleteEpack($epackage);
        }
    }
}
