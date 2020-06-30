<?php
declare(strict_types=1);

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse extends JsonResponse
{
//    private int $code;
//    private bool $success;
//    private string $message;
//    private string $error;
//    private $data;

    public function __construct($data, int $code, string $message, string $error, bool $success)
    {
        parent::__construct(compact('success', 'code', 'message', 'error', 'data'), $code);
    }

    public static function success($data, string $message, int $code=Response::HTTP_OK): self
    {
        return new self($data, $code, $message, '', true);
    }

    public static function error(string $error, int $code=Response::HTTP_BAD_REQUEST): self
    {
        return new self(null, $code, '', $error, false);
    }
//
//    /**
//     * @return int
//     */
//    public function getCode(): int
//    {
//        return $this->code;
//    }
//
//    /**
//     * @param int $code
//     * @return ApiResponse
//     */
//    public function setCode(int $code): self
//    {
//        $this->code = $code;
//        return $this;
//    }
//
//    /**
//     * @return bool
//     */
//    public function getSuccess(): bool
//    {
//        return $this->success;
//    }
//
//    /**
//     * @param bool $success
//     * @return ApiResponse
//     */
//    public function setSuccess(bool $success): self
//    {
//        $this->success = $success;
//        return $this;
//    }
//
//    /**
//     * @return string
//     */
//    public function getMessage(): string
//    {
//        return $this->message;
//    }
//
//    /**
//     * @param string $message
//     * @return ApiResponse
//     */
//    public function setMessage(string $message): self
//    {
//        $this->message = $message;
//        return $this;
//    }
//
//    /**
//     * @return string
//     */
//    public function getError(): string
//    {
//        return $this->error;
//    }
//
//    /**
//     * @param string $error
//     * @return ApiResponse
//     */
//    public function setError(string $error): self
//    {
//        $this->error = $error;
//        return $this;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getData($assoc = true, $depth = 512)
//    {
//        return $this->data;
//    }
//
//    /**
//     * @param mixed $data
//     * @return ApiResponse
//     */
//    public function setData($data=[])
//    {
//        $this->data = $data;
//        return $this;
//    }


}
