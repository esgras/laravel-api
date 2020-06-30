<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Domain\Services\EpackageRetailerService;
use App\Domain\Services\EpackageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\EpackageRequest;
use App\Http\Requests\RetailerAssignRequest;
use App\Traits\ValidationTrait;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EpackageController extends Controller
{
    use ValidationTrait;

    private EpackageService $epackageService;

    public function __construct(EpackageService $epackageService)
    {
        $this->epackageService = $epackageService;
    }

    public function upload(EpackageRequest $request): JsonResponse
    {
        return $this->jsonResponse(
            $this->epackageService->create($request->file('archive'))
        );
    }

    public function update(string $id, EpackageRequest $request): JsonResponse
    {
        $epackage = $this->epackageService->get($id);

        return $this->jsonResponse(
            $this->epackageService->update($epackage, $request->file('archive'))
        );
    }

    public function find(string $id): JsonResponse
    {
        return $this->jsonResponse(
            $this->epackageService->get($id)
        );
    }

    public function delete(string $id): JsonResponse
    {
        $this->epackageService->delete($id);

        return $this->jsonResponse(null, Response::HTTP_OK, "Epackage {$id} successfully deleted");
    }

    public function findAll(): JsonResponse
    {
        return $this->jsonResponse(
            $this->epackageService->findAll()
        );
    }

    public function assignRetailer(
        string $id,
        RetailerAssignRequest $request,
        EpackageRetailerService $epackageRetailerService
    ): JsonResponse {
        $epackage = $this->epackageService->get($id);
        $retailerAssignDtos = $request->getDtos();

        foreach ($retailerAssignDtos as $retailerAssignDto) {
            $retailerAssignDto->id = $id;
            $this->validateEntity($retailerAssignDto);
        }

        $epackageRetailerService->assignRetailersToEpack($epackage, $retailerAssignDtos);

        return $this->jsonResponse(true);
    }
}
