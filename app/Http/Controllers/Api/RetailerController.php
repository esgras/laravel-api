<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Domain\Services\RetailerService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RetailerRequest;
use App\Services\Dto\BrandDto;
use App\Services\Dto\RetailerDto;
use App\Traits\ValidationTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class RetailerController extends Controller
{
    use ValidationTrait;

    private RetailerService $retailerService;

    public function __construct(RetailerService $retailerService)
    {
        $this->retailerService = $retailerService;
    }

    public function find(string $id): JsonResponse
    {
        return $this->jsonResponse(
            $this->retailerService->get($id)
        );
    }

    /**
     * @param RetailerRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(RetailerRequest $request): JsonResponse
    {
        $retailerDto = $request->getDto();
        $this->validateEntity($retailerDto);

        return $this->jsonResponse(
            $this->retailerService->create($retailerDto)
        );
    }

    /**
     * @param string $id
     * @param RetailerRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(string $id, RetailerRequest $request): JsonResponse
    {
        $brand = $this->retailerService->get($id);
        $retailerDto = $request->getDto();
        $this->validateDto($retailerDto, $id);

        return $this->jsonResponse(
            $this->retailerService->update($brand, $retailerDto)
        );
    }

    public function delete(string $id): JsonResponse
    {
        $this->retailerService->delete($id);

        return $this->jsonResponse(null, Response::HTTP_OK, "Retailer {$id} successfully deleted");
    }

    public function findAll(): JsonResponse
    {
        return $this->jsonResponse(
            $this->retailerService->findAll()
        );
    }

    /**
     * @param RetailerDto $retailerDto
     * @param string $id
     * @throws ValidationException
     */
    protected function validateDto(RetailerDto $retailerDto, string $id=''): void
    {
        $retailerDto->id = $id;
        $this->validateEntity($retailerDto);
    }
}
