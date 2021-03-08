<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Domain\Services\BrandService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Services\Dto\BrandDto;
use App\Traits\ValidationTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    use ValidationTrait;

    private BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function find(string $id): JsonResponse
    {
        return $this->jsonResponse(
            $this->brandService->get($id)
        );
    }

    /**
     * @param BrandRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(BrandRequest $request): JsonResponse
    {

        $brandDto = $request->getDto();
        $this->validateEntity($brandDto);

        return $this->jsonResponse(
            $this->brandService->create($brandDto)
        );
    }

    /**
     * @param string $id
     * @param BrandRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(string $id, BrandRequest $request): JsonResponse
    {
        $brand = $this->brandService->get($id);
        $brandDto = $request->getDto();
        $this->validateDto($brandDto, $id);

        return $this->jsonResponse(
            $this->brandService->update($brand, $brandDto)
        );
    }

    public function delete(string $id): JsonResponse
    {
        $this->brandService->delete($id);

        return $this->jsonResponse(null, Response::HTTP_OK, "Brand {$id} successfully deleted");
    }

    public function findAll(): JsonResponse
    {
        return $this->jsonResponse(
            $this->brandService->findAll()
        );
    }


    public function deactivateRetailer(string $id, string $retailerId): JsonResponse
    {
        return $this->jsonResponse(
            $this->brandService->deactivateRetailer($id, $retailerId)
        );
    }

    public function activateRetailer(string $id, string $retailerId): JsonResponse
    {
        return $this->jsonResponse(
            $this->brandService->activateRetailer($id, $retailerId)
        );
    }

    /**
     * @param BrandDto $brandDto
     * @param string $id
     * @throws ValidationException
     */
    protected function validateDto(BrandDto $brandDto, string $id=''): void
    {
        $brandDto->id = $id;
        $this->validateEntity($brandDto);
    }
}
