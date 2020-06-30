<?php

namespace App\Http\Controllers;

use App\Http\Response\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function jsonResponse(
        $data,
        $status = Response::HTTP_OK,
        $message = '',
        $error = '',
        $success = true
    ): JsonResponse {
        $apiResponse = new ApiResponse($data, $status, $message, $error, $success);

        return $apiResponse;

//        return $this->json($apiResponse, $status, [], [AbstractNormalizer::IGNORED_ATTRIBUTES => ['pagination']]);
    }
}
