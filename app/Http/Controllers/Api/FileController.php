<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Entities\Brand;
use App\Entities\EpackageRetailer;
use App\Entities\File;
use App\Entities\Foo;
use App\Entities\Test;
use App\Events\BrandDeleted;
use App\Events\LogRow;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessEpackageAssign;
use App\Repositories\EpackageRetailerRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use App\Entities\Epackage;
use App\Entities\Retailer;

class FileController extends Controller
{
    public function eventTest(): Response
    {
        /** @todo QUEUE*/
        foreach (range(1, 10) as $number) {
            event(new LogRow((string)$number));
        }

        return new Response('Check file');
    }

    public function jobTest(): Response
    {

        $id = Epackage::query()->first()->id;
        ProcessEpackageAssign::dispatch($id);

        $logFile = storage_path('logs/queues.txt');
        $fs = new Filesystem();
        foreach (range(1, 10) as $number) {
            dispatch(fn() => $fs->append($logFile, $number . PHP_EOL));
        }

        return new Response('Check files');
    }

    public function foo(): JsonResponse
    {


        $brand = Brand::where('name', 'Philips')->first();
        $retailer = Retailer::where('name', 'Nord24')->first();

        $br = $brand->makeBrandRetailer($retailer);
        dd($br);

        event(new BrandDeleted($brand->id));
        dump(1);

        return new JsonResponse($brand);
    }

    public function morex(): Response
    {
        dd(1);
        $brand = Brand::query()->first();
        dd($brand);

        return new Response($foos->count());
    }

    public function test(EpackageRetailerRepository $epackageRetailerRepository): Response
    {
        $epackageId = '2f5c509c-fbee-4dbd-a100-c93362b1e52f';
        $epackage = Epackage::findOrFail($epackageId);
//        $retailerId = '0735ca91-80e3-4c2b-ab7c-a45f8e53358a';
        $retailerId = '11c09d8d-a2eb-40fe-8923-b250f416ae53';
        $retailer = Retailer::findOrFail($retailerId);

        $data = $epackageRetailerRepository->getByEpackageAndRetailer($epackage, $retailer);
        dd($data);

        dd(1);

        dd($this->getTest()->foos()->count());

        return new Response('x');
    }
}
