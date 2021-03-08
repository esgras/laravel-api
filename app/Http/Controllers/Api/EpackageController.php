<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Domain\Services\EpackageRetailerService;
use App\Domain\Services\EpackageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\EpackageRequest;
use App\Http\Requests\EpackageRetailerRequest;
use App\Http\Requests\RetailerAssignRequest;
use App\Http\Requests\RetailerDisengageRequest;
use App\Http\Resources\EpackageResource;
use App\Traits\ValidationTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

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
            new EpackageResource($this->epackageService->create($request->file('archive')))
        );
    }

    public function update(string $id, EpackageRequest $request): JsonResponse
    {
        $epackage = $this->epackageService->get($id);

        return $this->jsonResponse(
            new EpackageResource($this->epackageService->update($epackage, $request->file('archive')))
        );
    }

    public function find(string $id): JsonResponse
    {
        return $this->jsonResponse(
            new EpackageResource($this->epackageService->get($id))
        );
    }

    public function delete(string $id): JsonResponse
    {
        $epackage = $this->epackageService->get($id);
        $this->epackageService->deleteEpack($epackage);

        return $this->jsonResponse(null, Response::HTTP_OK, "Epackage {$id} successfully deleted");
    }

    public function findAll(): JsonResponse
    {
        return $this->jsonResponse(
            EpackageResource::collection($this->epackageService->findAll())
        );
    }

    public function assignRetailers(
        string $id,
        RetailerAssignRequest $request,
        EpackageRetailerService $epackageRetailerService
    ): JsonResponse {
        $epackage = $this->epackageService->get($id);
        $retailerAssignDtos = $request->getDtos();

        foreach ($retailerAssignDtos as $retailerAssignDto) {
            $retailerAssignDto->epackageId = $id;
            $this->validateEntity($retailerAssignDto);
        }

        $epackageRetailerService->assignRetailersToEpack($epackage, $retailerAssignDtos);

        return $this->jsonResponse(true);
    }

    /**
     * @param string $id
     * @param RetailerDisengageRequest $request
     * @param EpackageRetailerService $epackageRetailerService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function retailersDisengage(
        string $id,
        RetailerDisengageRequest $request,
        EpackageRetailerService $epackageRetailerService
    ): JsonResponse {
        $epackage = $this->epackageService->get($id);
        $retailerDisengageDtos = $request->getDtos();

        foreach ($retailerDisengageDtos as $retailerDisengageDto) {
            $this->validateEntity($retailerDisengageDto);
        }

        $epackageRetailerService->disengageRetailersFromEpack($epackage, $retailerDisengageDtos);

        return $this->jsonResponse(true);
    }

    public function retailerUpdate(
        string $id,
        string $retailerId,
        EpackageRetailerRequest $request,
        EpackageRetailerService $epackageRetailerService
    ): JsonResponse {
        $epackage = $this->epackageService->get($id);

        $epackageRetailerDto = $request->getDto();
        $epackageRetailerDto->retailerId = $retailerId;

        $epackageRetailerService->update($epackage, $epackageRetailerDto);

        return $this->jsonResponse(true);
    }

}
