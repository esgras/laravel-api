<?php

namespace App\Jobs;

use App\Entities\EpackageRetailer;
use App\Repositories\EpackageRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessEpackageAssign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
//        , SerializesModels;

    private string $epackageId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $epackageId)
    {
        $this->epackageId = $epackageId;
    }

    /**
     * @param EpackageRepository $repository
     * @param Filesystem $fs
     * @throws NotFoundException
     */
    public function handle(EpackageRepository $repository, Filesystem $fs): void
    {
        try {
            /** @var EpackageRetailer $epackageRetailer */
            $epackageRetailer = EpackageRetailer::where('epackage_id', $this->epackageId)->firstOrFail();
            $logFile = storage_path('logs/epackage_retailers.txt');
            $logRow = sprintf(
                "Epackage %s Retailer %s skuId %s\n",
                $epackageRetailer->epackage_id,
                $epackageRetailer->retailer_id,
                $epackageRetailer->skuId
            );
            $fs->append($logFile, $logRow);
        } catch (Throwable $exception) {
            Log::error($exception->getMessage() . ' ' . $this->epackageId);
        }
    }
}
